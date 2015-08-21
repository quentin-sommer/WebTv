<?php

namespace Webtv;

use GuzzleHttp\Exception\ClientException;
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
        return Cache::remember('streamers', $this->expirationTime, function () {
            return $this->retrieveData();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function retrieveData()
    {
        return User::streamers()
            ->where('streaming', '=', '1')
            ->orderBy('twitch_channel')
            ->get()
            ->filter(function ($streamer) {
                return $this->isStreamingOnTwitch($streamer->twitch_channel);
            });
    }

    private function isStreamingOnTwitch($streamerName)
    {
        $httpClient = app('TwitchApiClient');

        try {
            $res = $httpClient->get('/kraken/streams/' . $streamerName);
            $data = json_decode($res->getBody()->getContents(), true);
            if ($data['stream'] !== null) {
                return true;
            }
            else {
                return false;
            }
        } catch (ClientException $e) {
            return false;
        }
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
        $query = strtolower($query);

        // testing this function
        return starts_with($str, $query);
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
            else {
                $res = $this->startsWith($streamer->pseudo, $query);

                if ($res !== false) {
                    return true;
                }
            }

            return false;
        });
        if (count($res) > 0) {
            return $res;
        }

        return new Collection();
    }

    /**
     * Forces the streamers cache flush
     */
    public function update()
    {
        Cache::forget('streamers');
    }

    /**
     * Force the streamers cache upate
     */
    public function refreshStreamers()
    {
        Cache::put('streamers', $this->retrieveData(), $this->expirationTime);
    }
}