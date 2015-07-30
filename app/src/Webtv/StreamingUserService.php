<?php

namespace Webtv;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Models\User as User;

class StreamingUserService
{
    /**
     * @var int
     */
    protected $expirationTime;

    public function __construct()
    {
        $this->expirationTime = env('STREAMING_USERS_CACHE');
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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->retrieveData();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function retrieveData()
    {
        return Cache::remember('streamers', $this->expirationTime, function () {
            return User::streamers()->where('streaming', '=', '1')->orderBy('twitch_channel')->get();
        });
    }

    /**
     * @param $query string
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchAll($query)
    {
        $res = $this->getAll()->filter(function (User $streamer) use ($query) {
            $res = $this->startsWith($streamer->twitch_channel, $query);
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
     * Emulates LIKE '%STR' behavior
     * @param $str   string the haystack
     * @param $query string the needle
     * @return bool
     */
    private function startsWith($str, $query)
    {
        $str = strtolower($str);

        // testing this function
        return starts_with($str, $query);

        $query = strtolower($query);

        return $query === "" || strrpos($str, $query, -strlen($str)) !== false;
    }

    /**
     * @param $query string
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchStreaming($query)
    {
        $res = $this->getAll()->filter(function (User $streamer) use ($query) {
            $res = $this->startsWith($streamer->twitch_channel, $query);
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
    }

}