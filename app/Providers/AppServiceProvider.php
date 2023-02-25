<?php

namespace App\Providers;

use App\Models\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $config =  Config::where('key', 'logo')->first();
            $logo = $config->value ?? null;
            if ($logo == null) {
                $logo = url('src/assets/img/cork-logo.png');
            } else {
                $logo = Storage::url($logo);
            }
            $p = Config::where('key', 'periodo')->first();
            $periodo = $p->value ?? 'Puedes definir el periodo en la configuración';
            $view->with(
                'logo',
                $logo
            );
            $view->with('periodoComisariado', $periodo);
        });
        //Add this custom validation rule.
        Validator::extend('alpha_spaces', function ($attribute, $value) {

            // This will only accept alpha and spaces. 
            // If you want to accept hyphens use: /^[\pL\s-]+$/u.
            return preg_match('/^[\pL\s]+$/u', $value);
        });
    }
}
