<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = ['endereco', 'logradouro', 'bairro'];
    public $timestamps = false;

    public function cidadao()
    {
        return $this->belongsTo(Cidadao::class);
    }
    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

}
