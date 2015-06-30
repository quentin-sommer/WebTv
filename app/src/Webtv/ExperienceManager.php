<?php

namespace Webtv;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Models\ExpLevel;

class ExperienceManager
{
    protected $mnBetweenReq;
    protected $user;
    protected $xpPerRequest;

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

    public function generateExperienceSystem()
    {
        $maxLevel = env('MAX_LEVEL');
        $xpFirstLevel = 100;
        $xpLastLevel = $xpFirstLevel * $maxLevel * 1000;

        $B = log((double)$xpLastLevel / (double)$xpFirstLevel) / ($maxLevel - 1);
        $A = (double)$xpFirstLevel / (exp($B) - 1.0);

        $data = [];
        for ($level = 1; $level <= $maxLevel; $level++) {
            $oldXp = round($A * exp($B * ($level - 1)));
            $newXp = round($A * exp($B * $level));
            $data[] = [
                'level'      => $level,
                'experience' => ($newXp - $oldXp)
            ];
        }
        dd($data);
        ExpLevel::truncate();
        ExpLevel::insert($data);
    }
}