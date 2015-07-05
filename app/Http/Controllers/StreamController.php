<?php

namespace app\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Webtv\ExperienceManager;
use Webtv\StreamingUserService;

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

    public function postSearch()
    {
        $validator = Validator::make(Request::all(), [
            'query' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        dump(Request::input('query'));
        if(Request::input('all') !== null) {
            dump($this->streamingUser->searchAll(Request::input('query'))->toArray());
        }
        else {
            dump($this->streamingUser->searchStreaming(Request::input('query'))->toArray());
        }
        dd(Request::input('all'));
    }

    public function getAll()
    {

    }

    /****************************************
     * Experience system related functions
     ***************************************/

    /**
     * @param ExperienceManager $experienceManager
     * @return JsonResponse
     */
    public function startWatching(ExperienceManager $experienceManager)
    {
        $validator = Validator::make(Request::all(), [
            'streamer' => 'required'
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), 422);
        }
        if ($this->streamingUser->has(Request::input('streamer'))) {
            $data = $experienceManager->startWatching();
            $status = 200;
        }
        else {
            // Error : no streaming in progress,
            $status = 400;
        }

        return new JsonResponse($data, $status);
    }

    /**
     * @param ExperienceManager $experienceManager
     * @return JsonResponse
     */
    public function updateWatching(ExperienceManager $experienceManager)
    {
        $validator = Validator::make(Request::all(), [
            'token'    => 'required',
            'streamer' => 'required'
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), 422);
        }
        if ($this->streamingUser->has(Request::input('streamer'))) {
            $res = $experienceManager->processExpRequest(Request::all());
        }
        else {
            // Error : no streaming in progress,
        }

        if (is_null($res)) {
            return new JsonResponse(null, 400);
        }

        return new JsonResponse($res, 200);
    }
    /****************************************
     * END Experience system related functions
     ***************************************/
}