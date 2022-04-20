@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- @if (auth()->user()->can('roles')) --}}
                {{-- <a class="btn btn-primary" href="{{route('roles.create')}}"><i class="fa fa-plus"></i> ADD</a> --}}
            {{-- @endif --}}
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('admin')}}">HOME</a></li>
                <li class="breadcrumb-item"><a href="{{route('bank-transactions.index')}}">BANK TRANSACTIONS</a></li>
                <li class="breadcrumb-item active">CREATE</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @include('admin.layouts.error')
        @include('admin.layouts.session')
        <div class="row">
          <div class="col-12">
            <!-- general form elements -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">BANK TRANSACTIONS</h3>
                </div>
                <div class="card-body">
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <form method="POST" action="{{route('bank-transactions.store')}}" accept-charset="UTF-8" id="paymentForm" enctype="multipart/form-data">
                                    @csrf 
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-10">
                                              <div class="form-group">
                                                <label for="name">BANK ACCOUNT*:</label>
                                                  <select type="text" class="form-control select2 customer_accounts" required name="customer_account_id" id="customer_account_id" onchange="getServiceCharge()">
                                                    <option value="">SEARCH ACCOUNT</option>
                                                </select>
                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                              <div class="form-group" style="padding-top: 7px">
                                                  <br>
                                                  <button type="button" class="btn btn-block btn-sm btn-danger btn-modal" data-href="{{route('customer-bank-accounts.create')}}" data-container=".modal_class">
                                                    <i class="fa fa-user-plus"></i> ADD ACCOUNT</button>
                                              </div>
                                          </div>
                                          <div class="col-md-12 table-responsive">
                                            <table class="table table-striped table-bordered" id="paymentTable">
                                              <thead class="bg-red">
                                                <tr>
                                                  <th>TRANSFER AMOUNT</th>
                                                  <th>SERVICE CHARGE</th>
                                                  <th>DISCOUNT</th>
                                                  <th>TOTAL AMOUNT</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <tr>
                                                  <td><input type="number" autocomplete="off" class="form-control" name="amount" id="amount" value="{{old('amount',0)}}" placeholder="ENTER AMOUNT" onchange="getServiceCharge()"></td>
                                                  <td><input type="text" class="form-control" name="service_charge" id="service_charge" value="{{old('service_charge',0)}}" readonly></td>
                                                  <td><input type="number" required class="form-control" name="discount" id="discount" value="{{old('discount',0)}}" onchange="getServiceCharge()"></td>
                                                  <td><input type="text" class="form-control" name="final_total" id="final_total" value="{{old('final_total',0)}}" readonly></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                          <div class="col-md-12 table-responsive">
                                            <table class="table table-striped table-bordered">
                                              <thead class="bg-red">
                                                <tr>
                                                  <th>2000</th>
                                                  <th>500</th>
                                                  <th>200</th>
                                                  <th>100</th>
                                                  <th>50</th>
                                                  <th>20</th>
                                                  <th>10</th>
                                                  <th>CUSTOM</th>
                                                  <th>TOTAL</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <tr>
                                                  <td><input type="text" value="{{old('denomination_2000',0)}}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="0" class="form-control denomination" name="denomination_2000" id="denomination_2000"></td>
                                                  <td><input type="text" value="{{old('denomination_500',0)}}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="0" class="form-control denomination" name="denomination_500" id="denomination_500"></td>
                                                  <td><input type="text" value="{{old('denomination_200',0)}}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="0" class="form-control denomination" name="denomination_200" id="denomination_200"></td>
                                                  <td><input type="text" value="{{old('denomination_100',0)}}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="0" class="form-control denomination" name="denomination_100" id="denomination_100"></td>
                                                  <td><input type="text" value="{{old('denomination_50',0)}}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="0" class="form-control denomination" name="denomination_50" id="denomination_50"></td>
                                                  <td><input type="text" value="{{old('denomination_20',0)}}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="0" class="form-control denomination" name="denomination_20" id="denomination_20"></td>
                                                  <td><input type="text" value="{{old('denomination_10',0)}}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="0" class="form-control denomination" name="denomination_10" id="denomination_10"></td>
                                                  <td><input type="text" value="{{old('denomination_custom',0)}}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="0" class="form-control denomination" name="denomination_custom" id="denomination_custom"></td>
                                                  <td><input type="text" value="{{old('total',0)}}" class="form-control denomination" readonly id="total" name="total"></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">REGISTERED MOBILE NUMBERS</label>
                                                <input type="text" name="registered_numbers" id="registered_numbers" class="form-control" placeholder="REGISTERED NUMBERS">
                                            </div>
                                        </div>
                                            
                                        </div>
                                    
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <a href="{{route('bank-transactions.index')}}" class="btn btn-warning">Go BACK!</a>
                                        <button type="submit" class="btn btn-danger float-right save_button">SAVE ENTRY</button>
                                    </div>
                                </form>
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
    $("#bankingNav").addClass('active');
    $("#bankTransactionsNav").addClass('active');
</script>
<script>
$(document).ready(function(){
    $('.customer_accounts').select2({
            placeholder: 'SEARCH ACCOUNT',
            ajax: {
                url: '{{route("get-customer-account")}}',
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        searchTerm: data.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
        });

        //CREATE FORM APPEND TO modal_class AND POST ACTIONS
    $(document).unbind('submit').on('submit', 'form#createForm', function(e){
      e.preventDefault();
      $(this).find('button[type="submit"]').attr('disabled', true);
      var data = $(this).serialize();
      $('.customer_accounts').find('option').remove().end();
      $.ajax({
          method: "post",
          url: $(this).attr("action"),
          dataType: "json",
          data: data,
          success:function(result){
              if(result.success == true){
                  $('div.modal_class').modal('hide');
                  toastr.success(result.msg);
                  $('.customer_accounts').append($('<option>').text('NAME: '+result.data.name+' | PHONE:'+result.data.phone+' | ACCOUNT NUMBER:'+result.data.account_number).val(result.data.id)).end();
              }else{
                  toastr.error(result.msg);
                  $('.save_button').attr('disabled', false);
              }
          }
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
})

function getServiceCharge(){
  $.ajax({
      type: "POST",
      url: '{{route("get-service-charge")}}',
      data: {
          "_token": "{{ csrf_token() }}",
          "account_id": $('#customer_account_id').val(),
          "amount": $('#amount').val(),
      },
      success: function(response) {
          alert('success');
      },
      success:function(result){
          if(result.success == true){
            $("#service_charge").val(result.charge);
            $("#final_total").val(parseFloat($('#amount').val())-parseFloat($('#discount').val())+parseFloat(result.charge));
                        toastr.success(result.msg);
            $('.save_button').attr('disabled', false);
          }else{
            toastr.error(result.msg);
            $('.save_button').attr('disabled', true);
            $("#registered_numbers").val(result.registered_numbers);
          }
      }
  });
}

$(document).on('change', '.denomination', function(e) {
    var result =  $("#denomination_2000").val() * 2000 + $("#denomination_500").val() * 500 + $("#denomination_200").val() * 200 + $("#denomination_100").val() * 100 + $("#denomination_50").val() * 50 + $("#denomination_20").val() * 20 + $("#denomination_10").val() * 10 + parseFloat($("#denomination_custom").val());
    if (!isNaN(result)){
      $("#total").val(result);
    }
});
</script>
@include('admin.bank_transactions.validations')