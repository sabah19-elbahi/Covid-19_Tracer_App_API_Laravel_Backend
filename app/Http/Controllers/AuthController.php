<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
          'name' => 'required|string',
          'email' => 'required|string|unique:users,email',
          'password' => 'required|string|confirmed',
          'udid' => 'required|string|unique:devices,udid',
          'fcmtoken' => 'required|string',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);


          error_log('fcm tpoken from laravel');
          error_log($fields['fcmtoken']);


        
        

        $token = $user->createToken('myapptoken')->plainTextToken;
        $user = User::where('email',$fields['email'])->first();
        

        $device = Device::create([
            'udid' => $fields['udid'],
            'token' => $token,
            'user_id' => $user->id,
            'fcm_token' => $fields['fcmtoken'],
            
        ]);
        
        

        return response($token, 201);

    }






    public function login(Request $request) {
        $fields = $request->validate([
          'email' => 'required|string',
          'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Wrong credentials'],401);
            
        }

        $token = $user->createToken('myapptoken')->plainTextToken;


        return response($token, 201);

    }






    public function logout(Request $request) {
      $user = auth()->user();
      $user->tokens()->delete();
      $user->device()->token = null;
      $user->save();


      return [
        'message' => 'You are logged out'
      ];
    }






}
