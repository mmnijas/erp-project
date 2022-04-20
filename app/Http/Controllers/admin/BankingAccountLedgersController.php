<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BankingAccountGroups;
use App\Models\BankingAccountLedgers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BankingAccountLedgersController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = BankingAccountLedgers::select('banking_account_ledgers.id','banking_account_ledgers.name','banking_account_ledgers.status','banking_account_groups.name as group','banking_account_ledgers.code','profile_photo')
                                        ->leftjoin('banking_account_groups','banking_account_groups.id','=','banking_account_ledgers.banking_account_group_id')
                                        ->leftjoin('users','users.id','=','banking_account_ledgers.updated_by')
                                        ->where('banking_account_ledgers.business_id',Auth::user()->business_id); 
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $button = '<button type="button" data-href="'.route('banking-account-ledgers.edit',$row->id).'" class="btn btn-xs btn-primary edit_button" data-container=".modal_class"><i class="fa fa-edit"></i></button>&nbsp';
                        $button .='<button data-href="'.route('delete',['banking-account-ledgers',$row->id]).'" class="btn btn-xs btn-danger btn-modal"><i class="fa fa-trash"></i></button>';
                        return $button;
                    })
                    ->addColumn('status',function($row){
                        if($row->status==1){
                            return '<span class="badge badge-success">ACTIVE</span>';
                        }else{
                            return '<span class="badge badge-danger">IN ACTIVE</span>';
                        }
                    })
                    ->editColumn('opening_balance',function($row){
                        if($row->opening_balance){
                            if($row->opening_balance_dc=='D'){
                                return 'Dr. '.$row->opening_balance;
                            }else{
                                return 'Cr. '.$row->opening_balance;
                            }
                        }else{
                            return '0.00';
                        }
                        
                    })
                    ->editColumn('profile_photo',function($row){
                        return '<img src="'.asset($row->profile_photo).'" style="height:50px" alt="UPDATED USER">';
                    })
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->Where('bank_service_commission_groups.name', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['action','status','profile_photo'])
                    ->make(true);
        }
        return view('admin.banking_account_ledgers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {
            $groups = BankingAccountGroups::select('id','name')->where('status',1)->where('business_id',Auth::user()->business_id)->get();
            return view('admin.banking_account_ledgers.create')->with(compact('groups'));
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
            'banking_account_group_id'  => 'required',
            'name'                      => 'required|unique:banking_account_ledgers',
            'code'                      => 'required|unique:banking_account_ledgers',
            'opening_balance'           => 'required',
            'opening_balance_dc'        => 'required',
            'visibility'                => 'required',
            'payment_account'           => 'required',
            'status'                    => 'required',
        ];
        $messages = [
            'banking_account_group_id.required'    => 'Group Required',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }
        try {
            $input = $request->only(['banking_account_group_id','name','code','opening_balance','opening_balance_dc','visibility','payment_account','description','status']);
            $input['business_id']=Auth::user()->business_id;
            $input['created_by']=Auth::id();
            $input['updated_by']=Auth::id();
            BankingAccountLedgers::create($input);
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
            $groups = BankingAccountGroups::select('id','name')->where('status',1)->where('business_id',Auth::user()->business_id)->get();
            $ledger = BankingAccountLedgers::find($id);
            return view('admin.banking_account_ledgers.edit')->with(compact('groups','ledger'));
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
                $ledgers = BankingAccountLedgers::findOrFail($id);
                $ledgers->banking_account_group_id = $request->banking_account_group_id;
                $ledgers->name = $request->name;
                $ledgers->code = $request->code;
                $ledgers->opening_balance = $request->opening_balance;
                $ledgers->opening_balance_dc = $request->opening_balance_dc;
                $ledgers->visibility = $request->visibility;
                $ledgers->payment_account = $request->payment_account;
                $ledgers->status = $request->status;
                $ledgers->description = $request->description;
                $ledgers->save();
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
                $user = BankingAccountLedgers::findOrFail($id);
                $user->delete();
                return response()->json(['success' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'msg' => $e->getMessage()]);
            }
        }
    }
}
