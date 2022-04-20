<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Districts;
use App\Models\States;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StatesController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = States::select('id','name','state_code','status')->where('business_id',Auth::user()->business_id); 
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $button = '<button type="button" data-href="'.route('states.edit',$row->id).'" class="btn btn-xs btn-primary edit_button" data-container=".modal_class"><i class="fa fa-edit"></i></button>&nbsp';
                        $button .='<button data-href="'.route('delete',['states',$row->id]).'" class="btn btn-xs btn-danger btn-modal"><i class="fa fa-trash"></i></button>';
                        return $button;
                    })
                    ->addColumn('status',function($row){
                        if($row->status==1){
                            return '<span class="badge badge-success">ACTIVE</span>';
                        }else{
                            return '<span class="badge badge-danger">IN ACTIVE</span>';
                        }
                    })
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->Where('name', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['status','action'])
                    ->make(true);
        }
        return view('admin.states.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.states.create');
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
            'state_code'     => 'required',
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
            $input = $request->only(['name','state_code','status']);
            $input['business_id']=Auth::user()->business_id;
            States::create($input);
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
            $states = States::find($id);
            return view('admin.states.edit')->with(compact('states'));
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
                $input = $request->only(['name','state_code','status']);
                $states = States::findOrFail($id);
                if ($states->name != $input['name']) {
                    $states->name = $input['name'];
                    $states->save();
                }
                if ($states->state_code != $input['state_code']) {
                    $states->state_code = $input['state_code'];
                    $states->save();
                }
                if ($states->status != $input['status']) {
                    $states->status = $input['status'];
                    $states->save();
                }
                return ['success' => true,'msg' =>'successfully updated'];
            } catch (\Exception $e) {
                return ['success' => false, 'msg' => 'Something went wrong, please try again'];
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
            if(Districts::where('state_id',$id)->exists()){
                return response()->json(['success' => false,'msg' =>'State cannot be deleted as it is added in districts']);
            }
            try {
                $user = States::findOrFail($id);
                $user->delete();
                return response()->json(['success' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'msg' => $e->getMessage()]);
            }
        }
    }
}
