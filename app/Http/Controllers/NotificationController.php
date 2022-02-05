<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class NotificationController extends Controller
{


    public function SendNotification(Request $request) {

        $SERVER_API_KEY = 'AAAAkLE8PaI:APA91bFAo03UFXEW6Ye3IbIW8d0E_5w0C0VlgBPP8pW57IFs3xh7tLtrNMXMfoZI66sc0rC7-s3kjOnoMlwRDGIZ5FuQciXOpoaWYNmgKlt8AbseRUGNIGxH1UcQuaFK0wg9RugLE06F';


        $list = json_decode($request->getContent(), true);

        $list = $list["udids"];

        $tokens = Device::whereIn('udid', $list)->get()->pluck('fcm_token')->toArray();

        error_log(count($tokens));
        error_log("trying to loop");


        foreach ($tokens as $token) {
          error_log($token);
        }




        //$tokens = json_decode($request->all());

        $data = [
          "registration_ids" => $tokens,

          "notification" => [
            "title" => 'Warning',
            "body" => 'You have contacted someone with covid or in risk',
            "sound" => 'default'
          ],
        ];

        $dataString = json_encode($data);

        $headers = [
          'Authorization: key='.$SERVER_API_KEY,
          'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        

         return response("notifications sent !", 201);




    }
}
