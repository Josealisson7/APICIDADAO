<?php

namespace App\Providers;

use App\Repositories\ContatoRepository;
use App\Services\ContatoService;
use Illuminate\Support\ServiceProvider;

class ContatoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContatoService::class, function (){
            return new ContatoService(new ContatoRepository());
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
