<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash as Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Models\User as User;
use Webtv\ExperienceManager;
use Webtv\Facade\StreamBanner;
use Webtv\StreamingUserService;

class UserController extends BaseController
{

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
            if ($request->session()->has('path')) {
                $path = $request->session()->pull('path');

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
            'login'    => 'required|min:4|max:25|unique:user,login',
            'pseudo'   => 'required|min:4|max:25|unique:user,pseudo',
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
        $u->pseudo = $request->input('pseudo');
        $u->email = $request->input('email');
        $u->password = Hash::make($request->input('password'));
        $u->streaming = 0;
        $u->save();

        return redirect(route('getLogin'));
    }

    public function logout(StreamingUserService $sus)
    {
        $user = Auth::user();
        if ($user->isStreamer()) {
            $user->stopStreaming();
            $sus->update();
        }

        Auth::logout();

        return redirect()->back();
    }

    public function showProfile($user)
    {
        if (Auth::user()->pseudo == $user) {
            $editable = true;
            $u = Auth::user();
        }
        else {
            $editable = false;

            $u = User::where('pseudo', '=', $user)->first();
            if (is_null($u)) {
                App::abort(404);
            }
        }

        $expData = ExperienceManager::getExpInfo($u);

        return view('user.showProfile', [
            'user'        => $u,
            'streamer'    => $u->isStreamer(),
            'editable'    => $editable,
            'level'       => $expData['level'],
            'progression' => $expData['progression']
        ]);
    }

    public function getProfile()
    {
        return view('user.editProfile', [
            'user'     => Auth::user(),
            'streamer' => Auth::user()->isStreamer()
        ]);
    }

    public function postProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'     => 'sometimes|min:6|max:25|confirmed',
            'email'        => 'required|max:100|email',
            'twitch'       => 'sometimes|twitch',
            'profilePic'   => 'sometimes|image',
            'description'  => 'max:2000',
            'streamBanner' => 'sometimes|image'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        $user = Auth::user();
        $user->email = trim($request->input('email'));
        $user->description = trim($request->input('description'));

        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($user->isStreamer()) {
            if ($request->has('twitch')) {
                $user->twitch_channel = trim($request->input('twitch'));
                $user->streaming = $request->input('streaming');
                $update = true;
            }
            else {
                $update = false;
            }
            if ($request->file('streamBanner', false) !== false) {
                $img = $request->file('streamBanner');
                if ($img->isValid()) {
                    $path = $img->getRealPath();
                    $user->stream_banner = StreamBanner::processBanner($path);
                }
                else {
                    if ($img->getClientSize() === 0) {
                        $maxSizeInMo = round($img->getMaxFilesize() / 1000000, 2);
                        Session::flash('error', 'Bannière trop lourde. Taille maximale: ' . $maxSizeInMo . 'mo.');
                    }
                    else {
                        Session::flash('error', 'Fichier incorrect. Veuillez réessayer.');
                    }
                }
            }
        }

        $user->save();
        if ($update) {
            app('StreamingUserService')->update();
        }

        return redirect(route('showProfile', ['user' => $user->pseudo]));
    }
}