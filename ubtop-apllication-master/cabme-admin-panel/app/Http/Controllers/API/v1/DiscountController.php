<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\UserApp;
use App\Models\Driver;
use App\Models\Currency;
use App\Models\Country;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class DiscountController extends Controller
{

   public function __construct()
   {
      $this->limit=20;
   }
  /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

  public function discountList()
  {

    $today = Carbon::now();

            $sql = DB::table('tj_discount')
            ->where('statut','=','yes')
            ->where('expire_at','>=',$today)

            ->get();
                if(!empty($sql)){
                    foreach($sql as $row){
                      $row->id=(string)$row->id;
                     $row->expire_at= date('d F Y',strtotime($row->expire_at)).' '. date('h:i A',strtotime($row->expire_at));
                    // $expire_at = $row->expire_at->format('j-f-Y');
                    // $expire_at = Carbon::parse($row->expire_at)->format('d F,Y');

                    //  $row->expire_at = $expire_at;
                        $output[] = $row;
                    }
                    if(!empty($output)){

                        $response['success']= 'success';
                        $response['error']= null;
                        $response['message']= 'successfully';
                        $response['data'] = $output;
                    }else{
                      $response['success']= 'Failed';
                      $response['error']= 'No Data Found';
                      $response['message']= null;
                    }

                }

                else{
                    $response['success']= 'Failed';
                    $response['error']= 'Not Found';
                }




    return response()->json($response);
  }

}
