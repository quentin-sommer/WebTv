<?php namespace App\Http\Controllers;

use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash as Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Models\User as User;
use Webtv\Facade\Avatar;
use Webtv\StreamingUserService;

class UserController extends BaseController
{
    protected $streamingUser;

    public function __construct(StreamingUserService $sus)
    {
        $this->streamingUser = $sus;
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login'    => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('getLogin'))
                ->withErrors($validator->errors())
                ->withInput();
        }

        $credentials = [
            'login'    => $request->input('login'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->input('remember'))) {
            if ($path = session('path')) {
                return redirect($path);
            }
            else {
                return redirect(route('getProfile'));
            }
        }
        else {
            return redirect()->back()
                ->with('error', 'Nom d\'utilisateur ou mot de passe incorrect')
                ->withInput($request->except('password'));
        }
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login'    => 'required|min:3|max:25|unique:user,login',
            'password' => 'required|min:6|max:20|confirmed',
            'email'    => 'required|max:100|email|unique:user,email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        $u = new User();
        $u->login = $request->input('login');
        $u->email = $request->input('email');
        $u->password = Hash::make($request->input('password'));
        $u->streaming = 0;
        $u->save();

        return redirect(route('getLogin'));
    }

    public function logout()
    {
        Auth::logout();

        return redirect(route('getLogin'));
    }

    public function getProfile()
    {
        return view('user.profile', [
            'user'     => Auth::user(),
            'streamer' => Auth::user()->isStreamer()
        ]);
    }

    public function postProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'   => 'sometimes|min:6|max:25|confirmed',
            'email'      => 'required|max:100|email',
            'twitch'     => 'sometimes|twitch',
            'profilePic' => 'sometimes|image'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        $user = Auth::user();

        if ($request->hasFile('profilePic')) {
            if ($request->file('profilePic')->isValid()) {

                $path = $request->file('profilePic')->getRealPath();
                $user->avatar = Avatar::processAvatar($path);
            }
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        if ($request->has('twitch')) {
            $user->twitch_channel = $request->input('twitch');
            $user->streaming = $request->input('streaming');
            $this->streamingUser->update();
        }

        $user->email = $request->input('email');
        $user->save();

        return redirect(route('getProfile'));
    }

    public function deleteAvatar()
    {
        $user = Auth::user();
        if (Avatar::isNotDefault($user->avatar)) {
            $user->avatar = Avatar::getDefaultAvatar();
        }
        $user->save();
        return redirect()->back();
    }
}