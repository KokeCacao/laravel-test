<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class SessionsController extends Controller {
    public function __construct() {
        // 只有 guest 能访问 create() 方法
        // 注意这里 guest 是 middleware 的一个模式, 不是 guest instance
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    // 登录页面访问
    public function create() {
        return view('sessions.create');
    }

    public function store(Request $request) {
        // validate login info
       $credentials = $this->validate($request, [
         'email' => 'required|email|max:255',
         'password' => 'required'
     ]);

       if (Auth::attempt($credentials, $request->has('remember'))) {
          session()->flash('success', '欢迎回来！');
                   //return redirect()->route('users.show', [Auth::user()]);
          return redirect()->intended(route('users.show', [Auth::user()]));
      } else {
          session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
          return redirect()->back();
      }
  }

  public function destroy() {
        // store info for signout
    Auth::logout();
    session()->flash('success', '您已成功退出！');
    return redirect('login');
}

}