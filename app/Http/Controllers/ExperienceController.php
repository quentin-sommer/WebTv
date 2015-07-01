<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 29/06/2015
 * Time: 14:57
 */

namespace app\Http\Controllers;

use Webtv\StreamingUserService;

class ExperienceController
{

    protected $experienceManager;
    protected $streamingUser;
    public function __construct(StreamingUserService $sus)
    {
        $this->experienceManager = app('ExperienceManager');
        $this->streamingUser = $sus;
    }

    public function startWatching()
    {

    }

    public function updateExperience()
    {

    }
}