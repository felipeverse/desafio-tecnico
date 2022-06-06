<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;

    public function telefones() {
        return $this->hasMany(ContatoTelefone::class);
    }

    public function enderecos() {
        return $this->hasMany(ContatoEndereco::class);
    }
}
