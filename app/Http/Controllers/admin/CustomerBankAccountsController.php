<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banks;
use App\Models\CustomerBankAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CustomerBankAccountsController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = CustomerBankAccounts::select('customer_bank_accounts.id','account_number','customer_bank_accounts.name','customer_bank_accounts.phone','ifsc','registered_numbers','customer_bank_accounts.status','banks.name as bank','common_ifsc','profile_photo')
                                        ->leftjoin('banks','banks.id','=','customer_bank_accounts.bank_id')
                                        ->leftjoin('users','users.id','=','customer_bank_accounts.updated_by')
                                        ->where('customer_bank_accounts.business_id',Auth::user()->business_id); 
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $button = '<button type="button" data-href="'.route('customer-bank-accounts.edit',$row->id).'" class="btn btn-xs btn-primary edit_button" data-container=".modal_class"><i class="fa fa-edit"></i></button>&nbsp';
                        $button .='<button data-href="'.route('delete',['customer-bank-accounts',$row->id]).'" class="btn btn-xs btn-danger btn-modal"><i class="fa fa-trash"></i></button>';
                        return $button;
                    })
                    ->addColumn('status',function($row){
                        if($row->status==1){
                            return '<span class="badge badge-success">ACTIVE</span>';
                        }else{
                            return '<span class="badge badge-danger">IN ACTIVE</span>';
                        }
                    })
                    ->editColumn('profile_photo',function($row){
                        return '<img src="'.asset($row->profile_photo).'" style="height:50px" alt="UPDATED USER">';
                    })
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->Where('customer_bank_accounts.name', 'LIKE', "%$search%");
                                $w->OrWhere('customer_bank_accounts.account_number', 'LIKE', "%$search%");
                                $w->OrWhere('customer_bank_accounts.phone', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['action','status','profile_photo'])
                    ->make(true);
        }
        return view('admin.customer_bank_accounts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {
            $banks = Banks::select('id','name')->where('status',1)->where('business_id',Auth::user()->business_id)->get();
            return view('admin.customer_bank_accounts.create')->with(compact('banks'));
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
        $bank = Banks::findOrFail($request->bank_id);
        $rules = [
            'bank_id'                   => 'required',
            'name'                      => 'required',
            'account_number'            => 'required|string|size:'.$bank->account_number_length,
            'confirm_account_number'    => 'required|same:account_number',
            'phone'                     => 'required|digits:10',
            'status'                    => 'required',
        ];
        $messages = [
            'bank_id.required'    => 'Bank is Required',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }
        try {
            $input = $request->only(['bank_id','account_number','name','phone','ifsc','status']);
            $input['business_id']=Auth::user()->business_id;
            $input['created_by']=Auth::id();
            $input['updated_by']=Auth::id();
            $data = CustomerBankAccounts::create($input);
            return ['success' => true,'msg' => "succussfully added",'data'=>$data];
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
            $banks = Banks::select('id','name','account_number_length')->where('status',1)->where('business_id',Auth::user()->business_id)->get();
            $account = CustomerBankAccounts::find($id);
            return view('admin.customer_bank_accounts.edit')->with(compact('banks','account'));
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
                $accounts = CustomerBankAccounts::findOrFail($id);
                $accounts->bank_id = $request->bank_id;
                $accounts->account_number = $request->account_number;
                $accounts->name = $request->name;
                $accounts->phone = $request->phone;
                $accounts->ifsc = $request->ifsc;
                $accounts->status = $request->status;
                $accounts->updated_by = Auth::id();
                $accounts->save();
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
                $user = CustomerBankAccounts::findOrFail($id);
                $user->delete();
                return response()->json(['success' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'msg' => $e->getMessage()]);
            }
        }
    }
}
