<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable {
    use Notifiable;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    // boot 方法会在用户模型类完成初始化之后进行加载
    public static function boot() {
        parent::boot();

        // create event
        static::creating(function ($user) {
            // $user->activation_token = str_random(30);
            $user->activation_token = Str::orderedUuid();
        });
    }

    public function gravatar($size = '100') {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPassword($token));
    }
}
