<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        Artisan::call('up');
        if ($request->ajax()) {
            $data = User::select('id','profile_photo','name','email','phone','status')->where('business_id',Auth::user()->business_id); 
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $button = '<a href="'.url('admin/users').'/'.$row->id.'/edit" class="btn btn-xs btn-outline-primary"><i class="fa fa-edit"></i></a>&nbsp';
                        if(Auth::id()!=$row->id){
                            $button .='<button data-href="'.route('delete',['users',$row->id]).'" class="btn btn-xs btn-outline-danger btn-modal"><i class="fa fa-trash"></i></button>';
                        }
                        return $button;
                    })
                    ->addColumn('status',function($row){
                        if($row->status==1){
                            return '<span class="badge badge-success">ACTIVE</span>';
                        }else{
                            return '<span class="badge badge-danger">IN ACTIVE</span>';
                        }
                    })
                    ->addColumn('role',function ($row) {
                        return $this->getUserRoleName($row->id);
                    })
                    ->addColumn('profile_photo',function ($row) {
                        if($row->profile_photo){
                            return '<img src="'.asset($row->profile_photo).'" style="height:50px" alt="'.$row->name.'">';
                        }else{
                            return '<img src="'.asset('img/user2.png').'" style="height:50px" alt="'.$row->name.'">';
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
                    ->rawColumns(['status','action','profile_photo'])
                    ->make(true);
        }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles  = Role::select('name', 'id')->where('guard_name','web')->get();
        return view('admin.users.create')->with(compact('roles'));
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
            'name'                              => 'required|string|min:3|max:30',
            'email'                             => 'required|email|min:3|max:50|unique:users',
            'phone'                             => 'required|min:10|max:10|unique:users',
            'role'                              => 'required',
            'dob'                               => 'required',
            'gender'                            => 'required',
            'address'                           => 'required|string|min:3',
            'status'                            => 'required',
            'password'                          => 'required|confirmed|min:6',
            'password_confirmation'             => 'required',
            'profile_photo'                     => 'required|mimes:jpg,jpeg,png,gif'
        ];
        $messages = [
            'name.required'    => 'Name is required',
        ];
        $validation = Validator::make($request->all(), $rules, $messages);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        if ($request->hasFile('profile_photo')) {
            $path = public_path('/uploads/profile_photo');
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            $imageName =  uniqid() . '.' . $request->profile_photo->extension();
            $request->profile_photo->move(public_path('/uploads/profile_photo'), $imageName);
            $profile_photo =  '/uploads/profile_photo/'.$imageName;
        }
        try {
            $user = new User();
            $user->business_id = Auth::user()->business_id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->dob = $request->dob;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->status = $request->status;
            $user->password = Hash::make($request->password);
            $user->profile_photo = $profile_photo;
            $user->save();
            $role_id = $request->input('role');
            $role = Role::findOrFail($role_id);
            $user->assignRole($role->name);
            return redirect('admin/users')->with(['status' => 'success','message' => "USER ADDED SUCCESSFULLY"]);
        } catch (\Throwable $e) {
            $path = public_path().$profile_photo;
            if(file_exists($path)){
                unlink($path);
            }
            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
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
        $user = User::findOrFail($id);
        $roles  = Role::select('name', 'id')->where('guard_name','web')->get();
        $user_role = $user->roles->first();
        return view('admin.users.edit')->with(compact('roles', 'user','user_role'));
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
        $rules = [
            'name'                              => 'required|string|min:3|max:30',
            'email'                             => 'required|email|min:3|max:50|unique:users,email,'.$id,
            'phone'                             => 'required|min:10|max:10|unique:users,phone,'.$id,
            'role'                              => 'required',
            'dob'                               => 'required',
            'gender'                            => 'required',
            'address'                           => 'required|string|min:3',
            'status'                            => 'required',
        ];
        if($request->password){
            $rules = [
                'password'                      =>'required|confirmed|min:6',
                'password_confirmation'         => 'required',
            ];
        }
        $messages = [
            'name.required'    => 'Name is required',
        ];
        $validation = Validator::make($request->all(), $rules, $messages);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        try {
            $user_data = [
                'name'      =>$request->name,
                'email'     =>$request->email,
                'phone'     =>$request->phone,
                'dob'       =>$request->dob,
                'gender'    =>$request->gender,
                'address'   =>$request->address,
                'status'    =>$request->status,
            ];
            User::where('id',$id)->update($user_data);
            if ($request->hasFile('profile_photo')) {
                $validator = Validator::make($request->all(), [
                    'profile_photo' => 'mimes:jpg,jpeg,png,gif',
                ],$messages = [
                    'mimes' => 'Please insert image only'
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $user = User::findOrFail($id);
                $path = public_path().$user->profile_photo;
                if(file_exists($path)){
                    unlink($path);
                }
                $path = public_path('/uploads/profile_photo');
                if (!file_exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                $imageName =  uniqid() . '.' . $request->profile_photo->extension();
                $request->profile_photo->move(public_path('/uploads/profile_photo'), $imageName);
                $data = ['profile_photo'=> '/uploads/profile_photo/'.$imageName];
                User::where('id',$id)->update($data);
            }
            $user = User::where('id',$id)->first();
            $user_role = $user->roles->first();
            $previous_role = !empty($user_role->id) ? $user_role->id : 0;
            if ($previous_role != $request->role) {
                if (!empty($previous_role)) {
                    $user->removeRole($user_role->name);
                }
                $role = Role::findOrFail($request->role);
                $user->assignRole($role->name);
            }
            return redirect()->back()->with(['status' => 'success','message' => 'USER UPDATED SUCCESSFULLY!']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
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
        if(Auth::id()==$id){
            return response()->json(['success' => false,'msg' =>'Active User cannot be deleted']);
        }
        if (request()->ajax()) {
            try {
                $user = User::findOrFail($id);
                $user->delete();
                return response()->json(['success' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return response()->json(['success' => false,'msg' => $e->getMessage()]);
            }
        }
    }

    public function getUserRoleName($user_id)
    {
        $user = User::findOrFail($user_id);
        $roles = $user->getRoleNames();
        $role_name = '';
        if (!empty($roles[0])) {
            $role_name = !empty($roles[0]) ? $roles[0] : '';
        }
        return $role_name;
    }
}
