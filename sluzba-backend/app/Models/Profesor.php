<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesori';

    protected $fillable = [
        'ime',
        'prezime',
        'zvanje',
        'email',
        'kabinet',
        'napomena'
    ];

    public function predmeti()
    {
        return $this->hasMany(Predmet::class, 'profesor_id');
    }
}
