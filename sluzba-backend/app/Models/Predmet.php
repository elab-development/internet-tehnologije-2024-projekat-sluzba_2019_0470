<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Predmet extends Model
{
    protected $table = 'predmeti';

    protected $fillable = [
        'naziv',
        'espb',
        'godina_izvodi_se',
        'obavezni',
        'profesor_id'
    ];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function studenti()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('status_predavanja', 'upisano_u_godini')
                    ->withTimestamps();
    }

    public function prijave()
    {
        return $this->hasMany(PrijavaIspita::class, 'predmet_id');
    }
}
