@include('admin.layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>SLIDERS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('admin')}}">HOME</a></li>
                <li class="breadcrumb-item"><a href="{{route('sliders.index')}}">SLIDERS</a></li>
                <li class="breadcrumb-item active">UPDATE</li>
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
                <form method="post" action="{{route('sliders.update',$slider->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <img src="{{$slider->image}}" alt="" style="width: 150px">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                <label for="name">SLIDER IMAGE</label>
                                <input type="file" class="form-control" placeholder="IMAGE" name="image" value="{{old('image')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="name" class="">STATUS</label>
                                <select class="form-control" name="status" required>
                                    <option value="1" @if (old('status',$slider->status) == '1') selected @endif>ACTIVE</option>
                                    <option value="2" @if (old('status',$slider->status) == '2') selected @endif>INACTIVE</option>
                                </select> 
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="name">SMALL TITLE</label>
                                    <input type="text" class="form-control" style="color: {{$slider->small_title_color}}" value="{{old('small_title',$slider->small_title)}}" id="small_title" placeholder="Small Title" name="small_title" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="cp-default">
                                    <label for="name">COLOR</label>
                                    <input class="color form-control" style="background-color: {{$slider->small_title_color}}" value="{{old('small_title_color',$slider->small_title_color)}}" name="small_title_color" id="small_title_color" readonly onchange="getColor(this.value,'#small_title')">
                                  </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="name">BIG TITLE</label>
                                    <input type="text" class="form-control" style="color: {{$slider->big_title_color}}" placeholder="Big Title" value="{{old('big_title',$slider->big_title)}}" name="big_title" id="big_title" autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="cp-default">
                                    <label for="name">COLOR</label>
                                    <input class="color form-control" style="background-color: {{$slider->big_title_color}}" value="{{old('big_title_color',$slider->big_title_color)}}" name="big_title_color" id="big_title_color" onchange="getColor(this.value,'#big_title')" readonly/>
                                  </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="name">DESCRIPTION</label>
                                    <textarea type="text" class="form-control" style="color: {{$slider->description_color}}" placeholder="Enter Description" id="description" name="description">{{old('description',$slider->description)}}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="cp-default">
                                    <label for="name">COLOR</label>
                                    <input class="color form-control" style="background-color: {{$slider->description_color}}" value="{{old('description_color',$slider->description_color)}}" name="description_color" id="description_color" onchange="getColor(this.value,'#description')" readonly/>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"> SAVE SLIDER</button>
                    </div>
                </form>
                
                
                </div>
            </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">

    
</script>
@include('admin.layouts.footer')
<script>
$(function() {
  $('.cp-default').colorpicker();
});
function getColor(hex,id){
    $(id).css("color", hex);
    $(id+'_color').css("background-color", hex);
}
$("#slidersNav").addClass('active');
</script>