<?php namespace LibUser\UserApi\Http\Controllers;

use RainLab\User\Facades\Auth;
use October\Rain\Auth\AuthException;
use LibUser\UserApi\Facades\JWTAuth;
use Illuminate\Support\Facades\Event;
use LibUser\UserApi\Classes\UserApiHook;

class LoginApiController extends UserApiController
{
    public function handle()
    {
        $response = [];

        $params = [
            'login'    => input('login'),
            'password' => input('password'),
            'remember' => input('remember')
        ];

        $user = Event::fire('libuser.userapi.beforeAuthenticate', [$params], true);
        $remember = (bool) array_get($params, 'remember', false);

        if (is_null($user)) {
            $user = Auth::authenticate([
                'login' => $params['login'],
                'password' => $params['password']
            ], $remember);
        }

        if ($user->isBanned()) {
            throw new AuthException('rainlab.user::lang.account.banned');
        }

        $token = JWTAuth::fromUser($user);

        Event::fire('libuser.userapi.beforeReturnUser', [$user]);

        $userResourceClass = config('libuser.userapi::resources.user');
        $response = [
            'token' => $token,
            'user'  => new $userResourceClass($user),
        ];

        return $afterProcess = UserApiHook::hook('afterProcess', [$this, $response], function() use ($response) {
            return response()->make([
                'data'   => $response,
                'status' => 200,
            ], 200);
        });
    }
}
