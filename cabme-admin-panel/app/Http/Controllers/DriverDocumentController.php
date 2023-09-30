<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverDocument;
use App\Models\DriversDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;


class DriverDocumentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if ($request->has('search') && $request->search != '' && $request->selected_search == 'title') {
            $search = $request->input('search');
            $document = DB::table('admin_documents')->where('admin_documents.title', 'LIKE', '%' . $search . '%')
            ->paginate(10);
        }
        else{
            $document = DriverDocument::paginate(10);
        }

        return view("administration_tools.driverDocument.index")->with("document", $document);
    }

    public function create()
    {
        return view("administration_tools.driverDocument.create");
    }

    public function storeDocument(Request $request)
    {

        $validator = Validator::make($request->all(), $rules = [
            'title' => 'required',
        ], $messages = [
            'title.required' => 'The Title field is required!',

        ]);

        if ($validator->fails()) {
            return redirect('driver_document/create')
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }
        $document = new DriverDocument;
        $document->title = $request->input('title');
        if ($request->input('status')) {
            $document->is_enabled = "Yes";
        } else {
            $document->is_enabled = "No";
        }

		Driver::where('id', '!=', '0')->update(['is_verified' => 0]);

        $document->save();
        return redirect('administration_tools/driver_document');

    }

    public function edit($id)
    {

        $document = DriverDocument::where('id', "=", $id)->first();
        return view("administration_tools.driverDocument.edit")->with("document", $document);
    }


    public function documentUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $rules = [
            'title' => 'required',

        ], $messages = [
            'title.required' => 'The Title field is required!',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }

        $title = $request->input('title');

        if ($request->input('status')) {
            $status = "Yes";
        } else {
            $status = "No";
        }


        $document = DriverDocument::find($id);
        if ($document) {
            $document->title = $title;
            $document->is_enabled = $status;
            $document->save();
        }

        return redirect('administration_tools/driver_document');
    }

    public function deleteDocument($id)
    {

        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {


                for ($i = 0; $i < count($id); $i++) {
                   DriversDocuments::where('document_id',$id[$i])->delete();
                    $user = DriverDocument::find($id[$i]);
                    $user->delete();
                }

            } else {
                DriversDocuments::where('document_id',$id)->delete();
                $user = DriverDocument::find($id);
                $user->delete();
            }


        }

        return redirect()->back();
    }

public function toggalSwitch(Request $request){
        $ischeck=$request->input('ischeck');
        $id=$request->input('id');
        $document = DriverDocument::find($id);

        if($ischeck=="true"){
            $document->is_enabled = 'Yes';
        }else{
            $document->is_enabled = 'No';
        }
          $document->save();

}

}
