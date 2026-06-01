<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Person;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busca = trim($request->input('busca', ''));

        $filmes = collect();
        $generos = collect();
        $pessoas = collect();

        if ($busca) {

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
                ->orWhereHas('actor', function ($q) use ($busca) {
                    $q->whereHas('person', fn($p) =>
                    $p->where('nome', 'ilike', "%{$busca}%"));
                })
                ->orWhereHas('director', function ($q) use ($busca) {
                    $q->whereHas('person', fn($p) =>
                    $p->where('nome', 'ilike', "%{$busca}%"));
                })
                ->orWhereHas('writer', function ($q) use ($busca) {
                    $q->whereHas('person', fn($p) =>
                    $p->where('nome', 'ilike', "%{$busca}%"));
                })
                ->orWhereHas('producer', function ($q) use ($busca) {
                    $q->whereHas('person', fn($p) =>
                    $p->where('nome', 'ilike', "%{$busca}%"));
                })
                ->orderBy('nome')
                ->get();
        }

        return view('home.index', compact(
            'busca',
            'filmes',
            'generos',
            'pessoas'
        ));
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
