<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Image extends Model
{
       protected $fillable = [

              'caminho',
              'nome',
       ];

       public function people(): BelongsToMany
       {
              return $this->belongsToMany(Person::class)
                     ->withTimestamps();
       }

       public function movies(): BelongsToMany
       {
              return $this->belongstoMany(Movie::class)
                     ->withPivot('poster')
                     ->withTimestamps();
       }

       public function studios(): BelongsToMany
       {
              return $this->belongstoMany(Studio::class)
                     ->withTimestamps();
       }
}
