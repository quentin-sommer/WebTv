<?php namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Webtv\ExperienceManager;
use Webtv\StreamingUserService;

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

    public function boot()
    {
        $this->app->singleton('StreamingUserService', function ($app) {
            return new StreamingUserService();
        });
        $this->app->singleton('ExperienceManager', function ($app) {
            return new ExperienceManager();
        });

        $expTest = $this->app->make('ExperienceManager');
        $expTest->generateExperienceSystem();


        $StreamingUser = $this->app->make('StreamingUserService');
        $StreamingUser->update();
        $users = $StreamingUser->getAll();

        View::share('streamingUsers', $users);

        Validator::extend('twitch', function ($attribute, $value, $parameters) {
            return !filter_var($value, FILTER_VALIDATE_URL);
        }, 'Compte twitch incorrect');
    }
}
