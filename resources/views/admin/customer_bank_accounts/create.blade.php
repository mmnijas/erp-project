<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form method="post" action="{{route('customer-bank-accounts.store')}}" accept-charset="UTF-8" id="createForm" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">ADD BANK ACCOUNT</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
        
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">BANK:*</label>
                            <select name="bank_id" id="" class="form-control select2" required style="width:100%">
                                <option value="">SELECT BANK</option>
                                @foreach ($banks as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">NAME:*</label>
                            <input class="form-control" required="" placeholder="ENTER NAME" autocomplete="new-name"  name="name" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">ACCOUNT NUMBER:*</label><span class="text-center" id='message'></span>
                            <input class="form-control" required="" placeholder="ACCOUNT NUMBER" autocomplete="new-account" name="account_number" id="account_number" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label"> CONFIRM ACCOUNT NUMBER:*</label>
                            <input class="form-control" required="" placeholder="CONFIRM ACCOUNT NUMBER" autocomplete="off" name="confirm_account_number" id="confirm_account_number" type="text">
                        </div>
                    </div>
                    <div class="col-md-12">
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">PHONE:*</label>
                            <input class="form-control" required="" maxlength="10" placeholder="ENTER PHONE" autocomplete="off" name="phone" type="text">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name" class="control-label">IFSC:</label>
                            <input class="form-control" placeholder="ENTER IFSC" maxlength="11" autocomplete="off" name="ifsc" type="text">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">STATUS:*</label>
                            <select class="form-control" name="status" required>
                                <option value="1">ACTIVE</option>
                                <option value="2">IN ACTIVE</option>
                            </select>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success save_button">SAVE</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">CLOSE!</button>
            </div>
        </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $(document).ready(function(){
        $('.select2').select2()
    });
    $('#account_number, #confirm_account_number').on('change', function () {
        $('#account_number').attr('type', 'password'); 
        if ($('#account_number').val() == $('#confirm_account_number').val()) {
            $('#message').html('[MATCHING]').css('color', 'green');
        } else 
            $('#message').html('[NOT MATCHING]').css('color', 'red');
    });
</script>