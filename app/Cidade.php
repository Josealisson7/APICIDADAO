<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $fillable = ['cidade'];
    public $timestamps = false;

    public function endereco()
    {
        return $this->hasMany(Endereco::class);
    }

    public function unidadeFederativa()
    {
        return $this->belongsTo(UnidadeFederativa::class);
    }
}
