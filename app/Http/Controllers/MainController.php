<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Webtv\StreamingUser;
use Illuminate\Support\Facades\Hash;

class MainController extends BaseController
{
    protected $streamingUser;

    public function __construct()
    {
        $this->streamingUser = app('StreamingUser');
    }

    public function getMain()
    {

        return view('main');
    }

    public function getLol()
    {

        return Hash::make('quentin');
    }
}
