<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    protected $fillable = [

        'cpf',
        'nome',
        'data_nascimento',
        'biografia',
        'genero',
        'nacionalidade',
    ];

    // Uma pessoa pode ter um registro como ator
    public function actor(): HasOne
    {
        return $this->hasOne(Actor::class);

        // Eloquent infere: actors.person_id
    }
    // Uma pessoa pode ter um registro como diretor
    public function director(): HasOne
    {
        return $this->hasOne(Director::class);
    }

    // Uma pessoa pode ter um registro como produtor
    public function producer(): HasOne
    {
        return $this->hasOne(Producer::class);
    }
    // Uma pessoa pode ter um registro como produtor
    public function writer(): HasOne
    {
        return $this->hasOne(Writer::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class)
            ->withPivot('principal')
            ->withTimestamps();
    }
}
