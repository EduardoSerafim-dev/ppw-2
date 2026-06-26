<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilmeRequest;
use App\Http\Requests\UpdateFilmeRequest;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Image;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $busca = trim($request->input('busca', ''));
        $genero = $request->input('genero');
        $ano = $request->input('ano');
        $ordem = $request->input('ordem', 'nome');
        $filmes = Movie::with(['genres'])
            // Busca por título — só aplica se $busca não for vazio
            ->when(
                $busca,
                fn($q) =>
                $q->where('nome', 'ilike', "%{$busca}%")
            )
            // Filtro por gênero — só aplica se $genero não for nulo
            ->when(
                $genero,
                fn($q) =>
                $q->whereHas('genres', fn($g) => $g->where('genres.id', $genero))
            )
            // Filtro por ano — só aplica se $ano não for nulo
            ->when(
                $ano,
                fn($q) =>
                $q->where('data_lancamento', $ano)
            )
            // Ordenação dinâmica
            ->when(
                $ordem === 'ano',
                fn($q) => $q->orderBy('data_lancamento', 'desc'),
                fn($q) => $q->orderBy('nome')
            )
            ->paginate(12)
            ->withQueryString(); // preserva os filtros nos links de paginação

        $generos = Genre::orderBy('nome')->get();
        return view('filmes.index', compact('filmes', 'generos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $generos = Genre::orderBy('nome')->get();
        return view('filmes.create', compact('generos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmeRequest $request)
    {
        $dados = $request->validated();
        $generos = $request->input('generos');
        $posterIndex = $request->input('poster_index', 0);
        $arquivos = $request->file('imagens', []);
        $caminhos = [];
        // Faz upload de todos os arquivos antes da transação
        foreach ($arquivos as $arquivo) {
            $caminhos[] = $arquivo->store('imagens', 'public');
        }
        try {
            DB::transaction(function () use ($dados, $generos, $caminhos, $posterIndex, $request) {
                $filme = Movie::create($dados);
                $this->sincronizarVinculos($filme, $request->input('vinculos', []));

                foreach ($caminhos as $i => $caminho) {
                    $imagem = Image::create([
                        'caminho' => $caminho,
                        'nome' => 'Imagem de ' . $filme->nome,
                    ]);
                    // Associa ao filme com pivot poster
                    $filme->images()->attach($imagem->id, [
                        'poster' => ($i === (int) $posterIndex),
                    ]);
                }

                $filme->genres()->attach($generos);
            });
        } catch (\Exception $e) {
            foreach ($caminhos as $caminho) {
                Storage::disk('public')->delete($caminho);
            }
            return back()->with('erro', 'Erro ao salvar. Tente novamente.');
        }

        return redirect('/filmes')->with('sucesso', 'Filme cadastrado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $filme = Movie::with(['actors.person', 'directors.person', 'producers.person', 'writers.person', 'genres', 'images'])->findOrFail($id);
        // Carrega as avaliações com os usuários já incluídos
        $avaliacoes = $filme->reviews()->with('user')->orderBy('created_at', 'desc')->get();
        return view('filmes.show', compact('filme', 'avaliacoes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $filme = Movie::with(['actors.person', 'directors.person', 'producers.person', 'writers.person', 'genres', 'images'])->findOrFail($id);
        $generos = Genre::orderBy('nome')->get();
        return view('filmes.edit', compact('filme', 'generos'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateFilmeRequest $request, int $id)
    // {
    //     $filme = Movie::findOrFail($id);

    //     $dados = $request->validated();

    //     // Remove poster dos dados do Movie
    //     unset($dados['poster']);

    //     $imagem = $filme->images->first();

    //     // Remove imagem antiga
    //     if ($imagem && $imagem->caminho) {
    //         Storage::disk('public')->delete($imagem->caminho);
    //     }

    //     // Salva nova imagem
    //     $caminho = $request->file('poster')
    //         ->store('posters', 'public');

    //     // Atualiza registro da imagem
    //     if ($imagem) {
    //         $imagem->update([
    //             'caminho' => $caminho,
    //             'nome' => 'Poster de ' . $filme->nome
    //         ]);
    //     }
    //     $filme->update($dados);
    //     return redirect('/filmes/' . $id)->with('sucesso', 'Atualizado!');
    // }


    // Processa a atualização
    public function update(UpdateFilmeRequest $request, int $id)
    {
        $filme = Movie::findOrFail($id);
        $filme->update($request->validated());

        // 1. Atualiza qual imagem é o poster
        if ($request->filled('poster_imagem_id')) {

            // Desmarca todos os posters do filme
            $filme->images()->updateExistingPivot(
                $filme->images->pluck('id'),
                ['poster' => false]
            );
            // Marca a imagem selecionada como poster
            $filme->images()->updateExistingPivot(
                $request->poster_imagem_id,
                ['poster' => true]
            );
        }
        // 2. Adiciona novas imagens (se enviadas)
        if ($request->hasFile('imagens')) {
            $posterIndex = $request->input('poster_index');
            foreach ($request->file('imagens') as $i => $arquivo) {
                $caminho = $arquivo->store('imagens', 'public');
                $imagem = Image::create(['caminho' => $caminho, 'nome' => 'Imagem de ' . $filme->nome]);
                $filme->images()->attach($imagem->id, ['poster' => ($i == $posterIndex)]);
            }
        }

        // 1. Remover vínculos marcados
        foreach ($request->input('remover_vinculos', []) as $relacao => $ids) {
            if (in_array($relacao, ['actors', 'directors', 'producers', 'writers'])) {
                $filme->$relacao()->detach($ids);
            }
        }
        // 2. Atualizar personagem dos atores existentes
        foreach ($request->input('atores_existentes', []) as $atorId => $dados) {
            $filme->actors()->updateExistingPivot($atorId, [
                'papel' => $dados['personagem'] ?? null
            ]);
        }
        // 3. Adicionar novos vínculos (mesmo método do store)
        $this->sincronizarVinculos($filme, $request->input('vinculos', []));

        return redirect('/filmes/' . $id)->with('sucesso', 'Filme atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function show_public(string $id)
    {
        $filme = Movie::findOrFail($id);
        // $avaliacoes = $filme->reviews()->with('user')->get();
        return view('filmes.show-public', compact('filme'));
    }


    // Método auxiliar privado — reutilizado no update()
    private function sincronizarVinculos(Movie $filme, array $vinculos): void
    {
        foreach ($vinculos as $v) {
            $pessoaId = $v['pessoa_id'] ?? null;
            $pessoa = Person::find($pessoaId);
            $tipo = $v['tipo'] ?? null;
            $personagem = $v['personagem'] ?? null;
            if (!$pessoaId || !$tipo) continue;
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
