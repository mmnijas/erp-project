<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banks;
use App\Models\BankServiceCharges;
use App\Models\BankTransactionItems;
use App\Models\BankTransactions;
use App\Models\BankTransactionSettings;
use App\Models\CustomerBankAccounts;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BankTransactionsController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = BankTransactions::select('bank_transactions.id','invoice_number','bank_transactions.status','profile_photo')
                                        ->leftjoin('users','users.id','=','bank_transactions.updated_by')
                                        ->where('bank_transactions.business_id',Auth::user()->business_id); 
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $button = '<button type="button" data-href="'.route('bank-transactions.edit',$row->id).'" class="btn btn-xs btn-primary edit_button" data-container=".modal_class"><i class="fa fa-edit"></i></button>&nbsp';
                        $button .='<button data-href="'.route('delete',['bank-transactions',$row->id]).'" class="btn btn-xs btn-danger btn-modal"><i class="fa fa-trash"></i></button>';
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
                                $w->Where('bank_transactions.name', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['action','status','profile_photo'])
                    ->make(true);
        }
        return view('admin.bank_transactions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(BankTransactionSettings::where('business_id',Auth::user()->business_id)->doesntExist()){
            return redirect()->back()->withInput()->with(['status' => 'danger','message' =>'DEFAULT LEDGERS NOT MAPPED']);
        }
        $settings = BankTransactionSettings::where('business_id',Auth::user()->business_id)->first();
        if($settings['cash_ledger_id']==null){
            return redirect()->back()->withInput()->with(['status' => 'danger','message' =>'DEFAULT CASH ACCOUNT LEDGER NOT MAPPED']);
        }
        if(empty($settings['customer_ledger_id'])){
            return redirect()->back()->withInput()->with(['status' => 'danger','message' =>'DEFAULT CUSTOMER LEDGER NOT MAPPED']);
        }
        return view('admin.bank_transactions.create');
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
            'customer_account_id'           => 'required',
            'amount'                        => 'required',
            'service_charge'                => 'required',
            'discount'                      => 'required',
            'final_total'                   => 'required',
            'denomination_2000'             => 'required',
            'denomination_500'              => 'required',
            'denomination_200'              => 'required',
            'denomination_100'              => 'required',
            'denomination_50'               => 'required',
            'denomination_20'               => 'required',
            'denomination_10'               => 'required',
            'denomination_custom'           => 'required',
        ];
        $messages = [
            'customer_account_id.required'    => 'Customer Account ID is Required',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $settings = Settings::first();
        $settings = BankTransactionSettings::where('business_id',Auth::user()->business_id)->first();
        if(empty($settings['cash_ledger_id'])){
            return redirect()->back()->withInput()->with(['status' => 'danger','message' =>'DEFAULT CASH ACCOUNT LEDGER NOT MAPPED']);
        }
        if(empty($settings['customer_ledger_id'])){
            return redirect()->back()->withInput()->with(['status' => 'danger','message' =>'DEFAULT CUSTOMER LEDGER NOT MAPPED']);
        }
        try {
            $transaction = new BankTransactions();
            $transaction->business_id = Auth::user()->business_id;
            $transaction->customer_id = $request->customer_account_id;
            $transaction->type = 'receipt';
            $transaction->transaction_date = now();
            $transaction->amount = $request->amount;
            $transaction->service_charge = $request->service_charge;
            $transaction->discount = $request->discount;
            $transaction->final_total = $request->final_total;
            $transaction->invoice_number = rand(10000,99999);
            $transaction->denomination_2000 = $request->denomination_2000;
            $transaction->denomination_500 = $request->denomination_500;
            $transaction->denomination_200 = $request->denomination_200;
            $transaction->denomination_100 = $request->denomination_100;
            $transaction->denomination_50 = $request->denomination_50;
            $transaction->denomination_20 = $request->denomination_20;
            $transaction->denomination_10 = $request->denomination_10;
            $transaction->denomination_custom = $request->denomination_custom;
            $transaction->status = 1;
            $transaction->created_by = Auth::id();
            $transaction->updated_by = Auth::id();
            $transaction->save();

            $item1 = new BankTransactionItems();
            $item1->business_id = Auth::user()->business_id;
            $item1->transaction_id = $transaction->id;
            $item1->ledger_id = $settings['cash_ledger_id'];
            $item1->amount = $transaction->final_total;
            $item1->type = 'D';
            $item1->save();

            $item2 = new BankTransactionItems();
            $item2->business_id = Auth::user()->business_id;
            $item2->transaction_id = $transaction->id;
            $item2->ledger_id = $settings['customer_ledger_id'];
            $item2->amount = $transaction->final_total;
            $item2->type = 'C';
            $item2->save();
            
            return redirect('admin/bank-transactions')->with(['status' => 'success','message' => 'PAYMENT ADDED SUCCESSFULLY!']);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with(['status' => 'danger','message' => $e->getMessage()]);
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
            $account = BankTransactions::find($id);
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
                $accounts = BankTransactions::findOrFail($id);
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
                $user = BankTransactions::findOrFail($id);
                $user->delete();
                return response()->json(['success' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'msg' => $e->getMessage()]);
            }
        }
    }
    public function get_customer_account2()
    {
        if (request()->ajax()) {
            $term = request()->input('q','');
            $accounts = CustomerBankAccounts::where('status',1)->where('business_id',Auth::user()->business_id);
            if (!empty($term)) {
                $accounts->where(function ($query) use ($term) {
                    $query->where('customer_bank_accounts.name', 'like', '%' . $term .'%')
                            ->orWhere('phone', 'like', '%' . $term .'%')
                            ->orWhere('account_number', 'like', '%' . $term .'%');
                });
            }
            $accounts->select('id','name','account_number','phone');
            $accounts = $accounts->get();
            return json_encode($accounts);
        }
    }

    public function get_customer_account(){
        if (request()->ajax()) {
            $term = request()->input('searchTerm','');
            $accounts = CustomerBankAccounts::where('status',1)->where('business_id',Auth::user()->business_id);
            if (!empty($term)) {
                $accounts->where(function ($query) use ($term) {
                    $query->where('customer_bank_accounts.name', 'like', '%' . $term .'%')
                            ->orWhere('phone', 'like', '%' . $term .'%')
                            ->orWhere('account_number', 'like', '%' . $term .'%');
                });
            }
            $accounts->select('id','name','account_number','phone');
            $accounts = $accounts->get();
            $json = [];
            foreach ($accounts as $row) {
                $json[] = ['id' => $row['id'], 'text' => $row['name'] . ' | PHONE:' . $row['phone'] . ' | A/C NO:' . $row['account_number']];
            }
            echo json_encode($json);
        }
    }

    public function get_service_charge(Request $request){
        if (request()->ajax()) {
            if($request->account_id==null){
                return response()->json(['success' => false,'msg' =>'Account should be selected']);
            }
            try {
                $accounts = CustomerBankAccounts::select('group_id','registered_numbers')
                        ->leftjoin('banks','banks.id','=','customer_bank_accounts.bank_id')
                        ->where('customer_bank_accounts.id','=',$request->account_id)
                        ->first();
                        if($request->amount==null){
                            return response()->json(['success' => false,'msg' =>'Please enter Amount','registered_numbers'=>$accounts['registered_numbers']]);
                        }
                if(BankServiceCharges::where('lower_limit','<=',$request->amount)->where('upper_limit','>=',$request->amount)->where('group_id','=',$accounts['group_id'])->doesntExist()){
                    return response()->json(['success' => false,'msg' =>'Charge Does not Exist, Please update Charge sheet!','registered_numbers'=>$accounts['registered_numbers']]);
                }
                $chargeinfo = BankServiceCharges::select('type','value')
                        ->where('lower_limit','<=',$request->amount)
                        ->where('upper_limit','>=',$request->amount)
                        ->where('group_id','=',$accounts['group_id'])
                        ->first();
                if($chargeinfo['type']=='fixed'){
                    $charge = $chargeinfo['value'];
                }else{
                    $charge = ($request->amount*$chargeinfo['value'])/100;
                }
                return response()->json(['success' => true,'msg' =>'Amounts updated','charge'=>$charge,'registered_numbers'=>$accounts['registered_numbers']]);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'msg' => $e->getMessage()]);
            }
        }
    }
}
