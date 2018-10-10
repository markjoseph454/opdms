<?php

namespace App\Http\Controllers;
use App\Mss;
use App\Patient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\AncillaryItem;
use App\Requisition;
use App\Clinic;
use App\User;
use App\Pharstocks;
use App\Pharitemstatus;
use App\Pdf;
use App\Pharmanagerequest;
use App\Mssclassification;
use App\Approval;
use Validator;
use Auth;
use Session;
use DB;
use Carbon;

class RequisitionController extends Controller
{

    public function __construct()
    {
        $this->middleware('patients', ['only' => ['index']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$medicines = DB::select("SELECT pharstocks.stock, pharstocks.level, pharitemstatus.status, ancillary_items.* FROM ancillary_items
                                    LEFT JOIN pharstocks ON pharstocks.items_id = ancillary_items.id
                                    LEFT JOIN pharitemstatus ON pharitemstatus.items_id = ancillary_items.id
                                    WHERE ancillary_items.clinic_code = 1031 ORDER BY ancillary_items.id");
        $patient = DB::table('patients as pt')
                            ->select(DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as patient"))
		                    ->where('pt.id', '=', Session::get('pid'))
                            ->first();
        return view('doctors.requisition', compact('medicines', 'patient'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
	    //
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
	    $modifier = Str::random(50);
        $pid = $request->session()->get('pid');
	    for ($i=0;$i<count($request->item);$i++){
            $requisition = new Requisition();
            $requisition->users_id = Auth::user()->id;
            $requisition->patients_id = $pid;
            $requisition->item_id = $request->input('item.'.$i);
            $requisition->qty = $request->input('qty.'.$i);
            $requisition->modifier = $modifier;
            $requisition->save();
        }
        Session::flash('toaster', array('success', 'Requisition successfully saved.'));
        return redirect('requisition/'.$requisition->id);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
	    $requisition = Requisition::find($id);
	    $allRequisitions = Requisition::where('modifier', '=', $requisition->modifier)->get();
	    $requisitions = array();
        /*$requisitions = DB::select("SELECT ancillary_items.*, phar.pharQTY, rq.qty, rq.created_at as requisitionDate FROM requisition rq
                                    LEFT JOIN ancillary_items ON ancillary_items.id = rq.item_id
                                    LEFT JOIN(SELECT SUM(pharmanagerequest.qty) as pharQTY, pharmanagerequest.requisition_id as req_id FROM pharmanagerequest LEFT JOIN requisition ON requisition.id = pharmanagerequest.requisition_id WHERE modifier = '".$requisition->modifier."') phar on rq.id = phar.req_id
                                    WHERE modifier = '".$requisition->modifier."'");*/
        $patient = Patient::find($requisition->patients_id);

        foreach ($allRequisitions as $row){
            $requisitions_array = DB::select("SELECT ancillary_items.*, phar.pharQTY, rq.id as rqsid, rq.qty, rq.created_at as requisitionDate FROM requisition rq
                                    LEFT JOIN ancillary_items ON ancillary_items.id = rq.item_id
                                    LEFT JOIN(SELECT SUM(pharmanagerequest.qty) as pharQTY, pharmanagerequest.requisition_id as req_id FROM pharmanagerequest LEFT JOIN requisition ON requisition.id = pharmanagerequest.requisition_id
                                             WHERE pharmanagerequest.requisition_id = $row->id) phar on rq.id = phar.req_id
                                    WHERE rq.id = $row->id");
            array_push($requisitions, $requisitions_array);
        }

        $hideEdit = true;
        foreach ($requisitions as $row){
            if ($row[0]->pharQTY != $row[0]->qty){
                $hideEdit = false;
                break;
            }
        }


        $checkIfForApproval = Approval::where('interns_id', '=', $requisition->users_id)
                                        ->where('approved_by', '=', Auth::user()->id)
                                        ->where('patients_id', '=', $requisition->patients_id)->first();

        return view('doctors.requisition_show', compact('requisitions', 'requisition', 'patient', 'hideEdit', 'checkIfForApproval'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
	    $patientClassification = Mss::checkClassification();

        $medicines = DB::select("SELECT pharstocks.stock, pharstocks.level, pharitemstatus.status, ancillary_items.* FROM ancillary_items
                                    LEFT JOIN pharstocks ON pharstocks.items_id = ancillary_items.id
                                    LEFT JOIN pharitemstatus ON pharitemstatus.items_id = ancillary_items.id
                                    WHERE ancillary_items.clinic_code = 1031 ORDER BY ancillary_items.id");

        $requisition = Requisition::find($id);
        $results = Requisition::where('patients_id', '=', $requisition->patients_id)
                                    ->where('modifier', '=', $requisition->modifier)
                                    ->where('users_id', '=', $requisition->users_id)
                                    /*->where('users_id', '=', $requisition->users_id)*/
                                    ->whereDate('requisition.created_at', '=', Carbon::parse($requisition->created_at)->toDateString())
                                    ->select('requisition.id')
                                    ->get();

        $requisitions = array();
        $checkIfInArray = array();
        $requisitionQty = array();

        foreach ($results as $row) {

            $result = Pharmanagerequest::where('requisition.id', '=', $row->id)
                ->leftJoin('requisition', 'requisition.id', '=', 'pharmanagerequest.requisition_id')
                ->leftJoin('ancillary_items', 'ancillary_items.id', '=', 'requisition.item_id')
                ->select('ancillary_items.*', 'requisition.qty', 'requisition.modifier', 'requisition.id as rid', DB::raw("SUM(pharmanagerequest.qty) as quantity"))
                ->latest()->first();

            array_push($requisitions, $result);
            array_push($checkIfInArray, $result->id);
            if ($result->quantity != null){
                array_push($requisitionQty, $result->id);
            }
        }
        $patient = Patient::find($requisition->patients_id);
        $forApproval = $requisition;

        return view('doctors.requisition_edit', compact('requisitions', 'medicines', 'forApproval', 'patientClassification', 'checkIfInArray', 'requisitionQty', 'patient'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{

	}


	public function choosedepartment(Request $request)
	{
		/*$medicines = AncillaryItem::where('clinic_code', '=', $request->clinic_code)->get();*/
        $medicines = DB::select("SELECT pharstocks.stock, pharstocks.level, pharitemstatus.status, ancillary_items.* FROM ancillary_items
                                    LEFT JOIN pharstocks ON pharstocks.items_id = ancillary_items.id
                                    LEFT JOIN pharitemstatus ON pharitemstatus.items_id = ancillary_items.id
                                    WHERE ancillary_items.clinic_code = $request->clinic_code ORDER BY ancillary_items.id");
		echo json_encode($medicines);
		return;
	}


	public function checkMssClassification(Request $request)
    {
        $pid = $request->session()->get('pid');
        $mssClassification = Mssclassification::where('patients_id', '=', $pid)
                                ->leftJoin('mss', 'mss.id', '=', 'mssclassification.mss_id')
                                ->select('mss.label', 'mss.description', 'mss.discount')
                                ->first();
        echo json_encode($mssClassification);
        return;
    }

    public function requisitions_list($id = false)
    {
        $requisitions = Requisition::where('patients_id', '=', $id)
                                        ->leftJoin('patients as pt', 'pt.id', '=', 'requisition.patients_id')
                                        ->leftJoin('users as us', 'us.id', '=', 'requisition.users_id')
                                        ->leftJoin('clinics', 'clinics.id', '=', 'us.clinic')
                                        ->groupBy('requisition.users_id', 'requisition.modifier', DB::raw("DATE(requisition.created_at)"))
                                        ->orderBy('requisition.created_at', 'DESC')
                                        ->select('requisition.*', 'clinics.name as clinic', DB::raw("CONCAT(pt.last_name,', ',pt.first_name,' ',CASE WHEN pt.suffix IS NOT NULL THEN pt.suffix ELSE '' END,' ',CASE WHEN pt.middle_name IS NOT NULL THEN LEFT(pt.middle_name, 1) ELSE '' END) as name"), DB::raw("CONCAT(us.first_name,' ', LEFT(us.middle_name, 1),'.',' ',us.last_name) as doctor"))
                                        ->get();
        return view('doctors.requisition_list', compact('requisitions'));
    }


    public function requisitionUpdate(Request $request)
    {
        /*count if a request is present and not null*/
        if (count($request) > 0 && $request->has('item')){
            $allResuisitionItemID = array(); /*all requisitions that is being edited*/
            $insertNewRequisition = array(); /*all new requisitions*/
            foreach ($request->item as $item){
                $explodeItemId = explode("_", $item); /*explode requisition id format {rid}_item */
                if (isset($explodeItemId[1])){
                    array_push($allResuisitionItemID, $explodeItemId[0]); /*push all requisition that is being edited*/
                    array_push($insertNewRequisition, $explodeItemId[1]); /*insert all new and already on the requisitions table to this array*/
                }else{
                    array_push($insertNewRequisition, $explodeItemId[0]); /*insert all new requisition*/
                }
            }

            if (count($allResuisitionItemID) > 0){
                for ($i=0;$i<count($allResuisitionItemID);$i++){
                    Requisition::find($allResuisitionItemID[$i])->update(['qty'=>$request->input('qty.'.$i)]); /*update the requisition qty*/
                    $get_Requisition = Requisition::find($allResuisitionItemID[0]);
                    $modifier = $get_Requisition->modifier;
                }
            }

            if (isset($request->modifier)){ /*i included a modifier request on html*/
                $deleteReq = Requisition::where('modifier', '=', $request->modifier)->get();
                foreach ($deleteReq as $delReq){
                    if (!in_array($delReq->id, $allResuisitionItemID)){
                        Requisition::find($delReq->id)->delete(); /*delete all requisition that was been unchecked */
                    }
                }
            }

            if (count($insertNewRequisition) > 0){ /*insert all new requisitions*/
                if (count($allResuisitionItemID) > 0){
                    $getRequisition = Requisition::find($allResuisitionItemID[0]);
                    $modifier = $getRequisition->modifier;
                }else{
                    $modifier = $modifier = Str::random(50);
                }
                for ($j=0;$j<count($insertNewRequisition);$j++){
                    if ($insertNewRequisition[$j] != 'item'){
                        $requisition = new Requisition();
                        $requisition->users_id = $request->doctors_id;
                        $requisition->patients_id = $request->patientID;
                        $requisition->item_id = $request->input('item.'.$j);
                        $requisition->qty = $request->input('qty.'.$j);
                        $requisition->modifier = $modifier;
                        $requisition->created_at = $deleteReq[0]->created_at;
                        $requisition->save();
                    }
                }
            }

            if (isset($modifier)){
                $redirectId = Requisition::where('modifier', '=', $modifier)->select('id')->first();
            }

            Session::flash('toaster', array('success', 'Requisition successfully updated.'));
            return redirect('requisition/'.$redirectId->id);

        }else{
            $reqIDS=Requisition::where('modifier', '=', $request->modifier)->pluck('id');
            Requisition::destroy($reqIDS);
            Session::flash('toaster', array('error', 'Requisition has been deleted'));
            return redirect('requisition');
        }
        return redirect()->back();
    }





    public function requisition_print($id = false)
    {
        $requisition = Requisition::find($id);
        $requisitions = Requisition::where('patients_id', '=', $requisition->patients_id)
                                    ->where('users_id', '=', $requisition->users_id)
                                    ->where('modifier', '=', $requisition->modifier)
                                    ->whereDate('requisition.created_at', '=', Carbon::parse($requisition->created_at)->toDateString())
                                    ->leftJoin('ancillary_items', 'ancillary_items.id', '=', 'requisition.item_id')
                                    ->select('ancillary_items.*', 'requisition.qty', 'requisition.created_at as requisitionDate')
                                    ->get();

        $pdf = new Pdf();
        $pdf->setPatientID($requisition->patients_id);
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->SetMargins(5,55,5,5);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(5);
        $pdf->SetAutoPageBreak(TRUE, 15);
        $pdf->SetTitle('Requisition');
        $pdf->AddPage('P',array(105,148.5));
        $pdf->SetFont('times','',8);

        $table = \View::make('doctors.requisition_printing', compact('requisitions'));

       $pdf->writeHTML($table, true, false, false, false, '');
       $pdf->Output();
       return;
    }





}
