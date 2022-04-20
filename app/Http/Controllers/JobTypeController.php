<?php

namespace App\Http\Controllers;

use App\Models\JobTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JobTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JobTypes::select('id','name','status')->orderBy('id','desc'); 
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn(
                        'action',
                        '<button data-href="{{action(\'App\Http\Controllers\JobTypeController@edit\', [$id])}}" class="btn btn-xs btn-primary edit_button"><i class="fa fa-edit"></i> EDIT</button>
                        &nbsp;
                        <button class="btn btn-xs btn-danger delete-button" onclick="remove({{$id}})" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> DELETE</button>'
                    )
                    ->addColumn('status',function($row){
                        if($row->status==1){
                            return 'ACTIVE';
                        }else{
                            return 'INACTIVE';
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
                    ->make(true);
        }
        return view('admin.job_types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.job_types.create');
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
            $input = $request->only(['name', 'status']);
            JobTypes::create($input);
            return ['success' => true,'msg' => "succussfully added"];
        } catch (\Exception $e) {
            return ['success' => false,'msg' => "Something Went Wrong"];
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
            $job_types = JobTypes::find($id);
            return view('admin.job_types.edit')->with(compact('job_types'));
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
                $input = $request->only(['name','status']);
                $job_types = JobTypes::findOrFail($id);
                if ($job_types->name != $input['name']) {
                    $job_types->name = $input['name'];
                    $job_types->save();
                }
                if ($job_types->status != $input['status']) {
                    $job_types->status = $input['status'];
                    $job_types->save();
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
        // if(Careers::where('base_unit_id',$id)->exists()){
        //     $output = ['success' => false,'msg' => 'Child types Exist'];
        //     return $output;
        // }
        if (request()->ajax()) {
            try {
                $job_types = JobTypes::findOrFail($id);
                $job_types->delete();
                return ['success' => true,'msg' =>'successfully deleted'];
            } catch (\Exception $e) {
                return ['success' => false,'msg' => 'something went wrong'];
            }
        }
    }
}
