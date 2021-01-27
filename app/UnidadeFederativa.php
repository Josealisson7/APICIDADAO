<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadeFederativa extends Model
{
    protected $fillable = ['uf'];
    public $timestamps = false;
    protected $table = 'unidades_federativas';

    public function cidades()
    {
        return $this->hasMany(Cidade::class);
    }
}
