<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContatoTelefone extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'contato_id',
        'numero'
    ];

    public function contato()
    {
        return $this->belongsTo(Contato::class);
    }
}
