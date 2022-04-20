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
                <li class="breadcrumb-item active">VIEW</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                        <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{$news->date}}</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h1 for="name">{{$news->heading}}</h1>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <img for="name" src="{{asset($news->image)}}" style="height:200px">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name"><?=$news->description?></label>
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
<script>
    $("#newsNav").addClass('active');
</script>