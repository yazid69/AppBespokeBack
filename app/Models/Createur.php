<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Createur extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idCreateur',
        'genre',
        'nom',
        'prenom',
        'dateNaissance',
        'mdpCreateur',
        'email',
        'telCreateur',
        'numRue',
        'rue',
        'ville',
        'codePostal',
        'pays',
        'debutActivite',
        'siret',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mdpCreateur',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's idUser.
     *
     * @return int
     */
    protected $primaryKey = 'idCreateur';

}
