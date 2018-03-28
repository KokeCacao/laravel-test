<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;

class UsersController extends Controller {

    public function __construct() {
        //auth is redirrection
        //except require logging in
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store']
        ]);
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //注册页面访问
    public function create() {
        // create html for signup
        return view('users.create');
    }

    public function show(User $user) {
        // create html for user page
        return view('users.show', compact('user'));
    }

    public function store(Request $request) {
        // store info for signup
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);
        // danger, warning, success, info 这四个键名在 Bootstrap 分别具有不同样式展现效果
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
        // equivalent to redirect()->route('users.show', [$user->id]);
    }
    public function destroy() {
        // store info for signout
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
    public function edit(User $user) {
        // create html for edit user info
        // update 指的是 授权类 的 update 方法
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    public function update(User $user, Request $request) {
        // store info for updating user info
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
    }
}
