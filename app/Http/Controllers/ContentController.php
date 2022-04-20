<?php

namespace App\Http\Controllers;

use App\Models\Contents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function index(){
        $data['collection'] = Contents::get();
        return view('admin.contents.list',$data);
    }

    public function edit(Request $request){
        if (empty($_POST)) {
            $data['content'] = Contents::where('id',$request->segment(4))->first();
            return view('admin.contents.edit',$data);
        }else{
            try {
                $validator = Validator::make($request->all(), [
                    'heading' => 'required',
                ], [
                    'heading.required' => 'Name is required!',
                    
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $data = [
                    'heading'=>$request->heading,
                    'content1'=>$request->content1,
                    'content2'=>$request->content2,
                ];
                Contents::where('id',$request->segment(4))->update($data);
                if ($request->hasFile('image')) {
                    $validator = Validator::make($request->all(), [
                        'image' => 'mimes:jpg,jpeg,png,gif',
                    ],$messages = [
                        'mimes' => 'Please insert image only'
                    ]);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    $path = public_path('/uploads/contents');
                    if (!file_exists($path)) {
                        File::makeDirectory($path, $mode = 0777, true, true);
                    }
                    $imageName =  uniqid() . '.' . $request->image->extension();
                    $request->image->move(public_path('/uploads/contents'), $imageName);
                    $data['image'] = '/uploads/contents/' . $imageName;
                    Contents::where('id',$request->segment(4))->update($data);
                    
                }
                return redirect()->back()->with(array('message' => 'Content Updated!', 'status' => 'success'));
            } catch (\Throwable $th) {
                return response(['status'=>false,'message'=>'Something went wrong']);
            }
            

        }

    }
}
