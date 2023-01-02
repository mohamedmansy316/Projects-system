<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Hash;

class RegisterController extends BaseController{
    /**
     * Registraion function it requires username, email and password with confirmation
     *
     * @param object $r registration data
     *
     * @return object The user data
     */
    public function register(Request $r){
        $validator = Validator::make($r->all(),[
            'name' =>'required',
            'email' =>'required|email',
            'password' =>'required|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Please validate error' ,$validator->errors() );
        }
            $input = $r->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $success['token'] = $user->createToken('m')->accessToken;
            $success['name'] = $user->name;
        return $this->sendResponse($success ,'User registered successfully', 201);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $r){
        if (Auth::attempt(['email' => $r->email, 'password' => $r->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('token')->accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User logged in successfully.',201);
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized'], 401);
        }
    }
}

