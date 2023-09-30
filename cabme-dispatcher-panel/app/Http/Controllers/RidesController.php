<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\Currency;
use App\Models\Driver;
use App\Models\VehicleType;
use App\Models\UserApp;
use App\Models\DispatcherUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;


class RidesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all(Request $request, $id = null)
    {
        $dispatcher_id = Auth::user()->id;
        $currency = Currency::where('statut', 'yes')->first();

        if ($request->has('ride_status') && $request->ride_status != '') {
            $search = $request->input('ride_status');
            $rides = DB::table('tj_requete')
            ->join('tj_conducteur','tj_conducteur.id','=','tj_requete.id_conducteur')
            ->join('tj_user_app','tj_user_app.id','=','tj_requete.id_user_app')
            ->select('tj_requete.*','tj_conducteur.nom as driverNom','tj_conducteur.prenom as driverPreNom',
                   'tj_user_app.nom as userNom','tj_user_app.prenom as userPreNom')
                ->orderBy('creer', 'DESC')
                ->where('tj_requete.statut', 'LIKE', '%' . $search . '%')
                ->where('dispatcher_id', '=', $dispatcher_id)
                ->paginate(20);
        } else {


            $rides = DB::table('tj_requete')
          ->join('tj_conducteur','tj_conducteur.id','=','tj_requete.id_conducteur')
          ->join('tj_user_app','tj_user_app.id','=','tj_requete.id_user_app')
          ->select('tj_requete.*','tj_conducteur.nom as driverNom','tj_conducteur.prenom as driverPreNom',
                 'tj_user_app.nom as userNom','tj_user_app.prenom as userPreNom')
          ->where('dispatcher_id', '=', $dispatcher_id)->orderBy('creer', 'DESC')->paginate(20);


        }

        return view("rides.all")->with('rides', $rides)->with('currency', $currency)->with('id', $id);
    }


    public function filterRides(Request $request)
    {
        $page = $request->input('pageName');
        $fromDate = $request->input('datepicker-from');
        $toDate = $request->input('datepicker-to');

        if ($page == "allpage") {
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle')
                ->orderBy('tj_requete.creer', 'DESC')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->paginate(10);
            return view("rides.all")->with("rides", $rides);
        } else {

        }

    }

    public function deleteRide($id)
    {

        if ($id != "") {
            $id = json_decode($id);

            if (is_array($id)) {

                for ($i = 0; $i < count($id); $i++) {
                    $user = Requests::find($id[$i]);
                    $user->delete();
                }

            } else {
                $user = Requests::find($id);
                $user->delete();
            }

        }

        return redirect()->back();
    }

    public function show($id)
    {
        $currency = Currency::where('statut', 'yes')->first();

        $ride = Requests::join('tj_payment_method','tj_payment_method.id','=','tj_requete.id_payment_method')
        ->leftjoin('tj_conducteur','tj_conducteur.id','=','tj_requete.id_conducteur')
        ->leftjoin('tj_user_app','tj_user_app.id','=','tj_requete.id_user_app')
        ->leftjoin('dispatcher_user','dispatcher_user.id','=','tj_requete.dispatcher_id')
        ->leftjoin('tj_vehicule','tj_vehicule.id_conducteur','=','tj_requete.id_conducteur')
        ->leftjoin('tj_type_vehicule','tj_type_vehicule.id','=','tj_vehicule.id_type_vehicule')
       ->leftjoin('brands','tj_vehicule.brand','=','brands.id')
       ->leftjoin('car_model','tj_vehicule.model','=','car_model.id')
        ->select('tj_requete.*','tj_payment_method.libelle as payment_methods','tj_type_vehicule.libelle','tj_conducteur.nom as driverNom','tj_conducteur.prenom as driverPreNom',
            'tj_conducteur.phone as driverPhone','tj_conducteur.email as driverEmail','tj_conducteur.photo_path',
             'tj_user_app.nom as userNom','tj_user_app.prenom as userPreNom','tj_user_app.phone as userPhone',
            'tj_user_app.email as userEmail','tj_vehicule.numberplate','brands.name as brand','car_model.name as model','tj_vehicule.car_make'
            )
        ->where('tj_requete.id', $id)->first();

        return view("rides.show")->with("ride", $ride)->with("currency", $currency);
    }

    public function updateRide(Request $request, $id)
    {
        $rides = Requests::find($id);
        if ($rides) {
            $rides->statut = $request->input('order_status');
            $rides->save();
        }

        return redirect(route('rides'));

    }

}
