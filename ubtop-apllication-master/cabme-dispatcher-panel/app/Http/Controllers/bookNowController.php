<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\UserApp;
use App\Models\VehicleType;
use App\Models\settings;
use App\Http\Controllers\GcmController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Response;

class bookNowController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $booknow = Requests::all()->where('ride_type','=','dispatcher');
        return view('rides')->with('booknow', $booknow);
    }

    public function create()
    {

        $vehicleType = VehicleType::all();
        $UserApp = UserApp::all();
        $LatLong=$this->getLatLong();

        return view('rides.book_now')->with('vehicleType', $vehicleType)->with('UserApp', $UserApp)->with('latlong',$LatLong);
    }

    public function createUser()
    {

        return view('users.create');
    }


    public function storeUser(Request $request)
    {

        $validator = Validator::make($request->all(), $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:tj_user_app',
            'email' => 'required|unique:tj_user_app',
            'password'=>'required',
        ], $messages = [
            'first_name.required' => 'The First Name field is required!',
            'last_name.required' => 'The Last Name field is required!',
            'email.required' => 'The Email field is required!',
            'email.unique' => 'The Email is already taken!',
            'phone.required' => 'The Phone is required!',
            'phone.unique' => 'The Phone field is should be unique!',
            'password'=>'The Password field is required!'
        ]);

        if ($validator->fails()) {
            return redirect('bookNow/createUser')
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }
        $user = new UserApp;
        $user->nom = $request->input('first_name');
        $user->prenom = $request->input('last_name');
        $user->email = $request->input('email');
        $user->mdp = md5($request->input('password'));
        $user->login_type = 'phone';
        $user->phone = $request->input('phone');

        $user->statut = $request->has('statut') ? 'yes' : 'no';

        $user->creer = date('Y-m-d H:i:s');
        $user->modifier = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');

        $user->save();
        return redirect('bookNow');

    }

    public function store(Request $request)
    {

        $user = Auth::user();
        $user_id = $user->id;

        $validator = Validator::make($request->all(), $rules = [
            'user_id' => 'required',
            'pickup' => 'required',
            'dropup' => 'required',
            'vehicle_id' => 'required',

        ], $messages = [
            'user_id.required' => 'The User field is required!',
            'phone.required' => 'The Phone field is required!',
            'pickup.required' => 'The Pickup field is required!',
            'dropup.required' => 'The Dropup field is required!',
            'vehicle_id.required' => 'The Vehicle Type field is required!',

        ]);

        if ($validator->fails()) {
            return redirect('bookNow')
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }

        $booknow = new Requests;
        $booknow->id_user_app = $request->input('user_id');
        $booknow->depart_name = $request->input('pickup');
        $booknow->latitude_depart = $request->input('pickup_lat');
        $booknow->longitude_depart = $request->input('pickup_long');
        $booknow->destination_name = $request->input('dropup');
        $booknow->latitude_arrivee = $request->input('drop_lat');
        $booknow->longitude_arrivee = $request->input('drop_lng');
        $booknow->ride_type = 'dispatcher';

        $vehicleType_id = $request->input('vehicle_id');
        $booknow->montant=$request->input('montant');
        $booknow->duree=$request->input('duree');
        $booknow->number_poeple=$request->input('number_poeple');
        $payment_method = $request->input('payment_opt');
        $payment_id = 0;
        $delivery_distance = '';
        $sql = DB::table('tj_payment_method')->select('id')->where('libelle', '=', $payment_method)->first();

        $payment_id = $sql->id;

        $sql = DB::table('tj_settings')->select('delivery_distance','driver_radios')->first();

        $booknow->distance_unit = $sql->delivery_distance;
        $booknow->distance=$request->input('distance');
        $booknow->id_payment_method = $payment_id;
        $booknow->statut = 'new';
        $booknow->creer = date('Y-m-d H:i:s');
        $booknow->updated_at = date('Y-m-d H:i:s');

        $lat = $booknow->latitude_arrivee;
        $long = $booknow->longitude_arrivee;
        $radius = $sql->driver_radios;
        $data = DB::table("tj_conducteur")
            ->join('tj_vehicule','tj_conducteur.id','=','tj_vehicule.id_conducteur')
            ->select("tj_conducteur.id"
                , DB::raw("3959  * acos(cos(radians(" . $lat . "))
            * cos(radians(tj_conducteur.latitude))
            * cos(radians(tj_conducteur.longitude) - radians(" . $long . "))
            + sin(radians(" . $lat . "))
            * sin(radians(tj_conducteur.latitude))) AS distance"))
            ->having('distance', '<',  $radius)
            ->where('id_type_vehicule','=',$vehicleType_id)
            ->orderBy('distance', 'asc')
            ->get();

        if(count($data)>0){


        foreach ($data as $val) {

            $booknow->save();

            $bookingId = $booknow->id;
            //$distance = number_format(floatval($val->distance),3);
            $driverId = $val->id;
            $updatedata = DB::update('UPDATE tj_requete SET statut = ?,dispatcher_id = ?,id_conducteur=? WHERE id = ?', ['new', $user_id, $driverId, $bookingId]);
            $title = str_replace("'", "\'", "New ride");
            $msg = str_replace("'", "\'", "You have just received a request from a client");

            $tab[] = array();
            $tab = explode("\\", $msg);
            $msg_ = "";
            for ($i = 0; $i < count($tab); $i++) {
                $msg_ = $msg_ . "" . $tab[$i];
            }
            $message = array("body" => $msg_, "title" => $title, "sound" => "mySound", "tag" => "ridenewrider");
            $query = DB::table('tj_conducteur')
                ->select('fcm_id')
                ->where('fcm_id', '<>', '')
                ->where('id', '=', $driverId)
                ->get();
                $tokens = array();
                if ($query->count() > 0) {
                    foreach ($query as $user) {
                        if (!empty($user->fcm_id)) {
                            $tokens[] = $user->fcm_id;
                        }
                    }
                }
                $temp = array();
                if (count($tokens) > 0) {
                    GcmController::send_notification($tokens, $message, $temp);
                }

            return redirect('rides');

        }

      }  else{
             return redirect('bookNow')
            ->withErrors(['errors' => "No Driver found"]);
      }
    }

    public function getLatLong(){
          $sql=DB::table('tj_settings')->select('tj_settings.contact_us_address as address','tj_settings.google_map_api_key as apikey')->first();
          $address=$sql->address;
          $apiKey=$sql->apikey;

        //  $latlong = array();
        //  $prepAddr = str_replace(' ','+',$address);
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
    public function getDistance(Request $request){
        $vehicle_type=$request->input('vehicle_type');
        $pickup_lat=$request->input('pickup_lat');
        $pickup_lng=$request->input('pickup_lng');
        $drop_lat=$request->input('drop_lat');
        $drop_lng=$request->input('drop_lng');
        $theta = $drop_lng - $pickup_lng;
       $dist = sin(deg2rad($pickup_lat)) * sin(deg2rad($drop_lat)) + cos(deg2rad($pickup_lat)) * cos(deg2rad($drop_lat)) * cos(deg2rad($theta));
       $dist = 6378.8*acos($dist);
       $sql=DB::table('delivery_charges')->select('minimum_delivery_charges_within_km','minimum_delivery_charges','delivery_charges_per_km')
                                    ->where('id_vehicle_type','=',$vehicle_type)->first();
        $minimum_delivery_charges_within_km=$sql->minimum_delivery_charges_within_km;
        $minimum_delivery_charges=$sql->minimum_delivery_charges;
        $delivery_charges_per_km=$sql->delivery_charges_per_km;
        if(floatval($dist)>floatval($minimum_delivery_charges_within_km)){
              $amount=floatval($dist)*floatval($delivery_charges_per_km);
        }else{
              $amount=floatval($minimum_delivery_charges);
        }
        $sql=DB::table('tj_currency')->select('symbole')->where('statut','=','yes')->first();
        $currency=$sql->symbole;
        $sql=DB::table('tj_settings')->select('tj_settings.google_map_api_key as apikey')->first();

        $apiKey=$sql->apikey;
        $distance_data = file_get_contents(
                'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$pickup_lat.'%2C'.$pickup_lng.'&destinations='.$drop_lat.'%2C'.$drop_lng.'&key='.$apiKey
            );
            $distance_arr = json_decode($distance_data);
            //print_r($distance_arr->rows[0]);
            foreach ( $distance_arr->rows[0] as  $key =>$element )  {
              //print_r( json_decode($element[0]->duration));
              $duration_arr=json_decode(json_encode($element[0]->duration), true);
              $duration=$duration_arr['text'];
            }

        $data=array('distance'=>$dist,'duration'=>$duration,'amount'=>$amount,'currency'=>$currency);
        echo json_encode($data);

    }


    public static function distance($lat1, $lon1, $lat2, $lon2, $unit) {
		if (($lat1 == $lat2) && ($lon1 == $lon2)) {
			return 0;
		} else {
			$theta = $lon1 - $lon2;

			$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$miles = $dist * 60 * 1.1515;
			$unit = strtoupper($unit);

			if ($unit == "K") {
				return ($miles * 1.609344);
			} else if ($unit == "N") {
				return ($miles * 0.8684);
			} else {
				return $miles;
			}
		}
	}
}
