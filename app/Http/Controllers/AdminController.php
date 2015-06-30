<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 28/05/2015
 * Time: 16:57
 */

namespace app\Http\Controllers;

use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Models\Role as Role;
use Models\User as User;

class AdminController extends BaseController
{
    private $streamingUser;

    public function __construct()
    {
        $this->streamingUser = App::make('StreamingUser');
    }

    public function getDashboard()
    {
        echo 'getDashboard';
    }

    public function postDashboard()
    {
        echo 'postDashboard';
    }

    public function getUserSettings()
    {

        $data = [
            'users' => User::with('roles')->paginate(20)->setPath(route('getUserSettings')),
            'roles' => Role::all(),
        ];

        return view('admin.users')->with($data);

    }

    public function postUserSettings()
    {
        $error = false;

        if (Request::has('user_id')) {
            $user_id = (int)Auth::user()->user_id;
            $input_id = (int)Request::input('user_id');
            if (Request::input('roles') === null) {
                $roles = [];
            } else {
                $roles = Request::input('roles');
            }
            if ($user_id === $input_id && !in_array(env('ROLE_ADMIN'), $roles, false)) {
                $roles[] = env('ROLE_ADMIN');
                $error = true;
            }

            $editUser = User::find(Request::input('user_id'));
            $editUser->roles()->sync($roles);
            $editUser->save();

            $this->streamingUser->update();
        }

        if ($error) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas enlever le droit admin de votre compte!');
        }

        return redirect()->back();
    }

    public function postDeleteUser($id)
    {
        if ((int)Auth::user()->user_id !== (int)$id) {
            User::destroy($id);

            return redirect()->back();
        }

        return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre compte!');
    }

    public function getCalendar()
    {
        echo 'getCalendar';
    }

    public function postCalendar()
    {
        echo 'postCalendar';
    }
}