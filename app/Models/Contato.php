<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Contato extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = ['nome', 'email'];

    public $sortable = ['id', 'nome'];

    public function telefones() {
        return $this->hasMany(ContatoTelefone::class);
    }

    public function enderecos() {
        return $this->hasMany(ContatoEndereco::class);
    }
}
