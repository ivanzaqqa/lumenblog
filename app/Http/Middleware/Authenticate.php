<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\ExpiredException;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\DB;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            $token = $request->header('token');
            if (!$token) {
                $res['success'] = false;
                $res['message'] = 'Token not found, please login!';
                return response($res, 401);
            }

            try {
                $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
                $ttc = $credentials->token;
                $check_token = DB::select("SELECT * FROM m_user t WHERE t.api_key = ?", [$ttc]);
                if (count($check_token) == 0) {
                    $res['success'] = false;
                    $res['message'] = 'Unauthorize access, please login to get new token!';
                    return response($res, 401);
                }
            } catch (ExpiredException $e) {
                $res['success'] = false;
                $res['message'] = 'Expired token';
                return response($res, 401);
            } catch (Exception $e) {
                $res['success'] = false;
                $res['message'] = "Malformed token. Relogin please!";
                return response($res, 400);
            }
        } else {
            $res['success'] = false;
            $res['message'] = 'Please login!';
            return response($res, 401);
        }

        return $next($request);
    }
}
