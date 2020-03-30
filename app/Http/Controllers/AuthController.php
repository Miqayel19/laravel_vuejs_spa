<?php
namespace App\Http\Controllers;

use App\User;
use App\Jobs\SendEmailAfterRegistration;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /**
    * Create a new AuthController instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    
    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        
        SendEmailAfterRegistration::dispatch($user);
        return response()->json(['message' => 'Successfully registered!']);
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
         
        
        return $this->respondWithToken($token);
    }

    /**
    * Log the user out (Invalidate the token).
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
    * Get the token array structure.
    *
    * @param string $token
    *
    * @return \Illuminate\Http\JsonResponse
    */
    protected function respondWithToken($token)
    {

        return response()->json([
            'token' => $token,
            'user' => $this->guard()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
    
    public function guard()
    {
        return \Auth::Guard('api');
    }
}
