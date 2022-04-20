<?php

namespace App\Http\Controllers;

use App\Models\Qualifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class QualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Qualifications::select('id','name','status')->orderBy('id','desc'); 
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn(
                        'action',
                        '<button data-href="{{action(\'App\Http\Controllers\QualificationController@edit\', [$id])}}" class="btn btn-xs btn-primary edit_button"><i class="fa fa-edit"></i> EDIT</button>
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
        return view('admin.qualifications.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.qualifications.create');
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
            Qualifications::create($input);
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
            $qualification = Qualifications::find($id);
            return view('admin.qualifications.edit')->with(compact('qualification'));
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
                $qualification = Qualifications::findOrFail($id);
                if ($qualification->name != $input['name']) {
                    $qualification->name = $input['name'];
                    $qualification->save();
                }
                if ($qualification->status != $input['status']) {
                    $qualification->status = $input['status'];
                    $qualification->save();
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
                $qualification = Qualifications::findOrFail($id);
                $qualification->delete();
                return ['success' => true,'msg' =>'successfully deleted'];
            } catch (\Exception $e) {
                return ['success' => false,'msg' => 'something went wrong'];
            }
        }
    }
}
