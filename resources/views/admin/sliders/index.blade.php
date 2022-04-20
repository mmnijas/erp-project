@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="btn btn-info pull-right" href="{{route('sliders.create')}}"><i class="fa fa-plus"></i> CREATE NEW IMAGE SLIDER</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">HOME</a></li>
              <li class="breadcrumb-item active">SLIDERS</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            
                <!-- general form elements -->
            <div class="card card-primary">
              <div class="row">
                <div class="col-md-12">
                    <table class="data-table table mg-b-0" id="datatable">
                        <thead>
                          <tr>
                            <th>ORDER</th>
                            <th>IMAGE</th>
                            <th>SMALL TITLE</th>
                            <th>BIG TITLE</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                          </tr>
                        </thead>
                        <tbody id="tablecontents">
                          @foreach ($sliders as $item)
                          <tr class="row1" data-id="{{ $item->id }}">
                            <th class="text-center"><span><i class="fa fa-arrows-alt"></i></span></th>
                              <th>
                                <div class="popup-gallery">
                                    <a href="{{ asset($item->image) }}">
                                    <img src="{{$item->image}}" alt="" style="width: 75px">
                                </div>
                                
                              </th>
                              <th>{{ $item->small_title}}</th>
                              <th>{{ $item->big_title}}</th>
                              <th>
                                @if ($item->status==1)
                                    <span class="label label-success">ACTIVE</span>
                                @else
                                    <span class="label label-warning">IN-ACTIVE</span>
                                @endif
                              </th>
                              <th>
                                <a href="{{route('sliders.edit',$item->id)}}" class="btn btn-xs btn-success" ><i class="fa fa-edit"></i> MANAGE</a>
                                <button class="btn btn-xs btn-danger delete_button" onclick="remove({{$item->id}})" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> DELETE</button>
                              </th>
                          </tr>
                              
                          @endforeach
                        </tbody>
                      </table>
                  
                </div>
                
              </div>
              
              
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

{{-- delete modal start here--}}
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">REMOVE</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              
          </div>

          <form role="form" action="{{url('admin/sliders')}}" method="post" id="removeForm">
              <div class="modal-body">
                  <p>Slider will be deleted! Are you sure?</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-warning" data-dismiss="modal">CLOSE</button>
                  <button type="submit" class="btn btn-danger delete_button">DELETE</button>
              </div>
          </form>


      </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{-- delete modal end here --}}
@include('admin.layouts.footer')
<script >
      function remove(id){
           $('.delete_button').removeAttr('disabled');
           $(document).unbind('submit').on('submit', 'form#removeForm', function(e){
               e.preventDefault();
               $(this).find('button[type="submit"]').attr('disabled', true);
               $.ajax({
                   method: "delete",
                   url: $(this).attr("action")+'/'+id,
                   dataType: "json",
                   data: {
                       "_token": "{{ csrf_token() }}",
                       "id":id,
                   },
                   success:function(result){
                       if(result.status == true){
                           $('#removeModal').modal('hide');
                           toastr.success(result.msg);
                           location.reload();
                       }else{
                           $('#removeModal').modal('hide');
                           toastr.error(result.msg);
                           location.reload();
                       }
                   }
               });
           });
       }
   </script>

<script type="text/javascript">
$(function () {
  $('.data-table').DataTable({
    "ordering": false
  });
  $( "#tablecontents" ).sortable({
    items: "tr",
    cursor: 'move',
    opacity: 0.6,
    update: function() {
        sendOrderToServer();
    }
  });

  function sendOrderToServer() {
    var order = [];
    var token = '{{ csrf_token() }}';
    $('tr.row1').each(function(index,element) {
      order.push({
        id: $(this).attr('data-id'),
        position: index+1
      });
    });

    $.ajax({
      type: "POST", 
      dataType: "json", 
      url: "{{ url('admin/sliders-sortable') }}",
          data: {
        order: order,
        _token: token
      },
      success: function(response) {
          if (response.status == true) {
            toastr.success(response.msg);
          } else {
            toastr.success(response.msg);
          }
      }
    });
  }
});
$("#slidersNav").addClass('active');
</script>