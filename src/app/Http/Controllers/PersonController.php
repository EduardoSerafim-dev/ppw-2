<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePessoaRequest;
use App\Http\Requests\UpdatePessoaRequest;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Person;
use App\Models\Image;
use App\Models\Movie;
use App\Models\Producer;
use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pessoas = Person::orderBy('nome')->get();
        return view("pessoas.index", compact("pessoas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pessoas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePessoaRequest $request)
    {

        $dados = $request->validated();
        $profissoes = $request->input('profissoes');
        $principalIndex = $request->input('principal_index', 0);
        $arquivos = $request->file('imagens', []);
        $caminhos = [];
        // Faz upload de todos os arquivos antes da transação
        foreach ($arquivos as $arquivo) {
            $caminhos[] = $arquivo->store('imagens', 'public');
        }
        try {
            DB::transaction(function () use ($dados, $caminhos, $profissoes, $principalIndex, $request) {

                $pessoa = Person::create($dados);


                foreach ($caminhos as $i => $caminho) {
                    $imagem = Image::create([
                        'caminho' => $caminho,
                        'nome' => 'Imagem de ' . $pessoa->nome,
                    ]);

                    $pessoa->images()->attach($imagem->id, [
                        'principal' => ($i === (int) $principalIndex),
                    ]);
                }

                foreach ($profissoes as $profissao) {

                    switch ($profissao) {

                        case '1':
                            Actor::create([
                                'person_id' => $pessoa->id
                            ]);
                            break;

                        case '2':
                            Director::create([
                                'person_id' => $pessoa->id
                            ]);
                            break;

                        case '3':
                            Producer::create([
                                'person_id' => $pessoa->id
                            ]);
                            break;

                        case '4':
                            Writer::create([
                                'person_id' => $pessoa->id
                            ]);
                            break;
                    }
                }
                $this->sincronizarVinculos($pessoa, $request->input('vinculos', []));
            });
        } catch (\Exception $e) {
            foreach ($caminhos as $caminho) {
                Storage::disk('public')->delete($caminho);
            }
            return back()->with('erro', 'Erro ao salvar. Tente novamente.');
        }

        return redirect('/pessoas')->with('sucesso', 'Pessoa cadastrada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pessoa = Person::with(['images'])->findOrFail($id);

        $profissoes = [];

        if ($pessoa->actor) {
            $profissoes[] = 'Ator';
        }
        if ($pessoa->director) {
            $profissoes[] = 'Diretor';
        }
        if ($pessoa->producer) {
            $profissoes[] = 'Produtor';
        }
        if ($pessoa->writer) {
            $profissoes[] = 'Escritor';
        }

        return view('pessoas.show', compact('pessoa', 'profissoes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pessoa = Person::with([
            'images',
            'actor',
            'director',
            'writer',
            'producer'
        ])->findOrFail($id);

        return view('pessoas.edit', compact('pessoa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePessoaRequest $request, string $id)
    {
        $pessoa = Person::with([
            'actor',
            'director',
            'writer',
            'producer',
            'images'
        ])->findOrFail($id);

        $arquivos = $request->file('imagens', []);
        $caminhos = [];

        foreach ($arquivos as $arquivo) {
            $caminhos[] = $arquivo->store('imagens', 'public');
        }

        try {

            DB::transaction(function () use ($pessoa, $request, $caminhos) {

                $pessoa->update($request->validated());

                $profissoes = $request->input('profissoes', []);

                //  Atualiza imagem principal existente -----------------------

                if ($request->filled('principal_imagem_id')) {

                    $pessoa->images()->updateExistingPivot(
                        $pessoa->images->pluck('id'),
                        ['principal' => false]
                    );

                    $pessoa->images()->updateExistingPivot(
                        $request->principal_imagem_id,
                        ['principal' => true]
                    );
                }

                // Adiciona novas imagens ---------------------------

                if (!empty($caminhos)) {

                    $principalIndex = $request->input('principal_index');

                    // Se alguma nova imagem será principal,
                    // desmarca todas as anteriores
                    if ($principalIndex !== null) {

                        $pessoa->images()->updateExistingPivot(
                            $pessoa->images->pluck('id'),
                            ['principal' => false]
                        );
                    }

                    foreach ($caminhos as $i => $caminho) {

                        $imagem = Image::create([
                            'caminho' => $caminho,
                            'nome' => 'Imagem de ' . $pessoa->nome
                        ]);

                        $pessoa->images()->attach($imagem->id, [
                            'principal' => ($i === (int) $principalIndex)
                        ]);
                    }
                }

                //Profissões -----------------

                if (in_array('1', $profissoes)) {
                    Actor::firstOrCreate([
                        'person_id' => $pessoa->id
                    ]);
                } else {
                    $pessoa->actor?->delete();
                }

                if (in_array('2', $profissoes)) {
                    Director::firstOrCreate([
                        'person_id' => $pessoa->id
                    ]);
                } else {
                    $pessoa->director?->delete();
                }

                if (in_array('3', $profissoes)) {
                    Producer::firstOrCreate([
                        'person_id' => $pessoa->id
                    ]);
                } else {
                    $pessoa->producer?->delete();
                }

                if (in_array('4', $profissoes)) {
                    Writer::firstOrCreate([
                        'person_id' => $pessoa->id
                    ]);
                } else {
                    $pessoa->writer?->delete();
                }

                // 1. Remover vínculos marcados
                foreach ($request->input('remover_vinculos', []) as $relacao => $filmes) {
                    if (!$pessoa->$relacao) {
                        continue;
                    }
                    $pessoa->$relacao->movies()->detach($filmes);
                }

                // 2. Atualizar personagem dos atores existentes
                foreach ($request->input('filmes_existentes', []) as $filmeId => $dados) {
                    $pessoa->actor?->movies()->updateExistingPivot(
                        $filmeId,
                        ['papel' => $dados['personagem'] ?? null]
                    );
                }

                // 3. Adicionar novos vínculos (mesmo método do store)
                $this->sincronizarVinculos($pessoa, $request->input('vinculos', []));
            });
        } catch (\Exception $e) {

            foreach ($caminhos as $caminho) {
                Storage::disk('public')->delete($caminho);
            }

            return back()->with('erro', 'Erro ao atualizar a pessoa.');
        }

        return redirect('/pessoas/' . $pessoa->id)
            ->with('sucesso', 'Pessoa atualizada!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pessoa = Person::with('images')->findOrFail($id);

        foreach ($pessoa->images as $imagem) {

            Storage::disk('public')->delete($imagem->caminho);
            $imagem->delete();
        }
        $pessoa->delete();

        return redirect('/pessoas')
            ->with('sucesso', 'Pessoa excluída!');
    }

    public function show_public(string $id)
    {
        $pessoa = Person::with(['images'])->findOrFail($id);

        $profissoes = [];
        if ($pessoa->actor) {
            $profissoes[] = 'Ator';
        }
        if ($pessoa->director) {
            $profissoes[] = 'Diretor';
        }
        if ($pessoa->producer) {
            $profissoes[] = 'Produtor';
        }
        if ($pessoa->writer) {
            $profissoes[] = 'Escritor';
        }

        return view('pessoas.show-public', compact('pessoa', 'profissoes'));
    }

    public function buscar(Request $request)
    {
        $termo = trim($request->input('q', ''));
        $filmeId = $request->input('filme_id');
        if (strlen($termo) < 2) {
            return response()->json([]);
        }
        $pessoas = Person::with('images', 'actor', 'director', 'writer', 'producer')->where('nome', 'ilike', "%{$termo}%")
            ->limit(8)
            ->get(['id', 'nome']);

        // Indica quais tipos de vínculo a pessoa já tem no filme
        return response()->json($pessoas->map(function ($p) use ($filmeId) {
            $vinculos = [];
            if ($filmeId) {
                if ($p->actor?->movies()->where('movie_id', $filmeId)->exists())
                    $vinculos[] = 'ator';

                if ($p->director?->movies()->where('movie_id', $filmeId)->exists())
                    $vinculos[] = 'diretor';

                if ($p->producer?->movies()->where('movie_id', $filmeId)->exists())
                    $vinculos[] = 'produtor';

                if ($p->writer?->movies()->where('movie_id', $filmeId)->exists())
                    $vinculos[] = 'escritor';
            }

            $profissoes = [];

            if ($p->actor) {
                $profissoes[] = 'Ator';
            }
            if ($p->director) {
                $profissoes[] = 'Diretor';
            }
            if ($p->producer) {
                $profissoes[] = 'Produtor';
            }
            if ($p->writer) {
                $profissoes[] = 'Escritor';
            }

            return [
                'id' => $p->id,
                'nome' => $p->nome,
                'foto' => $p->images->first()?->caminho,
                'vinculos' => $vinculos,
                'profissoes' => $profissoes
            ];
        }));
    }


    // Método auxiliar privado — reutilizado no update()
    private function sincronizarVinculos(Person $pessoa, array $vinculos): void
    {
        foreach ($vinculos as $v) {
            $filmeId = $v['filme_id'] ?? null;
            $filme = Movie::find($filmeId);
            $tipo = $v['tipo'] ?? null;
            $personagem = $v['personagem'] ?? null;
            if (!$filme || !$tipo) continue;
            match ($tipo) {
                'ator' => $filme->actors()->syncWithoutDetaching([
                    $pessoa->actor->id => ['papel' => $personagem]
                ]),
                'diretor' => $filme->directors()->syncWithoutDetaching([$pessoa->director->id]),
                'produtor' => $filme->producers()->syncWithoutDetaching([$pessoa->producer->id]),
                'escritor' => $filme->writers()->syncWithoutDetaching([$pessoa->writer->id]),
                default => null,
            };
        }
    }
}
