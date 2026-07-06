<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Person;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $atoresMaisPresentes = Actor::with(['person.images'])
            ->withCount('movies')
            ->orderByDesc('movies_count')
            ->take(4)
            ->get();

        $filmesMaisAvaliados = Movie::has('reviews')
            ->with('images')
            ->withCount('reviews')
            ->orderByDesc('reviews_count')
            ->limit(3)
            ->get();

        $filmesMaisRecentes = Movie::with('images')
            ->orderByDesc('data_lancamento')
            ->limit(3)
            ->get();

        $avaliacoesMaisRecentes = Review::with(['user', 'movie'])
            ->latest()
            ->take(9)
            ->get();

        return view('home.index', compact(
            'atoresMaisPresentes',
            'filmesMaisRecentes',
            'filmesMaisAvaliados',
            'avaliacoesMaisRecentes'
        ));
    }

    public function pesquisa(Request $request)
    {
        $busca = trim($request->input('busca', ''));

        $filmes = Movie::with('genres')
            ->where('nome', 'ilike', "%{$busca}%")
            ->orderBy('nome')
            ->get();

        $generos = Genre::where('nome', 'ilike', "%{$busca}%")
            ->orderBy('nome')
            ->get();

        $pessoas = Person::with([
            'actor',
            'director',
            'writer',
            'producer'
        ])
            ->where('nome', 'ilike', "%{$busca}%")
            ->orderBy('nome')
            ->get();

        return view('home.pesquisa', compact(
            'busca',
            'filmes',
            'generos',
            'pessoas'
        ));
    }

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
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
