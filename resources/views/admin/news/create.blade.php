@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>NEWS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">HOME</a></li>
              <li class="breadcrumb-item"><a href="{{route('news.index')}}">NEWS</a></li>
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
                <form method="post" action="{{route('news.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                <label for="name">DATE</label>
                                <input type="date" class="form-control" placeholder="DATE" name="date" required>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="name">HEADING</label>
                                    <input type="text" class="form-control" placeholder="Enter Heading" name="heading" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">DESCRIPTION</label>
                                    <textarea type="text" class="form-control" placeholder="Enter News Description" id="description" name="description"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="name">NEWS IMAGE</label>
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
                        <button type="submit" class="btn btn-success"> SAVE NEWS</button>
                    </div>
                </form>
                
                
                </div>
            </div>
            </div>
        </div>
    </section>
</div>
<script src="{{asset('js/tinymce.min.js')}}"></script>
<script>
tinymce.init({
    init_instance_callback : function(editor) {
        var freeTiny = document.querySelector('.tox .tox-notification--in');
        freeTiny.style.display = 'none';
    },
    selector: 'textarea#description', // Replace this CSS selector to match the placeholder element for TinyMCE
    plugins: 'code table lists',
    toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
 });
</script>
@include('admin.layouts.footer')
<script>
 $("#newsNav").addClass('active');
</script>