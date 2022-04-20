<?php

namespace App\Http\Controllers;

use App\Models\EventImages;
use App\Models\Events;
use App\Models\HomeGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Image;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Events::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $button = '<a href="'.route('events.edit',$row->id).'" class="btn btn-xs btn-success" ><i class="fa fa-edit"></i> MANAGE GALLERY</a>';
                        $button .= ' <button class="btn btn-xs btn-danger delete_button" onclick="remove(' . $row->id . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> DELETE GALLERY</button>';
                        return $button;
                    })
                    ->addColumn('status',function($row){
                        if($row->status==1){
                            $status = 'ACTIVE';
                        }else{
                            $status = 'INACTIVE';
                        }
                        return $status;
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
        return view('admin.events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.events.create');
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
            'date'=>'required',
            'main_image' => 'mimes:jpg,jpeg,png,gif',
        ], [
            'name.required' => 'Name is required!',
            'date.required' => 'Date is required!',
            'mimes' => 'Please insert image only'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try{
            if ($request->hasFile('main_image')) {
                $image = $request->file('main_image');
                $image_name = uniqid() . '.' . $image->extension();
                $thumbnailFilePath = public_path('/uploads/main_image/thumbnail');
                $img = Image::make($image->path());
                $img->resize(200, 200, function ($const) {
                    $const->aspectRatio();
                })->save($thumbnailFilePath . '/' . $image_name);
                $ImageFilePath = public_path('/uploads/main_image');
                $image->move($ImageFilePath, $image_name);
                //file name
                $main_img = '/uploads/main_image/'.$image_name;
                $main_thumb = '/uploads/main_image/thumbnail/'.$image_name;
            }
            $events = new Events();
            $events->name = $request->name;
            $events->date = $request->date;
            $events->status = $request->status;
            $events->main_image = $main_img;
            $events->thumbnail = $main_thumb;
            $events->save();
            if ($request->hasfile('images')) {
                foreach ($request->file('images') as $image) {
                    $image_name = uniqid() . '.' . $image->extension();
                    $thumbnailFilePath = public_path('/multiple_images/thumbnail');
                    $img = Image::make($image->path());
                    $img->resize(200, 200, function ($const) {
                        $const->aspectRatio();
                    })->save($thumbnailFilePath . '/' . $image_name);
                    $ImageFilePath = public_path('/multiple_images/');
                    $image->move($ImageFilePath, $image_name);
                    //file name
                    $imgs = '/multiple_images/'.$image_name;
                    $thumb = '/multiple_images/thumbnail/'.$image_name;
                    EventImages::insert(['event_id' => $events->id, 'image' => $imgs,'thumbnail' => $thumb, 'created_at' => NOW(), 'updated_at' => NOW()]);
                }
            }
            return redirect('admin/events')->with(array('message' => 'Event Added!', 'status' => 'success'));
        } catch (\Throwable $th) {
            return response(['status'=>'warning','message'=>'Something went wrong']);
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
        echo 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['event']=Events::where('id',$id)->first();
        $data['images']=EventImages::where('event_id',$id)->get();
        return view('admin.events.edit',$data);
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
            'date'=>'required',
        ], [
            'name.required' => 'Name is required!',
            'date.required' => 'Date is required!',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try{
        $data = [
            'name'=>$request->name,
            'date'=>$request->date,
            'status'=>$request->status
        ];
        Events::where('id',$id)->update($data);
        if ($request->hasFile('main_image')) {
            
            $validator = Validator::make($request->all(), [
                'main_image' => 'mimes:jpg,jpeg,png,gif',
            ],$messages = [
                'mimes' => 'Please insert image only'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
             
            $path = public_path('/uploads/main_image');
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            $imageName =  uniqid() . '.' . $request->main_image->extension();
            $request->main_image->move(public_path('/uploads/main_image'), $imageName);
            $data = ['main_image'=> '/uploads/main_image/'.$imageName];
            Events::where('id',$id)->update($data);
        }
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {

                $image_name = uniqid() . '.' . $image->extension();
                $thumbnailFilePath = public_path('/multiple_images/thumbnail');
                $img = Image::make($image->path());
                $img->resize(200, 200, function ($const) {
                    $const->aspectRatio();
                })->save($thumbnailFilePath . '/' . $image_name);
                $ImageFilePath = public_path('/multiple_images/');
                $image->move($ImageFilePath, $image_name);
                //file name
                $img = '/multiple_images/'.$image_name;
                $thumb = '/multiple_images/thumbnail/'.$image_name;
                EventImages::insert(['event_id' => $id, 'image' => $img,'thumbnail'=>$thumb, 'created_at' => NOW(), 'updated_at' => NOW()]);
            }
        }
        return redirect()->back()->with(array('message' => 'Event Updated!', 'status' => 'success'));
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
                $event = Events::findOrFail($id);
                $path1 = public_path() . '/' . $event->main_image;
                $path2 = public_path() . '/' . $event->thumbnail;
                $event->delete();
                if(file_exists($path1)){
                    unlink($path1);
                }
                if(file_exists($path2)){
                    unlink($path2);
                }
                $event_images = EventImages::where('event_id',$id)->get();
                foreach ($event_images as $key => $value) {
                    $path1 = public_path() . '/' . $value->image;
                    $path2 = public_path() . '/' . $value->thumbnail;
                    if(file_exists($path1)){
                        unlink($path1);
                    }
                    if(file_exists($path2)){
                        unlink($path2);
                    }
                }
                EventImages::where('event_id',$id)->delete();
                return (['status' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return (['status' => false,'msg' => 'something went wrong']);
            }
        }
    }
    public function delete_image(Request $request)
    {   
        $id = $request->post('id');
        $project = EventImages::where('id', $id)->first();
        $path = public_path() . '/' . $project->image;
        EventImages::where('id', $id)->delete();
        if(file_exists($path)){
            unlink($path);
        }
    }


    public function home_gallery(Request $request){
        if ($request->ajax()) {
            $data = HomeGallery::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function($row){
                        return ' <img src="'.asset($row->thumbnail).'" style="width:50px">';
                    })
                    ->addColumn('action', function($row){
                        return ' <button class="btn btn-xs btn-danger delete_button" onclick="remove(' . $row->id . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> DELETE</button>';
                    })
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
                                $w->Where('image', 'LIKE', "%$search%");
                            });
                        }

                    })
                    ->rawColumns(['image','status','action'])
                    ->make(true);
        }
        return view('admin.events.home_gallery');
    }
    public function create_gallery()
    {
        return view('admin.events.create_gallery');
    }
    public function store_gallery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'image' => 'mimes:jpg,jpeg,png,gif',
        ], [
            'status.required' => 'Status is required!',
            'mimes' => 'Please insert image only'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try{
            if ($request->hasFile('image')) {
             
                $image = $request->file('image');
                $image_name = uniqid() . '.' . $image->extension();
                $thumbnailFilePath = public_path('/thumbnail');
                $img = Image::make($image->path());
                $img->resize(200, 200, function ($const) {
                    $const->aspectRatio();
                })->save($thumbnailFilePath . '/' . $image_name);
                $ImageFilePath = public_path('/uploads/image/');
                $image->move($ImageFilePath, $image_name);
            }
            $img = '/uploads/image/'.$image_name;
            $thumb = '/thumbnail/'.$image_name;

            $input = new HomeGallery();
            $input->image = $img;
            $input->thumbnail = $thumb;
            $input->status = $request->status;
            $input->save();
            return redirect('admin/home-gallery')->with(array('message' => 'Image Added!', 'status' => 'success'));
        } catch (\Throwable $th) {
            return response(['status'=>'warning','message'=>'Something went wrong']);
        }
    }

    public function delete_gallery($id){
        if (request()->ajax()) {
            try {
                $project = HomeGallery::where('id', $id)->first();
                $path = public_path() . '/' . $project->image;
                HomeGallery::where('id', $id)->delete();
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
