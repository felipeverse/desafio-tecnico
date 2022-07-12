<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContatoEndereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'contato_id',
        'titulo',
        'cep',
        'logradouro',
        'bairro',
        'localidade',
        'uf',
        'numero'
    ];

    public function contato()  {
        return $this->belongsTo(Contato::class);
    }
}
