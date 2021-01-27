<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidadao extends Model
{
    protected $fillable = ['nome', 'sobrenome', 'cpf'];
    public $timestamps = false;
    protected $table = 'cidadaos';

    public function contato()
    {
        return $this->hasOne(Contato::class);
    }

    public function endereco()
    {
        return $this->hasOne(Endereco::class);
    }
}
