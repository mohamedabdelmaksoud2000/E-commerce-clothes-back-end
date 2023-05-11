<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\Models\User;
use App\Traits\ResponseApi;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{
    
    use ResponseApi;

    public function register(RegisterAuthRequest $request)
    {
        try
        {
            $request->merge(['password'=>bcrypt($request->password)]);
            $user = User::create($request->all());
            $userToken = $user->createToken('api user')->plainTextToken;
            return $this->responseSucess('User Created Successfully' , $userToken);
        }catch(Throwable $th)
        {
            return $this->responseException( $th->getMessage() );
        }
    }

    public function login(LoginAuthRequest $request)
    {

        try{

            if(!Auth::attempt($request->only(['email','password']))){
                return $this->responseError('Password & Email does not match with', 401);
            }
    
            $user = User::where('email', $request->email)->first();
            $userToken = $user->createToken('api user')->plainTextToken;
            
            return $this->responseSucess('user logged In successfully',$userToken);

        }catch(Throwable $th)
        {
            return $this->responseException($th->getMessage());
        }
        
    }

}
