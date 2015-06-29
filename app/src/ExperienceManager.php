<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 28/06/2015
 * Time: 16:31
 */

namespace app\src;

use Carbon\Carbon;

class ExperienceManager
{
    protected $mnBetweenReq;
    protected $user;

    public function __construct($minutesBetweenRequest)
    {
        $this->mnBetweenReq = $minutesBetweenRequest;
        $this->user = Auth::user();
    }

    public function startWatching()
    {
        $token = str_random(40);
        $level = $this->user->level;
        $lastSeenWatching = Carbon::now();

        $this->user->last_seen_watching = $lastSeenWatching->toDateTimeString();
        $this->user->experience_token = $token;

        $this->user->save();

        return [
            'token'         => $token,
            'nextXpRequest' => $this->mnBetweenReq,
            'level'         => $level,
            'progression'   => '',/* % */
            'level_up'      => ''/*boolean */
        ];
    }

    private function requestIsValid($data)
    {
        if ($data['token'] !== $this->user->experience_token) {
            return false;
        }
        $lastSeen = Carbon::createFromFormat('Y-m-d H:i:s', $this->user->last_seen_watching);
        if ($lastSeen !== false) {
            $now = Carbon::now()->second(0);
            $lastSeen->second(0);

            if ($now->diffInMinutes($lastSeen) >= 10) {
                return true;
            }

            return false;
        }
        else {
            // no valid date time stored
            return false;
        }
    }

    public function updateExperience($data)
    {
        // TODO : extract to controller
        $data = json_decode($data, true);
        if (is_null($data)) {
            return;
        }
        //
        if ($this->requestIsValid($data)) {

        }
    }

    public function levelUp()
    {

    }
}