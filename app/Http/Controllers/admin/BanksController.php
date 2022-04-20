<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banks;
use App\Models\BankServiceCommissionGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BanksController extends Controller
{
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = Banks::select('banks.id','banks.name','common_ifsc','account_number_length','banks.status','bank_service_commission_groups.name as group','profile_photo')
                            ->leftjoin('bank_service_commission_groups','bank_service_commission_groups.id','=','banks.group_id')
                            ->leftjoin('users','users.id','=','banks.created_by')
                            ->where('banks.business_id',Auth::user()->business_id); 
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $button = '<button type="button" data-href="'.route('banks.edit',$row->id).'" class="btn btn-xs btn-primary edit_button" data-container=".modal_class"><i class="fa fa-edit"></i></button>&nbsp';
                        $button .='<button data-href="'.route('delete',['banks',$row->id]).'" class="btn btn-xs btn-danger btn-modal"><i class="fa fa-trash"></i></button>';
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
                                $w->Where('banks.name', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['status','action','profile_photo'])
                    ->make(true);
        }
        return view('admin.banks.index');
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
            return view('admin.banks.create')->with(compact('groups'));
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
            'name'     => 'required',
            'common_ifsc'     => 'required|min:11|max:11',
            'group_id'     => 'required',
            'account_number_length'     => 'required',
            'status'     => 'required',
        ];
        $messages = [
            'name.required'    => 'Name Required',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }
        try {
            $input = $request->only(['name','group_id','common_ifsc','account_number_length','status']);
            $input['business_id']=Auth::user()->business_id;
            $input['created_by']=Auth::id();
            $input['updated_by']=Auth::id();
            Banks::create($input);
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
            $banks = Banks::find($id);
            return view('admin.banks.edit')->with(compact('banks','groups'));
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
                $banks = Banks::findOrFail($id);
                $banks->name = $request->name;
                $banks->group_id = $request->group_id;
                $banks->common_ifsc = $request->common_ifsc;
                $banks->account_number_length = $request->account_number_length;
                $banks->status = $request->status;
                $banks->updated_by = Auth::id();
                $banks->save();
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
                $user = Banks::findOrFail($id);
                $user->delete();
                return response()->json(['success' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'msg' => $e->getMessage()]);
            }
        }
    }
}
