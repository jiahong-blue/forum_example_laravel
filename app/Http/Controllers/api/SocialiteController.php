<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// add new
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Socialite;

class SocialiteController extends BaseController
{
    /**
     * 將用戶重新導到社群
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {

        return Socialite::driver($provider)->stateless()->redirect();

        return response()->json($user);
    }

    /**
     * 從社群中取得訊息
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (RequestException $e) {
            echo 'exception:', $e->getMessae, '/n';
            return $this->sendError('Unauthorised.', ['error'=>'社群登入失敗']);
        } catch (Exception $e) {
            echo 'exception:', $e->getMessae, '/n';
            return $this->sendError('Unauthorised.', ['error'=>'社群登入失敗']);
        }

        // 嘗試尋找使用者，存在就更新，不存在則新建一個，並回傳User instance
        // 使用firsOrCreate、updateOrCreate失敗
        $existUser = User::where('email', $user->email)->first();

        if($existUser) {
            // 有找到資料，更新
            $existUser->api_token = $user->token;
            $existUser->save();

        } else {
            // 沒找到資料，新建
            $existUser = User::Create([ 'email' => $user->email, 'social' => $provider, 
                                        'name' => $user->name, 'api_token' => $user->token, 'password' => null ]);
        }

        // 創建後就發token
        $success['token'] =  $existUser->createToken($existUser->name)->accessToken;
        $success['name'] =  $existUser->name;
        $success['id'] = $existUser->id;

        return $this->sendResponse($success, 'User login successfully.');
    }
}
