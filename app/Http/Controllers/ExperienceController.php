<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 29/06/2015
 * Time: 14:57
 */

namespace app\Http\Controllers;

class ExperienceController
{

    protected $experienceManager;

    public function __construct()
    {
        $this->experienceManager = app('ExperienceManager');
    }

    public function startWatching()
    {

    }

    public function updateExperience()
    {

    }
}