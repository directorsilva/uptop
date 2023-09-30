<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Requests;
use App\Models\UserApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        $lat_long = $this->getDefaultLatLong();

        return view('map.index')->with('lat_long', $lat_long);
    }

    public function getRideInfo(Request $request){
        
        $rides = $request->rides;
        
        $drivers = $request->drivers;
        
        $data = array();
        
        if(isset($rides) && count($rides) > 0){
        
            foreach($rides as $ride){
        
                $ride_info = Requests::find($ride['ride_id']);
                $user_info = '';
                $userName = '';
                if (array_key_exists("ride_type", $ride)) {
                    if ($ride['ride_type'] != "driver") {
                        $user_info = UserApp::find($ride['user_id']);
                        if(!empty($user_info)){
                            $userName = $user_info->prenom . " " . $user_info->nom;
                        }
                    }else{
                        if (!empty($ride_info)) {
                            if ($user_info == '') {
                                $user_info = json_decode($ride_info->user_info, true);
                                if(!empty($user_info)){
                                    $userName = $user_info['name'];
                                }
                            }
                        }

                    }
                }else{
                    if(array_key_exists("user_id",$ride)){
                        $user_info = UserApp::find($ride['user_id']);
                        if(!empty($user_info)){
                            $userName = $user_info->prenom . " " . $user_info->nom;

                        }

                    }

                }
                $driver_info = '';
                if (array_key_exists('driver_id', $ride)) {
                    $driver_info = Driver::select(
                        'tj_conducteur.*',
                        'tj_vehicule.numberplate as car_number',
                        'tj_vehicule.car_make',
                        'brands.name as brand_name',
                        'car_model.name as car_model',
                    )
                        ->join('tj_vehicule', 'tj_vehicule.id_conducteur', '=', 'tj_conducteur.id')
                        ->join('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule.id_type_vehicule')
                        ->leftjoin('brands', 'tj_vehicule.brand', '=', 'brands.id')
                        ->leftjoin('car_model', 'tj_vehicule.model', '=', 'car_model.id')
                        ->find($ride['driver_id']);
                }
                if($ride_info && $driver_info  && ($ride_info->statut == "on ride" || $ride_info->statut == "confirmed")){
        
                    $data[] = array(
                        'driver_id' => $ride['driver_id'],
                        'driver_name' => $driver_info->prenom.' '.$driver_info->nom,
                        'driver_mobile' => $driver_info->phone,
                        'vehicle_brand' => $driver_info->brand_name,
                        'vehicle_number' => $driver_info->car_number,
                        'vehicle_model' => $driver_info->car_model,
                        'vehicle_make' => $driver_info->car_make,
                        'user_id' => $ride['user_id'],
                        'user_name' => $userName,
                        'driver_latitude' => $ride['driver_latitude'],
                        'driver_longitude' => $ride['driver_longitude'],
                        'rotation' => $ride['rotation'],
                        'doc_id' => $ride['doc_id'],
                        'ride_id' => $ride['ride_id'],
                        'ride_status' => $ride_info->statut,
                        'depart_name' => $ride_info['depart_name'],
                        'destination_name' => $ride_info['destination_name'],
                        'flag' => 'on_ride',
                    );
                }   
            }
        }

        if(isset($drivers) && count($drivers) > 0){

            foreach($drivers as $driver){

                $driver_info = Driver::select(
                    'tj_conducteur.*','tj_vehicule.numberplate as car_number','tj_vehicule.car_make',
                    'brands.name as brand_name','car_model.name as car_model',
                )
                ->join('tj_vehicule', 'tj_vehicule.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule.id_type_vehicule')
                ->leftjoin('brands','tj_vehicule.brand','=','brands.id')
                ->leftjoin('car_model','tj_vehicule.model','=','car_model.id')
                ->find($driver['driver_id']);
                
                if($driver_info){

                    $data[] = array(
                        'driver_id' => $driver['driver_id'],
                        'driver_name' => $driver_info->prenom.' '.$driver_info->nom,
                        'driver_mobile' => $driver_info->phone,
                        'vehicle_brand' => $driver_info->brand,
                        'vehicle_number' => $driver_info->car_number,
                        'vehicle_model' => $driver_info->car_model,
                        'vehicle_make' => $driver_info->car_make,
                        'driver_latitude' => $driver['driver_latitude'],
                        'driver_longitude' => $driver['driver_longitude'],
                        'flag' => 'available',
                    );
                }   
            }
        }

        return response()->json($data);
    }

    public function getDefaultLatLong(){

        $sql=DB::table('tj_settings')->select('tj_settings.contact_us_address as address','tj_settings.google_map_api_key as apikey')->first();
        $address=$sql->address;
        $apiKey=$sql->apikey;

        if(!empty($address) && !empty($apiKey)){
        $geo=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$apiKey);
        $geo = json_decode($geo, true);

            if (isset($geo['status']) && $geo['status'] = 'OK') {
                $latitude = $geo['results'][0]['geometry']['location']['lat'];
                $longitude = $geo['results'][0]['geometry']['location']['lng'];
                $latlong = array('lat'=> $latitude ,'lng'=>$longitude);
            }
        }else{
            $latlong = array();
        }
        return $latlong;
    }
}
