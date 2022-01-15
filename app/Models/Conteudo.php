<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conteudo extends Model
{
    use HasFactory;

    protected $fillable = array(
        'user_id',
        'titulo',
        'texto',
        'imagem',
        'link',
    );

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
