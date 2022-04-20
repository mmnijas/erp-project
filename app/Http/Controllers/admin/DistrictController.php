<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Districts;
use App\Models\States;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = Districts::select('districts.id','districts.name','state_id','districts.status','states.name as state')
                                ->leftjoin('states','states.id','=','districts.state_id')
                                ->where('districts.business_id',Auth::user()->business_id); 
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $button = '<button type="button" data-href="'.route('districts.edit',$row->id).'" class="btn btn-xs btn-primary  edit_button" data-container=".modal_class"><i class="fa fa-edit"></i></button>&nbsp';
                        $button .='<button data-href="'.route('delete',['districts',$row->id]).'" class="btn btn-xs btn-danger btn-modal"><i class="fa fa-trash"></i></button>';
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
                                $w->Where('districts.name', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['status','action'])
                    ->make(true);
        }
        return view('admin.districts.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['states']=States::where('status',1)->where('business_id',Auth::user()->business_id)->get();
        return view('admin.districts.create',$data);
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
            'state_id'     => 'required',
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
            $input = $request->only(['name','state_id','status']);
            $input['business_id']=Auth::user()->business_id;
            Districts::create($input);
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
            $states=States::select('id','name')->where('status',1)->where('business_id',Auth::user()->business_id)->get();
            $districts = Districts::find($id);
            return view('admin.districts.edit')->with(compact('districts','states'));
            
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
                $input = $request->only(['state_id','name','status']);
                $districts = Districts::findOrFail($id);
                $districts->state_id = $request->state_id;
                $districts->name = $request->name;
                $districts->status = $request->status;
                $districts->save();
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
            try {
                $user = Districts::findOrFail($id);
                $user->delete();
                return response()->json(['success' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'msg' => $e->getMessage()]);
            }
        }
    }
}
