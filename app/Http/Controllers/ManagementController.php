<?php

namespace App\Http\Controllers;

use App\Models\Managements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['management'] = Managements::orderBy('order','asc')->get();
        return view('admin.managements.index',$data);
    }
    public function order(Request $request)
    {
        $managements = Managements::get();
        foreach ($managements as $management) {
            foreach ($request->order as $order) {
                if ($order['id'] == $management->id) {
                    $management->update(['order' => $order['position']]);
                }
            }
        }
        return response(['status'=>true,'msg'=>'Order Updated Successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.managements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'designation'=>'required',
            'description'=>'required',
            'status'=>'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif',
        ], [
            'name.required' => 'Name is required!',
            'designation.required' => 'Designation is required!',
            'image.mimes' => 'Please insert image only'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $validator->errors()->first()])->withInput();
        }
        try{
            if ($request->hasFile('image')) {
                $path = public_path('/managements');
                if (!file_exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                $imageName =  uniqid().'.'.$request->image->extension();
                $request->image->move(public_path('/managements'),$imageName);
                $image = '/managements/'.$imageName;
            }
            $managements = new Managements();
            $managements->name = $request->name;
            $managements->designation = $request->designation;
            $managements->description = $request->description;
            $managements->facebook = $request->facebook;
            $managements->twitter = $request->twitter;
            $managements->linkedin = $request->linkedin;
            $managements->status = $request->status;
            $managements->image = $image;
            $managements->order = 1000;
            $managements->save();
            return redirect('admin/managements')->with(array('message' => 'Member Added!', 'status' => 'success'));
        } catch (\Throwable $th) {
            return response(['status'=>'danger','message'=>'Something went wrong']);
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
        $data['management']=Managements::where('id',$id)->first();
        return view('admin.managements.edit',$data);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'designation'=>'required',
            'description' => 'required',
            'status'=>'required',
            'image' => 'mimes:jpg,jpeg,png,gif',
        ], [
            'name.required' => 'Name is required!',
            'designation.required' => 'Designation is required!',
            'image.mimes' => 'Please insert image only'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $validator->errors()->first()])->withInput();
        }
        try{
            $data = [
                'name'=>$request->name,
                'designation'=>$request->designation,
                'description'=>$request->description,
                'facebook'=>$request->facebook,
                'twitter'=>$request->twitter,
                'linkedin'=>$request->linkedin,
                'status'=>$request->status
            ];
            Managements::where('id',$id)->update($data);
            if ($request->hasFile('image')) {
                $sliders = Managements::findOrFail($id);
                $path = public_path(). $sliders->image;
                if(file_exists($path)){
                    unlink($path);
                }
                $path = public_path('/managements');
                $imageName =  uniqid().'.'.$request->image->extension();
                $request->image->move(public_path('/managements'),$imageName);
                $data = ['image'=> '/managements/'.$imageName];
                Managements::where('id',$id)->update($data);
            }
            return redirect()->back()->with(array('message' => 'Member Updated!', 'status' => 'success'));
        } catch (\Throwable $th) {
            return response(['status'=>'warning','message'=>'Something went wrong']);
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
                $managements = Managements::findOrFail($id);
                $path = public_path(). $managements->image;
                $managements->delete();
                if(file_exists($path)){
                    unlink($path);
                }
                return (['status' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return (['status' => false,'msg' => 'something went wrong']);
            }
        }
    }
}
