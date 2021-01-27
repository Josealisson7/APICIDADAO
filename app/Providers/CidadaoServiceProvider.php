<?php

namespace App\Providers;

use App\Repositories\CidadaoRepository;
use App\Services\CidadaoService;
use Illuminate\Support\ServiceProvider;

class CidadaoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CidadaoService::class, function (){
            return new CidadaoService(new CidadaoRepository());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
