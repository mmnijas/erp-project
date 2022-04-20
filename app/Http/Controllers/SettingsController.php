<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{   
    public function index(){
        return view('admin.settings',$this->data);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone'=>'required',
            'address'=>'required',
            'support_mail'=>'required|email',
            'admin_mail'=>'required|email',
            'career_mail'=>'required|email',
            'facebook'=>'required',
            'instagram'=>'required',
            'youtube'=>'required',
            'linkedin'=>'required',
            'twitter'=>'required',
        ], [
            'name.required' => 'Name is required!',
            'phone.required' => 'Quick Contact is required!',
            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $data = [
                'name'=>$request->name,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'support_mail'=>$request->support_mail,
                'admin_mail'=>$request->admin_mail,
                'career_mail'=>$request->career_mail,
                'facebook'=>$request->facebook,
                'instagram'=>$request->instagram,
                'youtube'=>$request->youtube,
                'linkedin'=>$request->linkedin,
                'twitter'=>$request->twitter,
                'map'=>$request->map
                
            ];
            Settings::where('id',1)->update($data);
            
            if ($request->hasFile('logo')) {
                $validator = Validator::make($request->all(), [
                    'image' => 'mimes:jpg,jpeg,png,gif',
                ],$messages = [
                    'mimes' => 'Please insert image only'
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } 
                $path = public_path('/uploads/logo');
                if (!file_exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                $imageName =  uniqid() . '.' . $request->logo->extension();
                $request->logo->move(public_path('/uploads/logo'), $imageName);
                $data['logo'] = '/uploads/logo/' . $imageName;
                Settings::where('id',1)->update($data);
            }
            return redirect()->back()->with(array('message' => 'Settings Updated!', 'status' => 'success'));
        } catch (\Throwable $th) {
            return response(['status'=>false,'message'=>'Something went wrong']);
        }
    }
    public function change_password(Request $request){
        if(empty($_POST)){
            return view('admin.change_password');
        }else{
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:4',
                'password_confirmation'=>'required|same:password'
            ], [
                'password.required' => 'Password is required!',
                'password_confirmation.same'=>'Password Not Match'
                
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            //Change Password
            $user = Auth::user();
            $user->password = $request->get('password');
            $user->save();
            return redirect()->back()->with(['status'=>'success','message'=>'Password successfully changed!']);
        }
    }
}
