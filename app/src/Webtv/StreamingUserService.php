<?php

namespace Webtv;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Models\User as User;

class StreamingUserService
{
    protected $expirationTime;
    protected $users;

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        if ($this->users === null) {
            $this->users = $this->retrieveData();
        }

        return $this->users;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function retrieveData()
    {
        return Cache::remember('streamers', $this->expirationTime, function () {
            return User::streamers()->where('streaming', '=', '1')->get();
        });
    }

    /**
     * @param $streamerName string
     * @return null|\Models\User
     */
    public function has($streamerName)
    {
        $res = $this->getAll()->filter(function (User $streamer) use ($streamerName) {
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

    /**
     * @param $query string
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchAll($query)
    {
        $res = User::streamers()->get()->filter(function (User $streamer) use ($query) {
            $res = strpos($streamer->twitch_channel, $query);
            if ($res !== false) {
                return true;
            }

            return false;
        });
        if (count($res) > 0) {
            return $res;
        }

        return new Collection();
    }
    /**
     * @param $query string
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchStreaming($query)
    {
        $res = $this->getAll()->filter(function (User $streamer) use ($query) {
            $res = strpos($streamer->twitch_channel, $query);
            if ($res !== false) {
                return true;
            }

            return false;
        });
        if (count($res) > 0) {
            return $res;
        }

        return new Collection();
    }

    /**
     * Forces the streamers cache update
     */
    public function update()
    {
        Cache::forget('streamers');
        $this->users = null;
        $this->retrieveData();
    }

    public function __construct()
    {
        $this->expirationTime = env('STREAMING_USERS_CACHE');
        $this->users = null;
    }

}