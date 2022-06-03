<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContatoTelefone extends Model
{
    use HasFactory;

    protected $fillable = ['numero'];

    public function contato() {
        return $this->belongsTo(Contato::class);
    }
}
