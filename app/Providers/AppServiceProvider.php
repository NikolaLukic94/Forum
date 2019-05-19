<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    /*
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }*/
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        \View::composer('*', function($view) { //* means to all views
     /*       $channels = Cache::rememberForever('channels', function() {
                return \Channel::all();
            });
    */
            $view->with('channels', $channels);
        });

        //or use \View::share('channels', \App\Channel::all());

/*
        Gate::before(function ($user) {
            if ($user->admin === '1') return true;
        });*/    

        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');    
    }

}
