<?php

namespace App\Http\Middleware;

use Closure;

class ValidarRequisicaoCidadao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $validation = \Validator::make(
            $request->all(),
            [
                'nome' => 'required|string',
                'sobrenome' => 'required',
                'email' => 'required|email',
                'cpf' => 'required|min:11|max:11',
                'celular' => 'required',
                'cep' => 'required|min:8|max:8'
            ],
            [
                'required' => 'O atributo :attribute não pode ser vazio',
                'email' => 'O atributo :attribute não é um email valido',
                'min' => 'o atributo :attribute precisa ter no minimo :min caracteres',
                'max' => 'o atributo :attribute precisa ter no maximo :max caracteres'
            ]
        );

        if ($validation->fails()) {
            return response()->json(['messages' => $validation->getMessageBag()->all()], 422, array(), JSON_PRETTY_PRINT);
        }else{
            return $next($request);
        }

    }
}
