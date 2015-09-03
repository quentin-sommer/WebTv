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

    protected $guarded = ['remember_token', 'created_at', 'updated_at'];
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'login',
        'pseudo',
        'email',
        'twitch_channel',
        'description',
        'avatar',
        'level',
        'experience',
        'password',
        'streaming'
    ];
    protected $hidden = ['password', 'remember_token'];
    protected $with = ['roles'];

    public function roles()
    {
        return $this->belongsToMany('\Models\Role');
    }

    public function isAdmin()
    {
        return $this->hasRole(env('ROLE_ADMIN'));
    }

    public function hasRole($id)
    {
        return count($this->roles->filter(function ($item) use ($id) {
            if ((int)$item->role_id === (int)$id) {
                return true;
            }
        })) > 0;
    }

    public function isStreamer()
    {
        return $this->hasRole(env('ROLE_STREAMER'));
    }

    public function becomeStreamer()
    {
        $this->attachRole(env('ROLE_STREAMER'));
    }

    private function attachRole($id)
    {
        if ($this->roles->find($id, false)) {
            return;
        }
        $this->roles->attach($id);
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
        if ((int)$this->streaming === 1) {
            return true;
        }

        return false;
    }

    public function startStreaming()
    {
        $this->streaming = 1;
        $this->save();
    }

    public function stopStreaming()
    {
        $this->streaming = 0;
        $this->save();
    }
}
