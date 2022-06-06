<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContatoEndereco extends Model
{
    use HasFactory;

    protected $fillable = [
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
