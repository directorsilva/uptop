<?php

namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class ConfigController extends Controller
{
    public static function Config(){
    return [
        'API_KEY' => [
            'GOOGLE_API_KEY' =>  'AAAAes6iy30:APA91bEGZgbKE9VS68ummlUqXdX0u-JMAcnieJ8v7MX_q-oro5KrYySZ7Ho1oLvWvYDHHcZ-73pb8lLYo5s2xAt2kRoN8e2TDjIN8ikKVM6NPKeCqPB5qE0SpJ0JTiG7Sl8O5MxZssde'
        ]

        
    ];
    }
}