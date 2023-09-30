<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\UserApp;
use App\Models\Driver;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Complaints;
use Illuminate\Http\Request;
use DB;

class AddComplaintsController extends Controller
{

    public function __construct()
    {
        $this->limit = 20;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = Complaints::all();
        $users = Complaints::paginate($this->limit);
        return response()->json($users);
    }

    public function register(Request $request)
    {
		$data = array();
        $data['title'] = $request->get('title');
        
        $data['description'] = $request->get('description');
        $data['user_type'] = $request->get('user_type');
        if ($request->get('id_user_app')!=null){
            $data['id_user_app'] = $request->get('id_user_app');
        }
        else{
            $data['id_user_app']='0';
        }
        if ($request->get('id_conducteur')!=null){
            $data['id_conducteur'] = $request->get('id_conducteur');
        }
        else{
            $data['id_conducteur']='0';
        }

        $data['status'] = '1';
        $data['created'] = date('Y-m-d H:i:s');

        $ins = DB::table('tj_complaints')->insert($data);
        if ($ins) {

            $response['success'] = 'success';
            $response['error'] = null;
            $response['message'] = 'Complaint added successfully';
            $response['data'] = $data;
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Failed to add Complaint';
        }

        return response()->json($response);
    }

}