<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 21/08/2015
 * Time: 17:07
 */

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Webtv\Facade\StreamBanner;
use Webtv\Facade\Avatar;
use Illuminate\Http\JsonResponse;

class ImageController extends BaseController
{

    public function deleteAvatar()
    {
        $user = Auth::user();
        if (Avatar::isNotDefault($user->avatar)) {
            $user->avatar = Avatar::getDefault();
        }
        $user->save();

        return redirect()->back();
    }

    public function avatarUpload(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'profilePicInput' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors());
        }

        try {
            $imgData = str_replace(' ', '+', $request->input('profilePicInput'));
            $user->avatar = Avatar::processAvatar($imgData);
            $url = Avatar::getUrl($user->avatar);
            $user->save();

            return new JsonResponse(['avatar' => $url]);
        } catch (\Exception $e) {

            return new JsonResponse('error', 500);
        }
    }

    public function streamBannerUpload(Request $request)
    {
        $user = Auth::user();
        if (!$user->isStreamer()) {
            return;
        }
        $validator = Validator::make($request->all(), [
            'streamBannerPicInput' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors());
        }

        try {
            $imgData = str_replace(' ', '+', $request->input('streamBannerPicInput'));
            $user->stream_banner = StreamBanner::processBanner($imgData);
            $url = StreamBanner::getUrl($user->stream_banner);
            $user->save();

            return new JsonResponse(['streamBanner' => $url]);
        } catch (\Exception $e) {

            return new JsonResponse('error', 500);
        }
    }

    public function deleteStreamBanner()
    {
        $user = Auth::user();
        if (StreamBanner::isNotDefault($user->stream_banner)) {
            $user->stream_banner = Avatar::getDefault();
        }
        $user->save();

        return redirect()->back();
    }
}