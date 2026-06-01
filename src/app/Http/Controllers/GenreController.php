<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $generos = Genre::orderBy('nome')->get();
        return view("generos.index", compact("generos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('generos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|min:3',
        ]);

        // DB::insert('INSERT INTO produtos (nome, preco) VALUES (?, ?)', [$dados['nome'], $dados['preco']]);

        Genre::create($dados);
        return redirect('/generos')->with('sucesso', 'Gênero criado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $genero = Genre::findOrFail($id);
        return view('generos.edit', compact('genero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dados = $request->validate([
            'nome' => 'required|string|min:3',
        ]);

        $genero = Genre::findOrFail($id);

        $genero->update($dados);

        return redirect('/generos')->with('sucesso', 'Gênero atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        Genre::findOrFail($id)->delete();
        return redirect('/generos')->with('sucesso', 'Gênero excluído!');
    }
}
