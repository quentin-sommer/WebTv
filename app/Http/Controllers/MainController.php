<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Webtv\StreamingUserService;

class MainController extends BaseController
{
    protected $streamingUser;

    public function __construct(StreamingUserService $sus)
    {
        $this->streamingUser = $sus;
    }

    public function getMain()
    {
        $data = $this->streamingUser->getAll();

        return view('main', [
            'streams' => $data
        ]);
    }

    public function getLol()
    {

        return Hash::make('quentin');
    }
}
