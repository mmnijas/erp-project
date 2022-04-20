<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = News::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $button = '<a href="'.route('news.edit',$row->id).'" class="btn btn-xs btn-success" ><i class="fa fa-edit"></i> MANAGE</a>';
                        $button .= ' <a href="'.route('news.show',$row->id).'" class="btn btn-xs btn-success" ><i class="fa fa-eye"></i> VIEW</a>';
                        $button .= ' <button class="btn btn-xs btn-danger delete_button" onclick="remove(' . $row->id . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> DELETE</button>';
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
                    ->addColumn('image',function($row){
                        return '<img src="'.asset($row->image).'" style="width:50px"></img>';
                    })
                    ->addColumn('date',function($row){
                        return date('F d, Y', strtotime($row->date));
                    })
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->Where('heading', 'LIKE', "%$search%");
                            });
                        }

                    })
                    ->rawColumns(['status','action','image'])
                    ->make(true);
        }
        return view('admin.news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.create');
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
            'heading' => 'required',
            'date'=>'required',
            'description'=>'required',
            'status'=>'required',
            'image' => 'mimes:jpg,jpeg,png,gif',
        ], [
            'heading.required' => 'Name is required!',
            'date.required' => 'Date is required!',
            'image.mimes' => 'Please insert image only'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $validator->errors()->first()])->withInput();
        }
        try{
            if ($request->hasFile('image')) {
                $path = public_path('/news');
                if (!file_exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                $imageName =  uniqid().'.'.$request->image->extension();
                $request->image->move(public_path('/news'),$imageName);
                $image = '/news/'.$imageName;
            }
            $news = new News();
            $news->heading = $request->heading;
            $news->date = $request->date;
            $news->status = $request->status;
            $news->description = $request->description;
            $news->image = $image;
            $news->save();
            return redirect('admin/news')->with(array('message' => 'News Added!', 'status' => 'success'));
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
        $data['news']=News::where('id',$id)->first();
        return view('admin.news.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['news']=News::where('id',$id)->first();
        return view('admin.news.edit',$data);
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
            'heading' => 'required',
            'date'=>'required',
            'status' => 'required',
            'description'=>'required',
        ], [
            'heading.required' => 'Name is required!',
            'date.required' => 'Date is required!',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $validator->errors()->first()])->withInput();
        }
        try{
            $data = [
                'heading'=>$request->heading,
                'date'=>$request->date,
                'status'=>$request->status,
                'description'=>$request->description
            ];
            News::where('id',$id)->update($data);
            if ($request->hasFile('image')) {
                $news = News::findOrFail($id);
                $path = public_path(). $news->image;
                if(file_exists($path)){
                    unlink($path);
                }
                $path = public_path('/news');
                $imageName =  uniqid().'.'.$request->image->extension();
                $request->image->move(public_path('/news'),$imageName);
                $data = ['image'=> '/news/'.$imageName];
                News::where('id',$id)->update($data);
            }
            return redirect()->back()->with(array('message' => 'News Updated!', 'status' => 'success'));
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
                $news = News::findOrFail($id);
                $path = public_path(). $news->image;
                $news->delete();
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
