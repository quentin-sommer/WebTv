<?php namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;
use Webtv\AvatarManager;
use Webtv\ExperienceManager;
use Webtv\StreamBannerManager;
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
        $this->app->bind('ImageManager', function ($app) {
            return new ImageManager([
                'driver' => env('IMG_MANAGER_DRIVER')
            ]);
        });
        $this->app->bind('AvatarManager', function ($app) {
            return new AvatarManager();
        });
        $this->app->bind('StreamBannerManager', function ($app) {
           return new StreamBannerManager();
        });

        Validator::extend('twitch', function ($attribute, $value, $parameters) {
            return !filter_var($value, FILTER_VALIDATE_URL);
        }, 'Compte twitch incorrect');
    }
}
