<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show_public(string $id)
    {
        $imagem = Image::findOrFail($id);
        return view('imagens.show-public', compact('imagem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyFromFilme(Image $imagem, Movie $filme)
    {
        $filme->images()->detach($imagem->id);
        $usos = $imagem->movies()->count() + $imagem->people()->count();


        if ($usos === 0) {
            Storage::disk('public')->delete($imagem->caminho);
            $imagem->delete();
        }
        return redirect()->back()->with('sucesso', 'Imagem removida!');
    }
}
