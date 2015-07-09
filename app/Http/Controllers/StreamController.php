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
            return view('stream.watcher', [
                'streamingUser' => $user
            ]);
        }

        //TODO : maybe notifiy 'stream offline'
        return redirect(route('streams'));
    }

    public function streamSearch()
    {
        if (Request::has('query')) {
            $query = Request::input('query');
        }
        else {
            $query = '';
        }
        if (Request::input('all') !== null) {
            $data = $this->streamingUser->searchAll($query);
        }
        else {
            $data = $this->streamingUser->searchStreaming($query);
        }

        return view('stream.all', [
            'streams' => $data
        ])->with([
            'search' => $query
        ]);
    }

    public function getAll()
    {
        $data = $this->streamingUser->getAll();

        return view('stream.all', [
            'streams' => $data
        ]);
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
            // Error : no streaming in progress
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
            $data = $experienceManager->processExpRequest(Request::all());
            switch ($data) {
                case ExperienceManager::NEED_RESYNC:
                    $status = 400;
                    break;
                default:
                    $status = 200;
                    break;
            }
            // TODO : check data returned to see if it's ok or need resync
        }
        else {
            // Error : no streaming in progress
            $status = 400;
        }

        return new JsonResponse($data, $status);
    }
    /****************************************
     * END Experience system related functions
     ***************************************/
}