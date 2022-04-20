@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="btn btn-info pull-right" href="{{route('news.create')}}"><i class="fa fa-plus"></i> CREATE NEWS</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">HOME</a></li>
              <li class="breadcrumb-item active">NEWS</li>
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
                    <table class="data-table table mg-b-0">
                        <thead>
                          <tr>
                            <th>DATE</th>
                            <th>IMAGE</th>
                            <th>HEADING</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                          </tr>
                        </thead>
                        <tbody>
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

          <form role="form" action="{{url('admin/news')}}" method="post" id="removeForm">
              <div class="modal-body">
                  <p>Whole gallery will be deleted! Are you sure?</p>
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
    $(function () {
           $('.hide').hide();
         var table = $('.data-table').DataTable({
             processing: true,
             serverSide: true,
             ajax: {
               url: "{{ route('news.index') }}",
               data: function (d) {
                     d.search = $('input[type="search"]').val();
                     d.status   =$('#type').val();
                 }
             },
             columns: [
               {data: 'date', name: 'date'},
               {data: 'image', name: 'image'},
               {data: 'heading', name: 'heading'},
               {data: 'status', name: 'status'},
               {data: 'action', name: 'action'},
   
             ]
         });
         $('.filter').change(function(){
             table.draw();
         });
       });
   
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
                           $('.data-table').DataTable().ajax.reload();
                       }else{
                           $('#removeModal').modal('hide');
                           toastr.error(result.msg);
                           $('.data-table').DataTable().ajax.reload();
   
                       }
                   }
               });
           });
       }
       $("#newsNav").addClass('active');
   </script>