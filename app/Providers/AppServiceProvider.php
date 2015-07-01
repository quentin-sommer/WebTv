<?php namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Webtv\ExperienceManager;
use Webtv\StreamingUser;

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
        $this->app->singleton('StreamingUser', function ($app) {
            return new StreamingUser();
        });
        $this->app->singleton('ExperienceManager', function ($app) {
            return new ExperienceManager();
        });

        $expTest = $this->app->make('ExperienceManager');
        $expTest->generateExperienceSystem();


        $StreamingUser = $this->app->make('StreamingUser');
        $StreamingUser->update();
        $users = $StreamingUser->getAll();

        View::share('streamingUsers', $users);

        Validator::extend('twitch', function ($attribute, $value, $parameters) {
            return !filter_var($value, FILTER_VALIDATE_URL);
        }, 'Compte twitch incorrect');
    }
}
