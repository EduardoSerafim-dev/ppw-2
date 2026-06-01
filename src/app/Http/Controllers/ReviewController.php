<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avaliacoes = Review::with(['user', 'movie'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view("avaliacoes.index", compact("avaliacoes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id_filme)
    {
        return view('avaliacoes.create', compact("id_filme"));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id_filme)
    {
        $dados = $request->validate([
            'nota' => 'required|integer|min:0|max:10',
            'descricao' => 'required|string|min:3',
        ]);

        Review::create([
            'nota' => $dados['nota'],
            'descricao' => $dados['descricao'],
            'movie_id' => $id_filme,
            'user_id' => auth()->id(),
        ]);

        return redirect('/avaliacoes')
            ->with('sucesso', 'Avaliação criada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $avaliacao = Review::with([
            'user',
            'movie'
        ])->findOrFail($id);

        // if ($avaliacao->user_id !== auth()->id()) {
        //     abort(403);
        // }

        return view('avaliacoes.show', compact('avaliacao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $avaliacao = Review::findOrFail($id);
        return view('avaliacoes.edit', compact('avaliacao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dados = $request->validate([
            'nota' => 'required|integer|min:0|max:10',
            'descricao' => 'required|string|min:3',
        ]);
        $avaliacao = Review::findOrFail($id);

        $avaliacao->update($dados);

        return redirect('/avaliacoes')->with('sucesso', 'Avaliação atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $avaliacao = Review::findOrFail($id);

        // if ($avaliacao->user_id !== auth()->id()) {
        //     abort(403);
        // }

        $avaliacao->delete();

        return redirect('/avaliacoes')
            ->with('sucesso', 'Avaliação excluída!');
    }
}
