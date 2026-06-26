<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePessoaRequest;
use App\Http\Requests\UpdatePessoaRequest;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Person;
use App\Models\Image;
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
        // $fotoPrincipalIndex = $request->input('principal_index', 0);
        $arquivos = $request->file('imagens', []);
        $caminhos = [];
        // Faz upload de todos os arquivos antes da transação
        foreach ($arquivos as $arquivo) {
            $caminhos[] = $arquivo->store('imagens_pessoas', 'public');
        }
        try {
            DB::transaction(function () use ($dados, $caminhos, $profissoes) {

                $pessoa = Person::create($dados);

                foreach ($caminhos as $i => $caminho) {
                    $imagem = Image::create([
                        'caminho' => $caminho,
                        'nome' => 'Imagem de ' . $pessoa->nome,
                    ]);

                    $pessoa->images()->attach($imagem->id);
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
    public function update(UpdatePessoaRequest $request, $id)
    {
        $pessoa = Person::with(['actor', 'director', 'writer', 'producer'])->findOrFail($id);

        $dados = $request->validated();

        DB::transaction(function () use ($pessoa, $dados) {

            $profissoes = $dados['profissoes'] ?? [];

            unset($dados['profissoes']);

            $pessoa->update($dados);

            // Ator
            if (in_array('1', $profissoes)) {
                Actor::firstOrCreate([
                    'person_id' => $pessoa->id
                ]);
            } else {
                $pessoa->actor?->delete();
            }

            // Diretor
            if (in_array('2', $profissoes)) {
                Director::firstOrCreate([
                    'person_id' => $pessoa->id
                ]);
            } else {
                $pessoa->director?->delete();
            }

            // Produtor
            if (in_array('3', $profissoes)) {
                Producer::firstOrCreate([
                    'person_id' => $pessoa->id
                ]);
            } else {
                $pessoa->producer?->delete();
            }

            // Escritor
            if (in_array('4', $profissoes)) {
                Writer::firstOrCreate([
                    'person_id' => $pessoa->id
                ]);
            } else {
                $pessoa->writer?->delete();
            }
        });

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
        $pessoa = Person::findOrFail($id);
        return view('pessoas.show-public', compact('pessoa'));
    }

    public function buscar(Request $request)
    {
        $termo = trim($request->input('q', ''));
        $filmeId = $request->input('filme_id');
        if (strlen($termo) < 2) {
            return response()->json([]);
        }
        $pessoas = Person::with('images')->where('nome', 'ilike', "%{$termo}%")
            ->limit(8)
            ->get(['id', 'nome']);

        // Indica quais tipos de vínculo a pessoa já tem no filme
        return response()->json($pessoas->map(function ($p) use ($filmeId) {
            $vinculos = [];
            if ($filmeId) {
                if ($p->actors?->filmes()->where('filme_id', $filmeId)->exists())
                    $vinculos[] = 'ator';

                if ($p->directors?->filmes()->where('filme_id', $filmeId)->exists())
                    $vinculos[] = 'diretor';

                if ($p->producers?->filmes()->where('filme_id', $filmeId)->exists())
                    $vinculos[] = 'produtor';

                if ($p->writers?->filmes()->where('filme_id', $filmeId)->exists())
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
}
