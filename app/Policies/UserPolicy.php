<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy {
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // 我们 不需要 传递当前登录用户至该方法内，因为框架会自动加载当前登录用户
    // 403 异常信息来拒绝访问
    public function update(User $currentUser, User $user) {
        return $currentUser->id === $user->id;
    }
}
