<?php

namespace app\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Webtv\ExperienceManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class StreamController extends BaseController
{
    protected $streamingUser;

    public function __construct(StreamingUserService $sus)
    {
        $this->streamingUser = $sus;
    }

    public function getStream($streamerName)
    {
        $user = $this->streamingUser->has($streamerName);
        if ($user !== null) {
            return view('stream', [
                'streamingUser' => $user
            ]);
        }
        echo 'not streaming';
        // redirect to offline page
    }

    public function startWatching(ExperienceManager $experienceManager)
    {
       $experienceManager->startWatching();
    }

    public function updateExperience(ExperienceManager $experienceManager)
    {
        $validator = Validator::make(Request::all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), 422);
        }

        $res = $experienceManager->processExpRequest(Request::all());
    }
}