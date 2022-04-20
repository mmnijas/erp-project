@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <button type="button" class="btn btn-primary btn-modal" data-href="{{route('bank-service-commission-groups.create')}}" data-container=".modal_class">
                <i class="fa fa-plus-circle"></i> ADD</button>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('admin')}}">HOME</a></li>
                <li class="breadcrumb-item active">BANK SERVICE COMMISSION GROUPS</li>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">BANK SERVICE COMMISSION GROUPS</h3>
                </div>
                <div class="card-body">
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="data-table table table-bordered table-striped mg-b-0">
                                    <thead>
                                      <tr>
                                        <th>NAME</th>
                                        <th>DESCRIPTION</th>
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
        </div>
      </div>
    </section>
</div>
<div class="modal fade modal_class" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
@include('admin.layouts.footer')
<script >
    $(document).ready(function() {
        var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>",
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        ajax: {
          url: "{{ route('bank-service-commission-groups.index') }}",
          data: function (d) {
                d.search = $('input[type="search"]').val();
            }
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'descriptions', name: 'descriptions'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action'},
        ],
      });


      /*CREATE MODAL POST AJAX CALL */
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
        
        /*EDIT MODAL POST AJAX CALL */
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
    $("#bankingNav").addClass('active');
    $("#BankServiceCommissionGroupsNav").addClass('active');
   </script>
   @include('admin.layouts.scripts')