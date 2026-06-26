<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudios = Studio::with('images')->orderBy('nome')->get();
        return view("estudios.index", compact("estudios"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estudios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|min:3',
            'local' => 'required|string|min:3'
        ]);

        Studio::create($dados);
        return redirect('/estudios')->with('sucesso', 'Estúdio criado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estudio = Studio::with([
            'images',
            'movies'
        ])->findOrFail($id);

        return view('estudios.show', compact('estudio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $estudio = Studio::findOrFail($id);
        return view('estudios.edit', compact('estudio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dados = $request->validate([
            'nome' => 'required|string|min:3',
            'local' => 'required|string|min:3'
        ]);

        $estudio = Studio::findOrFail($id);

        $estudio->update($dados);

        return redirect('/estudios/' . $id)->with('sucesso', 'Estúdio atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estudio = Studio::findOrFail($id);

        $estudio->delete();

        return redirect('/estudios')
            ->with('sucesso', 'Estúdio excluído!');
    }
}
