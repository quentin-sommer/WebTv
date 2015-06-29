<?php namespace App\Providers;

use app\src\ExperienceManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Webtv\StreamingUser;
use Illuminate\Support\Facades\View;

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
            return new StreamingUser($_ENV['STREAMING_USERS_CACHE']);
        });
        $this->app->singleton('ExperienceManager', function ($app) {
            return new ExperienceManager($_ENV['EXP_REQUEST_TIME']);
        });

        $StreamingUser = $this->app->make('StreamingUser');
        $StreamingUser->update();
        $users = $StreamingUser->getAll();

        View::share('streamingUsers', $users);

        Validator::extend('twitch', function ($attribute, $value, $parameters) {
            return !filter_var($value, FILTER_VALIDATE_URL);
        }, 'Compte twitch incorrect');
    }
}
