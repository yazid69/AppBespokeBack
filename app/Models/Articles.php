<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Articles extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idArticle',
        'nomArticle',
        'description',
        'photoArticle',
        'prixArticle',
        'reference',
        'taille',
        'couleur',
        'categorie',
        'idCreateur',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'idArticle' => 'integer',
        'prixArticle' => 'decimal:2',
        'reference' => 'integer',
        'idCreateur' => 'integer',
    ];

    /**
     * Get the article's idArticle.
     *
     * @return int
     */
    protected $primaryKey = 'idArticle';

    /**
     * Get the user that owns the article.
     */
    public function createur()
    {
        return $this->belongsTo(Createur::class, 'idCreateur');
    }
}
