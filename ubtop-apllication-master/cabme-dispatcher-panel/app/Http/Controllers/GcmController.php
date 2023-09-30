<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use App\Models\Commission;
use Illuminate\Http\Request;
use Config;
use DB;
class GcmController extends Controller
{

   public function __construct()
   {

   }


    /**
     * Sending Push Notification
     */
    public static function send_notification($tokens,$message,$data) {
        // include config


        // Set POST variables
        $url='https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' 	=> $tokens,
            'notification' => $message,
            //'data'=>$data,
            'content_available' => true,
            'priority' => 'high',
            //'body'=>$data
        );
        //$API_KEY= Config::get('constants.apikey');

        $headers = array(

            'Authorization:key='.Config::get('constant.apikey.GOOGLE_API_KEY'),
           //'Authorization:key=AIzaSyCkBmY-qnXk0Prdzv2XaQ3CzXLEYF9mukc',
            'Content-Type:application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, $url );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

        $result = curl_exec($ch );

        if($result===FALSE){
            die('Curl Failed:'.curl_error($ch));
        }
        curl_close( $ch );

        return $result;
    }

}
