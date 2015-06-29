<?php

namespace app\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class StreamController extends BaseController
{
    protected $streamingUser;

    public function __construct()
    {
        $this->streamingUser = app('StreamingUser');
    }

    public function getStream($streamerName)
    {
        $user = $this->streamingUser->has($streamerName);
        if ($user !== null) {
            return view('stream', [
                'streamingUser' => $user
            ]);
        }
        echo 'hi';
        // redirect to offline page
    }
}