<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getLogin(){
        return view('login');
    }
    public function postLogin(Request $request){
        $data=[
            'name'=>$request->username,
            'password'=>$request->password,
            'active_flg'=>1,
        ];

        if(Auth::attempt($data)){
            $user=Auth::user();
            return view('profile',['user'=>$user]);
        }
        else{
            return redirect('login');
        }
    }
    public function logout(){
        Auth::logout();
            return redirect('/login');
    }
}
