<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
