@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- @if (auth()->user()->can('roles')) --}}
                {{-- <a class="btn btn-primary" href="{{route('roles.create')}}"><i class="fa fa-plus"></i> ADD</a> --}}
            {{-- @endif --}}
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('admin')}}">HOME</a></li>
                <li class="breadcrumb-item"><a href="{{route('users.index')}}">USERS</a></li>
                <li class="breadcrumb-item active">EDIT</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @include('admin.layouts.session')
        @include('admin.layouts.error')
        <div class="row">
          <div class="col-12">
            <!-- general form elements -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">USERS</h3>
                </div>
                <div class="card-body">
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <form method="POST" action="{{url('admin/users').'/'.$user->id}}" accept-charset="UTF-8" id="user_edit_form" enctype="multipart/form-data">
                                    <input name="_method" type="hidden" value="PUT">
                                    @csrf 
                                    <div class="box-body">
                                    
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">NAME:*</label>
                                                    <input class="form-control" value="{{old('name',$user->name)}}" required placeholder="User Name" name="name" type="text" id="name" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">PHOTO:</label>
                                                    <input class="form-control" name="profile_photo" type="file" id="name" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    @if ($user->profile_photo)
                                                        <img style="height: 75px" src="{{asset($user->profile_photo)}}" alt="{{$user->name}}">
                                                    @else
                                                        <img style="height: 75px" src="{{asset('img/user2.png')}}" alt="{{$user->name}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">EMAIL:*</label>
                                                    <input class="form-control" value="{{old('email',$user->email)}}" required placeholder="User Email" name="email" type="text" id="email" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">PHONE:*</label>
                                                    <input class="form-control" value="{{old('phone',$user->phone)}}" required placeholder="User Phone" name="phone" type="text" id="phone" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">ADDRESS:*</label>
                                                    <input class="form-control" value="{{old('address',$user->address)}}" required placeholder="User Address" name="address" type="text" id="address" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">GENDER:*</label>
                                                    <select class="form-control" name="gender">
                                                        <option value="MALE" @if (old('gender', $user->gender) == 'MALE') selected @endif>MALE</option>
                                                        <option value="FEMALE" @if (old('gender', $user->gender) == 'FEMALE') selected @endif>FEMALE</option>
                                                        <option value="OTHER" @if (old('gender', $user->gender) == 'OTHER') selected @endif>OTHER</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">DATE OF BIRTH:*</label>
                                                    <input class="form-control" value="{{old('dob',$user->dob)}}" required placeholder="YYYY/MM/DD" name="dob" type="date" id="date" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">ROLE:*</label>
                                                    <select class="form-control select2" name="role" required>
                                                        <option value="">SELECT ROLE</option>
                                                        @if(isset($roles))
                                                            @foreach ($roles as $role)
                                                                <option value="{{$role->id}}" @if(old('role', isset($user_role->id)?$user_role->id:'') == $role->id)  selected @endif>{{$role->name}} </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">STATUS:*</label>
                                                    <select class="form-control" name="status">
                                                        <option value="1" @if (old('status', $user->status) == '1') selected @endif>ACTIVE</option>
                                                        <option value="2" @if (old('status', $user->status) == '2') selected @endif>INACTIVE</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right">SAVE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
@include('admin.layouts.footer')
<script >
    $("#userManagementNav").addClass('active');
    $("#usersNav").addClass('active');
</script>