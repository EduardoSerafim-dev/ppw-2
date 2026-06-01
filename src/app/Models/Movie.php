<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
  protected $fillable = [

    'nome',
    'duracao',
    'data_lancamento',
    'classificacao',
    'sinopse',
  ];

  public function reviews(): HasMany
  {
    return $this->hasMany(Review::class);
    // Eloquent infere: reviews.user_id
  }

  // Filme tem muitos atores (via tabela pivot actor_movie)
  public function actors(): BelongsToMany
  {

    return $this->belongsToMany(Actor::class)
      ->withPivot('papel') // coluna extra da pivot
      ->withTimestamps();
    // created_at na pivot
  }

  // Filme tem muitos diretores (via tabela pivot director_movies)
  public function directors(): BelongsToMany
  {
    return $this->belongsToMany(Director::class)
      ->withTimestamps();
    // created_at na pivot
  }

  // Filme tem muitos produtores (via tabela pivot producer_movies)
  public function producers(): BelongsToMany
  {
    return $this->belongsToMany(Producer::class)
      ->withTimestamps();
    // created_at na pivot
  }

  // Filme tem muitos escritores (via tabela pivot writer_movies)
  public function writers(): BelongsToMany
  {
    return $this->belongsToMany(Writer::class)
      ->withTimestamps();
    // created_at na pivot
  }

  // Filme tem muitos estúdios (via tabela pivot movie_studio)
  public function studios(): BelongsToMany
  {
    return $this->belongsToMany(Studio::class)
      ->withTimestamps();
    // created_at na pivot
  }

  // Filme tem muitos gêneros (via tabela pivot genre_movie)
  public function genres(): BelongsToMany
  {
    return $this->belongsToMany(Genre::class)
      ->withTimestamps();
    // created_at na pivot
  }

  public function images(): BelongsToMany
  {
    return $this->belongsToMany(Image::class)
      ->withPivot('poster')
      ->withTimestamps();
  }
}
