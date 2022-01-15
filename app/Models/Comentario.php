<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = array(
        'user_id',
        'conteudo_id',
        'texto',
    );

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function counteudo(): BelongsTo
    {
        return $this->belongsTo(Conteudo::class);
    }

    public function curtidas(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'curtidas', 'conteudo_id', 'user_id');
    }
}
