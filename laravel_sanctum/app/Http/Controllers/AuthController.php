<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    public function login(Request $request){

        // $this->validate($request, [
        //     'email'           => 'required|max:255|email',
        //     'password'           => 'required|confirmed',
        // ]);
        // if (Auth::attempt(['email' => 'email', 'password' => 'password'])) {
        //     // Success
        //     return redirect()->intended('/panel');
        // } else {
        //     // Go back on error (or do what you want)
        //     return redirect()->back();
        // }


        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password, [])) {
            return response()->json([
                'message' =>"User not exist"],404);
        }
        $token = $user->createToken('authToken')->plainTextToken;


        return response()->json([
            'access_token' => $token, 
            'type_token' => 'Bearer' ],201 );
    }

    public function register(Request $request){
        $messages = [
            'email.email' => 'Error email',
            'email.required' => 'Required email',
            'password.required' => 'Required password'
        ];

        $validate = Validator::make($request->all(),[
             'email'=> 'email|required',
             'password'=> 'required'
            ], $messages);
        if($validate->fails()){
            return response()->json(
                [
                    'message' => $validate->errors()
                ],422
            );
        }

        User::create([
            'name' => $request->name,
            'email' => $request-> email,
            'password' => Hash::make($request-> password)
        ]);

        return response()->json(
            [
                'message' =>"Created"
            ],201
        );
    }

    public function user(Request $request){
        return $request->user;
    }

    public function logout(){
        // delete all
        // auth()->user()->tokens()->delete();
        
        // delete current
        // auth()->user()->currentAccessToken()->delete();
        
        // Revoke a specific token...
        // $user->tokens()->where('id', $tokenId)->delete();
        return response()->json(
            [
                'message' =>"logout",
                'data' =>auth()->user()->tokens()->currentAccessToken()
            ],200
        );
    }
}
