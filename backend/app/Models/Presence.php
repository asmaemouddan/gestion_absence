<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'seance_id',
        'status',
        'heure_scan',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    public function justification()
    {
        return $this->hasOne(Justification::class);
    }
}
