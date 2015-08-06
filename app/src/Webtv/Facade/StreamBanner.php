<?php

namespace Webtv\StreamBanner;

use Illuminate\Support\Facades\Facade;

class StreamBanner extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'StreamBannerManager';
    }

}