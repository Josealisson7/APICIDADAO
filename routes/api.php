<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('cidadao')->group(function () {
    Route::post('', 'CidadaoController@cadastrar')->middleware(\App\Http\Middleware\ValidarRequisicaoCidadao::class);
    Route::put('{id}', 'CidadaoController@atualizar')->middleware(\App\Http\Middleware\ValidarRequisicaoCidadao::class)->where('id', '[0-9]+');
    Route::get('', 'CidadaoController@listar');
    Route::get('{cpf}', 'CidadaoController@buscar');
    Route::delete('{id}', 'CidadaoController@deletar')->where('id', '[0-9]+');
});

