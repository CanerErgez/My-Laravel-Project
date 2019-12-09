<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\User;

class UserController extends Controller
{
    /**
     * Register
     *
     * @response {
     *   "token_type": "Bearer",
     *   "expires_in": 31536000,
     *   "access_token": "",
     * }
     *
     * @param  UserRegisterRequest  $request
     * @return mixed
     */
    public function register(UserRegisterRequest $request)
    {
        $data = $request->validated();

        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user = User::create($data);

        $token = $user->createToken(null, ['*']);

        return [
            'token_type' => 'Bearer',
            'expires_in' => $token->token->expires_at->getTimestamp() - \time(),
            'access_token' => $token->accessToken,
        ];
    }

    /**
     * Register
     *
     * @response {
     *   "token_type": "Bearer",
     *   "expires_in": 31536000,
     *   "access_token": "",
     * }
     *
     * @param  Request  $request
     * @return mixed
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
        } else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }

        return [
            'token_type' => 'Bearer',
            'expires_in' => 31536000,
            'access_token' => $user->createToken('MyApp')->accessToken,
        ];
    }

    /**
     * Logout
     *
     * Revokes auth token.
     *
     * @response {
     *   "message": "Logged out successfully."
     * }
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->token()->revoke();
        }

        return response()->json(['status' => 'true']);
    }
}
