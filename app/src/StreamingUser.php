<?php

namespace Webtv;

use Illuminate\Support\Facades\Cache;
use Models\User as User;

class StreamingUser
{
    protected $expirationTime;
    protected $users;

    public function getAll()
    {
        if ($this->users === null) {
            $this->users = $this->retrieveData();
        }

        return $this->users;
    }

    private function retrieveData()
    {
        return Cache::remember('streamers', $this->expirationTime, function () {
            return User::streamers()->where('streaming', '=', '1')->get();
        });
    }

    public function has($streamerName)
    {
        $res = $this->getAll()->filter(function ($streamer) use ($streamerName) {
            if ($streamer->twitch_channel === $streamerName) {
                return true;
            }

            return false;
        });
        if (count($res) > 0) {
            return $res->first();
        }

        return null;
    }

    public function update()
    {
        Cache::forget('streamers');
        $this->users = null;
        $this->retrieveData();
    }

    public function __construct()
    {
        $this->expirationTime = $_ENV['STREAMING_USERS_CACHE'];
        $this->users = null;
    }

}