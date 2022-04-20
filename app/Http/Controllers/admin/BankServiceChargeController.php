<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BankServiceCharges;
use App\Models\BankServiceCommissionGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BankServiceChargeController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = BankServiceCharges::select('bank_service_charges.id','bank_service_commission_groups.name','lower_limit','upper_limit','type','value')
                                        ->leftjoin('bank_service_commission_groups','bank_service_commission_groups.id','=','bank_service_charges.group_id')
                                        ->where('bank_service_charges.business_id',Auth::user()->business_id); 
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $button = '<button type="button" data-href="'.route('bank-service-charges.edit',$row->id).'" class="btn btn-xs btn-primary edit_button" data-container=".modal_class"><i class="fa fa-edit"></i></button>&nbsp';
                        $button .='<button data-href="'.route('delete',['bank-service-charges',$row->id]).'" class="btn btn-xs btn-danger btn-modal"><i class="fa fa-trash"></i></button>';
                        return $button;
                    })
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->Where('bank_service_commission_groups.name', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.bank_service_charges.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {
            $groups = BankServiceCommissionGroups::select('id','name')->where('status',1)->where('business_id',Auth::user()->business_id)->get();
            return view('admin.bank_service_charges.create')->with(compact('groups'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'group_id'     => 'required',
            'lower_limit'     => 'required',
            'upper_limit'     => 'required',
            'type'     => 'required',
            'value'     => 'required',
        ];
        $messages = [
            'group_id.required'    => 'Group Required',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }
        
        $charges = BankServiceCharges::select('upper_limit')->where('group_id',$request->group_id)->orderBy('upper_limit','desc')->first();
        if($charges){
            $lower_limit = $charges['upper_limit']+1;
        }else{
            $lower_limit = 1;
        }
        if($lower_limit!=$request->lower_limit){
            return response()->json(['success' => false, 'msg' =>'Lower limit should be : '.$lower_limit]);
        }
        if($request->lower_limit>=$request->upper_limit){
            return response()->json(['success' => false, 'msg' =>'Upper limit should be higher to lower limit']);
        }
        if(BankServiceCharges::where('group_id',$request->group_id)->where('upper_limit','>=',$request->lower_limit)->exists()){
            return response()->json(['success' => false, 'msg' =>'Limit already exist! Add limit that are not exist']);
        }
        try {
            $input = $request->only(['group_id','lower_limit','upper_limit','type','value']);
            $input['business_id']=Auth::user()->business_id;
            $input['created_by']=Auth::id();
            $input['updated_by']=Auth::id();
            BankServiceCharges::create($input);
            return ['success' => true,'msg' => "succussfully added"];
        } catch (\Exception $e) {
            return ['success' => false,'msg' => $e->getMessage()];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $groups = BankServiceCommissionGroups::select('id','name')->where('status',1)->where('business_id',Auth::user()->business_id)->get();
            $charge = BankServiceCharges::find($id);
            return view('admin.bank_service_charges.edit')->with(compact('groups','charge'));
        }
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
        if (request()->ajax()) {
            try {
                $input = $request->only(['type','value']);
                $states = BankServiceCharges::findOrFail($id);
                if ($states->type != $input['type']) {
                    $states->type = $input['type'];
                    $states->save();
                }
                if ($states->value != $input['value']) {
                    $states->value = $input['value'];
                    $states->save();
                }
                return ['success' => true,'msg' =>'successfully updated'];
            } catch (\Exception $e) {
                return ['success' => false, 'msg' => $e->getMessage()];
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if (request()->ajax()) {
            try {
                $user = BankServiceCharges::findOrFail($id);
                $user->delete();
                return response()->json(['success' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'msg' => $e->getMessage()]);
            }
        }
    }
}
