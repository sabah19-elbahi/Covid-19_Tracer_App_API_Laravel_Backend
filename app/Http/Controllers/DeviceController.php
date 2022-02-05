<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Http\Resources\DeviceResource;
use App\Http\Controllers\Controller;
use Validator;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  Device::all();
        return response()->json([DeviceResource::collection($data), 'Devices fetched.']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
          'udid' => 'string',
          'user_id' => 'required',
          'date_test' => 'date',
          'covid' => 'required',
          'risk' => 'required',
        ]);



        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $device = Device::create([
            'udid' => $request->udid,
            'token' => $request->tokenl,
            'user_id' => $request->email,
            'date_test' => $request->email,
            'covid' => $request->email,
            'risk' => $request->risk,
            
        ]);
        
        return response()->json(['Device created successfully.', new UserResource($device)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $device = Device::find($id);
        if (is_null($device)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new DeviceResource($device)]);
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
    public function update(Request $request, Device $device)
    {
        $validator = Validator::make($request->all(),[
          'udid' => 'string',
          'user_id' => 'required',
          'date_test' => 'date',
          'covid' => 'required',
          'risk' => 'required',
        ]);



        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $device->udid = $request->udid;
        $device->user_id = $request->user_id;
        $device->date_test = $request->date_test;
        $device->risk = $request->risk;
        $device->covid = $request->covid;
        $device->save();
        
        return response()->json(['Device updated successfully.', new DeviceResource($device)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        $device->delete();

        return response()->json('User deleted successfully');
    }
}
