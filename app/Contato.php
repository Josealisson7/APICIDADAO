<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $fillable = ['celular', 'email'];
    public $timestamps = false;

    public function cidadao()
    {
        return $this->belongsTo(Cidadao::class);
    }
}

