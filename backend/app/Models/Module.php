<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nom',
    ];

    public function professeurs()
    {
        return $this->belongsToMany(Professeur::class, 'module_professeur');
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
