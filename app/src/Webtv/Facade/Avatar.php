<?php

namespace Webtv\Facade;

use Illuminate\Support\Facades\Facade;

class Avatar extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'AvatarManager';
    }

}