<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BankingAccountGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BankingAccountGroupsController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = BankingAccountGroups::select('banking_account_groups.id','banking_account_groups.name','banking_account_groups.status','banking_account_groups.code','profile_photo')
                                        ->leftjoin('users','users.id','=','banking_account_groups.updated_by')
                                        ->where('banking_account_groups.business_id',Auth::user()->business_id); 
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $button = '<button type="button" data-href="'.route('banking-account-groups.edit',$row->id).'" class="btn btn-xs btn-primary edit_button" data-container=".modal_class"><i class="fa fa-edit"></i></button>&nbsp';
                        $button .='<button data-href="'.route('delete',['banking-account-groups',$row->id]).'" class="btn btn-xs btn-danger btn-modal"><i class="fa fa-trash"></i></button>';
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
                                $w->Where('banking_account_groups.name', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['action','status','profile_photo'])
                    ->make(true);
        }
        return view('admin.banking_account_groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {
            $parent_groups = BankingAccountGroups::select('id','name')->where('status',1)->where('business_id',Auth::user()->business_id)->get();
            return view('admin.banking_account_groups.create')->with(compact('parent_groups'));
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
            'parent_id'  => 'required',
            'name'                      => 'required|unique:banking_account_groups',
            'code'                      => 'required|unique:banking_account_groups',
            'status'                    => 'required',
        ];
        $messages = [
            'parent_id.required'    => 'Group Required',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }
        try {
            $input = $request->only(['parent_id','name','code','status']);
            $input['business_id']=Auth::user()->business_id;
            $input['created_by']=Auth::id();
            $input['updated_by']=Auth::id();
            BankingAccountGroups::create($input);
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
            $parent_groups = BankingAccountGroups::select('id','name')->where('status',1)->where('business_id',Auth::user()->business_id)->get();
            $group = BankingAccountGroups::find($id);
            return view('admin.banking_account_groups.edit')->with(compact('group','parent_groups'));
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
                $ledgers = BankingAccountGroups::findOrFail($id);
                $ledgers->parent_id = $request->parent_id;
                $ledgers->name = $request->name;
                $ledgers->code = $request->code;
                $ledgers->status = $request->status;
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
                $user = BankingAccountGroups::findOrFail($id);
                $user->delete();
                return response()->json(['success' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'msg' => $e->getMessage()]);
            }
        }
    }
}
