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
    public function isStreaming($streamerName)
    {
        $res = $this->getAll()->filter(function (User $streamer) use ($streamerName) {
            if ($streamer->twitch_channel === $streamerName && $streamer->isStreaming()) {
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
        $streamers = User::streamers()
            ->orderBy('twitch_channel')
            ->get();
        foreach ($streamers as $streamer) {
            if (!$this->isStreamingOnTwitch($streamer->twitch_channel)) {
                $streamer->stopStreaming();
            }
        }

        return $streamers;

    }

    private function isStreamingOnTwitch($streamerName)
    {
        $httpClient = app('TwitchApiClient');

        try {
            $res = $httpClient->get('/kraken/streams/' . $streamerName);

            $data = json_decode($res->getBody()->getContents(), true);
            if (array_key_exists('error', $data)) {
                if ($data['status'] == 422) {
                    return false;
                }
            }
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
     * @param $query string
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchStreaming($query)
    {
        $res = $this->getAll()->filter(function (User $streamer) use ($query) {
            $res = starts_with($streamer->twitch_channel, $query);
            if ($res !== false) {

                return true;
            }
            else {
                $res = starts_with($streamer->pseudo, $query);

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