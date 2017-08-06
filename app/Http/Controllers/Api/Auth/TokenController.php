<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Http\Requests;
use App\Http\Requests\Api\Authenticate;
use App\Http\Controllers\Api\ApiController;

/**
 * API authentication
 *
 *
 *
 * @Resource("Authenticate", uri="/auth/token")
 */
class TokenController extends ApiController
{
    /**
     * Authenticate and return token based on email and password
     * Use token to other api endpoint by adding Authorization Bearer {token}
     *
     * @Post("/")
     *
     * @Versions({"v1"})
     *
     * @Request("email=digitaldreams40@gmail.com&password=123456", contentType="application/x-www-form-urlencoded")
     *
     * @Response(200, body={"token": "xaslkjfsdfjlsdkjflsdjf.sfjlsdfjs.sdfsdfsd", "expire_in": "2017-05-12 23:00:45"})
     * @Response(500, body={"message": "Could not create token"})
     */
    public function authenticate(Authenticate $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->response->errorInternal('Could not create token');
        }

        return $this->response->array([
            'token' => $token,
            'expire_in' => \Carbon\Carbon::now()->addMinutes(config('jwt.ttl'))->format('Y-m-d H:i:s')
        ]);

    }
}
