<?php

namespace App\Providers;

use App\Repositories\EnderecoRepository;
use App\Services\EnderecoService;
use Illuminate\Support\ServiceProvider;

class EnderecoServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EnderecoService::class, function (){
            return new EnderecoService(new EnderecoRepository());
        });
    }
}
