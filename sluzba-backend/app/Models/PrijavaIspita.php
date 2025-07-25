<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrijavaIspita extends Model
{
    protected $table = 'prijave_ispita';

    protected $fillable = [
        'student_id',
        'predmet_id',
        'rok_broj',
        'prijava_broj',
        'ocena',
        'status',
        'datum_polaganja'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function predmet()
    {
        return $this->belongsTo(Predmet::class, 'predmet_id');
    }
}
