<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seance extends Model
{
    use HasFactory, SoftDeletes;

   protected $fillable = [
    'classe_id',
    'professeur_id',
    'module_id',
    'date',
    'heure_debut',
    'heure_fin',
    'photo',
];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
}
