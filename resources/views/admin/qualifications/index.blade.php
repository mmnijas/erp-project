@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <button type="button" class="btn btn-primary btn-modal" data-href="{{route('qualifications.create')}}" data-container=".modal_class">
                <i class="fa fa-plus"></i> ADD</button>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('admin')}}">HOME</a></li>
                <li class="breadcrumb-item active">QUALIFICATION</li>
              
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
                            <th>NAME</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
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

          <form role="form" action="{{url('admin/qualifications')}}" method="post" id="removeForm">
              <div class="modal-body">
                  <p>This will be deleted! Are you sure?</p>
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
<div class="modal fade modal_class" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
@include('admin.layouts.footer')
<script >
    $(function () {
         var table = $('.data-table').DataTable({
             processing: true,
             serverSide: true,
             ajax: {
               url: "{{ route('qualifications.index') }}",
               data: function (d) {
                     d.search = $('input[type="search"]').val();
                 }
             },
             columns: [
               {data: 'name', name: 'name'},
               {data: 'status', name: 'status'},
               {data: 'action', name: 'action'},
   
             ]
         });
       });
       $(document).unbind('submit').on('submit', 'form#createForm', function(e){
            e.preventDefault();
            $(this).find('button[type="submit"]').attr('disabled', true);
            var data = $(this).serialize();
            $.ajax({
                method: "post",
                url: $(this).attr("action"),
                dataType: "json",
                data: data,
                success:function(result){
                    if(result.success == true){
                        $('#createModal').modal('hide');
                        toastr.success(result.msg);
                        $('.data-table').DataTable().ajax.reload();
                    }else{
                        toastr.error(result.msg);
                    }
                }
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
                       if(result.success == true){
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

    $(document).unbind('submit').on('submit', 'form#createForm', function(e){
        e.preventDefault();
        $(this).find('button[type="submit"]').attr('disabled', true);
        var data = $(this).serialize();
        $.ajax({
            method: "post",
            url: $(this).attr("action"),
            dataType: "json",
            data: data,
            success:function(result){
                if(result.success == true){
                    $('div.modal_class').modal('hide');
                    toastr.success(result.msg);
                    $('.data-table').DataTable().ajax.reload();
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });

    $(document).on('click', 'button.edit_button', function() {
        $('div.modal_class').load($(this).data('href'), function() {
            $(this).modal('show');
            $('form#edit_form').submit(function(e) {
                $(this).find('button[type="submit"]').attr('disabled', true);
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        if (result.success === true) {
                            $('div.modal_class').modal('hide');
                            toastr.success(result.msg);
                            $('.data-table').DataTable().ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
        });
    });
    $(document).on('click', '.btn-modal', function(e) {
        e.preventDefault();
        var container = $(this).data('container');
        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function(result) {
                $(container)
                    .html(result)
                    .modal('show');
            },
        });
    });
   </script>
<script>
    $("#mastersNav").addClass('active');
    $("#qualificationsNav").addClass('active');
</script>