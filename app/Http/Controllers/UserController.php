<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  User::all();
        return response()->json([UserResource::collection($data), 'Users fetched.']);

    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
          'name' => 'required|string',
          'email' => 'required|string|unique:users,email',
          'password' => 'required|string|confirmed',
        ]);



        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->email)
        ]);
        
        return response()->json(['User created successfully.', new UserResource($user)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new UserResource($user)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(),[
          'name' => 'required|string',
          'email' => 'required|string',
          'remember_token' => 'string',
        ]);



        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->remember_token = $request->remember_token;
        $user->save();
        
        return response()->json(['User updated successfully.', new UserResource($user)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json('User deleted successfully');
    }
}
