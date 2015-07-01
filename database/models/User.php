<?php

namespace Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $streamingUser;

    public function __construct(StreamingUserService $sus)
    {
        $this->streamingUser = $sus;
    }

    protected $guarded = ['remember_token', 'created_at', 'updated_at'];

    protected $table = 'user';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'login',
        'email',
        'twitch_channel',
        'description',
        'level',
        'experience',
        'password',
        'streaming'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function roles()
    {
        return $this->belongsToMany('\Models\Role');
    }

    public function getRoles()
    {
        return $this->roles()->get();
    }

    public function isAdmin()
    {
        return $this->hasRole(env('ROLE_ADMIN'));
    }

    public function isStreamer()
    {
        return $this->hasRole(env('ROLE_STREAMER'));
    }

    public function becomeStreamer()
    {
        $this->attachRole(env('ROLE_STREAMER'));
    }

    public function becomeAdmin()
    {
        $this->attachRole(env('ROLE_ADMIN'));
    }

    public function scopeStreamers($query)
    {
        return $query->join('role_user', 'user.user_id', '=', 'role_user.user_id')
            ->where('role_user.role_id', env('ROLE_STREAMER'));
    }

    public function isStreaming()
    {
        return $this->streaming === 1;
    }

    public function startStreaming()
    {
        $this->streaming = 1;
        $this->save();
        $this->streamingUser->update();
    }

    public function stopStreaming()
    {
        $this->streaming = 0;
        $this->save();
        $this->streamingUser->update();
    }

    public function hasRole($id)
    {
        return count($this->roles()->get()->filter(function ($item) use ($id) {
            if ((int)$item->role_id === (int)$id) {
                return true;
            }
        })) > 0;
    }

    private function attachRole($id)
    {
        if ($this->roles()->get()->find($id, false)) {
            return;
        }
        $this->roles()->attach($id);
    }
}
