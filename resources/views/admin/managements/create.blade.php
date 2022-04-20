@include('admin.layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>MANAGEMENTS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('admin')}}">HOME</a></li>
                <li class="breadcrumb-item"><a href="{{route('managements.index')}}">MANAGEMENTS</a></li>
                <li class="breadcrumb-item active">CREATE</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @if (Session::has('message'))
            <div class="alert alert-{{ Session::get('status') }}" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
            <div class="col-12">
                    <!-- general form elements -->
                <div class="card card-primary">
                <form method="post" action="{{route('managements.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">NAME</label>
                                    <input type="text" class="form-control" placeholder="Name" value="{{old('name')}}" name="name" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">DESIGNATION</label>
                                    <input class="form-control" placeholder="Designation" value="{{old('designation')}}" name="designation" autocomplete="off" required>
                                  </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">DESCRIPTION</label>
                                    <textarea type="text" class="form-control" placeholder="Enter Description" id="description" name="description" required>{{old('description')}}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Facebook" name="facebook" value="{{old('facebook')}}">
                                </div>
                            </div>
                            <div class="col-md-12">
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                  </div>
                                  <input type="text" class="form-control" placeholder="Linkedin" name="linkedin" value="{{old('linkedin')}}">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                  </div>
                                  <input type="text" class="form-control" placeholder="Twitter" name="twitter" value="{{old('twitter')}}">
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="name">PROFILE IMAGE</label>
                                <input type="file" class="form-control" placeholder="IMAGE" name="image" value="{{old('image')}}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="">STATUS</label>
                                <select class="form-control" name="status" required>
                                    <option value="1">ACTIVE</option>
                                    <option value="2">IN ACTIVE</option>
                                </select>  
                            </div>
                            
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"> CREATE MEMBER</button>
                    </div>
                </form>
                
                
                </div>
            </div>
            </div>
        </div>
    </section>
</div>
@include('admin.layouts.footer')
<script>
  $("#managementNav").addClass('active');
</script>