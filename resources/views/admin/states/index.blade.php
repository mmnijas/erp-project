@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <button type="button" class="btn btn-primary btn-modal" data-href="{{route('states.create')}}" data-container=".modal_class">
              <i class="fa fa-plus"></i> ADD</button>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('admin')}}">HOME</a></li>
                <li class="breadcrumb-item active">USERS</li>
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
            @include('admin.layouts.session')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">USERS</h3>
                </div>
                <div class="card-body">
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-striped data-table">
                                    <thead>
                                        <tr>
                                            <th>NAME</th>
                                            <th>STATE CODE</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                </table>
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
<div class="modal fade modal_class" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
@include('admin.layouts.footer')
<script >
    $( document ).ready(function() {
        //DATA TABLE LOAD STARTS HERE
        var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
        pageLength : 25,
        dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>",
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        ajax: {
          url: "{{ route('states.index') }}",
          data: function (d) {
                d.search = $('input[type="search"]').val();
            }
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'state_code', name: 'state_code'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
      });
      //DATA TABLE LOAD END HERE

      //CREATE FORM APPEND TO modal_class AND POST ACTIONS
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
                    $('.save_button').attr('disabled', false);
              }
          }
      });
    });

    //EDIT FORM APPEND TO modal_class AND POST ACTIONS
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
                            $('.save_button').attr('disabled', false);
                        }
                    },
                });
            });
        });
    });
    });

    $("#mastersNav").addClass('active');
    $("#statesNav").addClass('active');
   </script>
   @include('admin.layouts.scripts')