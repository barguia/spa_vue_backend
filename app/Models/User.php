<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'name',
        'email',
        'password',
        'imagem',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
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

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }

    public function conteudos(): HasMany
    {
        return $this->hasMany(Conteudo::class);
    }

    public function curtidas(): BelongsToMany
    {
        return $this->belongsToMany(Conteudo::class, 'curtidas', 'user_id', 'conteudo_id');
    }

    public function amigos(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'amigos', 'user_id', 'amigo_id');
    }
}
