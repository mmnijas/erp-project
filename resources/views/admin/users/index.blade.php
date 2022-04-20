@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            @if (auth()->user()->can('user.create'))
                <a class="btn btn-primary" href="{{route('users.create')}}"><i class="fa fa-plus"></i> ADD</a>
            @endif
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
                                            <th>PHOTO</th>
                                            <th>NAME</th>
                                            <th>EMAIL</th>
                                            <th>PHONE</th>
                                            <th>ROLE</th>
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
    $(function () {
      var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
        pageLength : 25,
        dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>",
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        ajax: {
          url: "{{ route('users.index') }}",
          data: function (d) {
                d.search = $('input[type="search"]').val();
            }
        },
        columns: [
            {data: 'profile_photo', name: 'profile_photo', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'role', name: 'role'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
      });
    });
    $("#userManagementNav").addClass('active');
    $("#userManagementNav").addClass('menu-open');
    $("#usersNav").addClass('active');
   </script>
   @include('admin.layouts.scripts')