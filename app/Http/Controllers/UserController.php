<?php


namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    use UploadTrait;

    public function getAll()
    {
        $user = DB::table('users')->orderBy('name', 'asc')->paginate(5);
        Session::forget(['name', 'email', 'role', 'active_flg']);
        if ($user->isEmpty()) {
            return back();
        } else {
            return view('table', compact('user'));
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $oldName = Auth::user()->name;
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'email' => 'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            if ($request->has('profile_image')) {
                $image = $request->file('profile_image');
                $folder = 'images/fail/';
                $this->uploadOne($image, $folder, 'public', 'fails_' . time());
                return redirect('profile')
                    ->withErrors($validator->errors()->all())
                    ->with('profile_image', $folder . 'fails' . '.' . $image->guessClientExtension())
                    ->withInput();
            } else {
                return redirect()->back()->withErrors($validator->errors()->all());
            }
        }
        if ($request->has('profile_image')) {
            $image = $request->file('profile_image');
            $name = ($request->input('name')) . '_' . time();
            $folder = 'images/success/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $this->uploadOne($image, $folder, 'public', $name);
            $user->profile_image = $filePath;
        }
        $user->name = Input::input('name');
        $user->email = Input::input('email');
        $user->password = Input::input('password');
        $user->role = Auth::user()->role;
        $user->save();
        if($oldName != $user->name) {
            return redirect('logout')->withErrors($validator->errors()->all());
        }else{
            return redirect('profile')->withErrors($validator->errors()->all());
        }
    }

    public function getAdd()
    {
        return view('Add');
    }

    public function postAdd(Request $request)
    {
        $user = new User();
        $request->validate([
            'name' => 'required|max:20',
            'password' => 'required|min:6',
            'email' => 'required',
        ]);
        $user->name = Input::input('name');
        $user->email = Input::input('email');
        $user->role = Input::input('role');
        $user->active_flg = Input::input('active_flg');
        $user->save();
        return redirect('table');
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user->id != Auth::user()->id) {
            $user->active_flg = 0;
        }
        if (Auth::user()->role == 1) {
            $user->save();
        }
        return redirect()->back();
    }

    public function getEdit($id)
    {
        $url = url()->previous();
        Session::put('url', $url);
        $user = User::find($id);
        return view('edit', compact('user'));
    }

    public function postEdit($id, Request $request)
    {
        $user = User::find($id);
        $url = Session::get('url');
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'email' => 'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            if ($request->has('profile_image')) {
                $image = $request->file('profile_image');
                $folder = 'images/fail/';
                $this->uploadOne($image, $folder, 'public', 'fails_' . time());
                return redirect('profile')
                    ->withErrors($validator->errors()->all())
                    ->with('profile_image', $folder . 'fails' . '.' . $image->guessClientExtension())
                    ->withInput();
            } else {
                return redirect()->back()->withErrors($validator->errors()->all());
            }
        }
        if ($request->has('profile_image')) {
            $image = $request->file('profile_image');
            $name = ($request->input('name')) . '_' . time();
            $folder = 'images/success/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $this->uploadOne($image, $folder, 'public', $name);
            $user->profile_image = $filePath;
        }
        $user->name = Input::input('name');
        $user->email = Input::input('email');
        $user->role = Input::input('role');
        $user->active_flg = Input::input('active_flg');
        if ($user->id != Auth::user()->id) {
            $user->save();
        }
        return redirect()->away($url);
    }

    public function search(Request $request)
    {
        $data = $request->only('name', 'email', 'role', 'active_flg');
        session(['formDataSession' => $data]);

        Session::put('name', $request->name);
        Session::put('role', $request->role);
        Session::put('email', $request->email);
        Session::put('active_flg', $request->active_flg);

        $user = DB::table('users')->where([['name', 'like', '%' . Session::get('name') . '%'], ['role', 'like', '%' . Session::get('role') . '%'], ['email', 'like', '%' . Session::get('email') . '%'], ['active_flg', 'like', '%' . Session::get('active_flg') . '%']])->orderBy('name', 'asc')->paginate(2);
        $user->appends(['name' => Session::get('name'), 'role' => Session::get('role'), 'email' => Session::get('email'), 'active_flg' => Session::get('active_flg')]);
        if ($user->isEmpty()) {
            return back();
        } else {
            return view('table', compact('user'));
        }
    }

    public function getCreat()
    {
        return view('creat');
    }

    public function sendEmail(Request $request)
    {
        $data = User::where('active_flg', 1)->get();
        $input = $request->all();
        $request->validate([
            'name' => 'required|max:20',
            'password' => 'required|min:6',
            'email' => 'required',
        ]);
        Mail::send('mailfb', array('name' => $input["name"], 'email' => $input["email"], 'password' => $input['password'], 'role' => $input['role'], 'active_flg' => $input['active_flg'], 'data' => $data), function ($message) {
            $user = User::where('role', 1)->get();
            foreach ($user as $users) {
                $message->to($users->email);
            }
            $message->subject('Dang ki nguoi dung');
        });
        return view('login', compact('data'));
    }
}