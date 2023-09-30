<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\DispatcherRides;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = $this->getOnRides();
        $LatLong=$this->getLatLong();
        return view('home')->with('data',$data)->with('latlong',$LatLong);
    }

    public function dashboard()
    {
        $data = $this->getOnRides();
        $LatLong=$this->getLatLong();
        return view('home')->with('data',$data)->with('latlong',$LatLong);
    }

    public function getOnRides()
    {
        $dispatcher_id = auth()->user()->id;

        $data = array();

        $sql = DB::table('tj_requete')
            ->Join('dispatcher_user', 'dispatcher_user.id', '=', 'tj_requete.dispatcher_id')
            ->Join('tj_conducteur', 'tj_conducteur.id', '=', 'tj_requete.id_conducteur')
            ->join('tj_vehicule','tj_vehicule.id_conducteur','=','tj_requete.id_conducteur')
            ->join('tj_type_vehicule','tj_type_vehicule.id','=','tj_vehicule.id_type_vehicule')
            ->select(
                'tj_conducteur.nom as fistName', 'tj_conducteur.prenom as lastName',
                'tj_conducteur.latitude', 'tj_conducteur.longitude',
                'tj_conducteur.phone as phoneNumber','tj_requete.*','tj_type_vehicule.libelle as vehicle_type','tj_vehicule.numberplate')
            ->where('tj_requete.dispatcher_id', '=', $dispatcher_id)
            ->where('tj_requete.statut', '=', 'on ride')
            ->where('tj_requete.ride_type','=','dispatcher')
            ->orderBy('tj_requete.id', 'desc')
            ->get();

        if($sql){
            foreach ($sql as $row) {
                $data[] = array(
                    'name' => $row->fistName . ' ' . $row->lastName,
                    'mobile' => $row->phoneNumber,
                    'vehicle_number' => $row->numberplate,
                    'vehicle_type_name' => $row->vehicle_type,
                    'latlong' => array($row->latitude_arrivee, $row->longitude_arrivee),

                );
            }
        }

        return $data;

    }
    public function getLatLong(){

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
