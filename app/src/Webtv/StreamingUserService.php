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
            ->where('twitch_channel', '!=', '')
            ->get();

        $data = $this->isStreamingOnTwitch($streamers);

        return $data;

    }

    /**
     * @param $streamers \Illuminate\Database\Eloquent\Collection
     * @return bool
     */
    private function isStreamingOnTwitch($streamers)
    {
        $httpClient = app('TwitchApiClient');
        $promises = [];

        foreach ($streamers as $key => $streamer) {
            $promises[$key] = $httpClient->getAsync('/kraken/streams/' . $streamer->twitch_channel);
        }

        try {
            $results = \GuzzleHttp\Promise\unwrap($promises);
        } catch (\Exception $e) {
            return new Collection();
        }

        foreach ($results as $id => $response) {
            if ($response->getStatusCode() !== 200) {
                $streamers->get($id)->stopStreaming();
            }
            else {
                $data = json_decode($response->getBody()->getContents(), true);
                if ($data['stream'] === null) {
                    $streamers->get($id)->stopStreaming();
                }
            }
        }

        return $streamers;
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