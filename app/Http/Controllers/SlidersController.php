<?php

namespace App\Http\Controllers;

use App\Models\Sliders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SlidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['sliders'] = Sliders::orderBy('order','asc')->get();
        return view('admin.sliders.index',$data);
    }
    public function order(Request $request)
    {
        $sliders = Sliders::get();
        foreach ($sliders as $slider) {
            foreach ($request->order as $order) {
                if ($order['id'] == $slider->id) {
                    $slider->update(['order' => $order['position']]);
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
        return view('admin.sliders.create');
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
            'small_title' => 'required',
            'small_title_color'=>'required',
            'big_title' => 'required',
            'big_title_color'=>'required',
            'description'=>'required',
            'description_color'=>'required',
            'status'=>'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif',
        ], [
            'small_title.required' => 'Small Title is required!',
            'small_title_color.required' => 'Small Title Color is required!',
            'image.mimes' => 'Please insert image only'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $validator->errors()->first()])->withInput();
        }
        try{
            if ($request->hasFile('image')) {
                $path = public_path('/sliders');
                if (!file_exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                $imageName =  uniqid().'.'.$request->image->extension();
                $request->image->move(public_path('/sliders'),$imageName);
                $image = '/sliders/'.$imageName;
            }
            $sliders = new Sliders();
            $sliders->small_title = $request->small_title;
            $sliders->small_title_color = $request->small_title_color;
            $sliders->big_title = $request->big_title;
            $sliders->big_title_color = $request->big_title_color;
            $sliders->description = $request->description;
            $sliders->description_color = $request->description_color;
            $sliders->status = $request->status;
            $sliders->image = $image;
            $sliders->order = 1000;
            $sliders->save();
            return redirect('admin/sliders')->with(array('message' => 'Sliders Added!', 'status' => 'success'));
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
        $data['slider']=Sliders::where('id',$id)->first();
        return view('admin.sliders.edit',$data);
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
            'small_title' => 'required',
            'small_title_color'=>'required',
            'big_title' => 'required',
            'big_title_color'=>'required',
            'description'=>'required',
            'description_color'=>'required',
            'status'=>'required',
            'image' => 'mimes:jpg,jpeg,png,gif',
        ], [
            'small_title.required' => 'Small Title is required!',
            'small_title_color.required' => 'Small Title Color is required!',
            'image.mimes' => 'Please insert image only'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $validator->errors()->first()])->withInput();
        }
        try{
            $data = [
                'small_title'=>$request->small_title,
                'small_title_color'=>$request->small_title_color,
                'big_title'=>$request->big_title,
                'big_title_color'=>$request->big_title_color,
                'description'=>$request->description,
                'description_color'=>$request->description_color,
                'small_title'=>$request->small_title,
                'status'=>$request->status
            ];
            Sliders::where('id',$id)->update($data);
            if ($request->hasFile('image')) {
                $sliders = Sliders::findOrFail($id);
                $path = public_path(). $sliders->image;
                if(file_exists($path)){
                    unlink($path);
                }
                $path = public_path('/sliders');
                $imageName =  uniqid().'.'.$request->image->extension();
                $request->image->move(public_path('/sliders'),$imageName);
                $data = ['image'=> '/sliders/'.$imageName];
                Sliders::where('id',$id)->update($data);
            }
            return redirect()->back()->with(array('message' => 'Slider Updated!', 'status' => 'success'));
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
                $sliders = Sliders::findOrFail($id);
                $path = public_path(). $sliders->image;
                $sliders->delete();
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
