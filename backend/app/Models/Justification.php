<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Justification extends Model
{
    /** @use HasFactory<\Database\Factories\JustificationFactory> */
    use HasFactory;
     protected $fillable = [
        'presence_id',
        'motif',
        'fichier',
        'status',
    ];

    public function presence()
    {
        return $this->belongsTo(Presence::class);
    }
}
