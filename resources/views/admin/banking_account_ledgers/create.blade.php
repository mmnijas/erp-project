<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form method="post" action="{{route('banking-account-ledgers.store')}}" accept-charset="UTF-8" id="createForm">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">ADD BANK ACCOUNT LEDGER</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
        
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">BANK ACCOUNT GROUP:*</label>
                            <select name="banking_account_group_id" id="" class="form-control select2" required style="width:100%">
                                <option value="">SELECT GROUP</option>
                                @foreach ($groups as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">NAME:*</label>
                            <input class="form-control" required="" placeholder="LEDGER NAME" autocomplete="off" name="name" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">CODE:*</label>
                            <input class="form-control" required="" placeholder="LEDGER CODE" autocomplete="off" name="code" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">OPENING BALANCE:*</label>
                            <input class="form-control" required="" placeholder="OPENING BALANCE" autocomplete="off" name="opening_balance" type="number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">OPENING BALANCE TYPE:*</label>
                            <select class="form-control" required name="opening_balance_dc">
                                <option value="D">DEBIT</option>
                                <option value="C">CREDIT</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">VISIBILITY:*</label>
                            <select class="form-control" required name="visibility">
                                <option value="1">SHOW</option>
                                <option value="2">HIDE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">PAYMENT ACCOUNT:*</label>
                            <select class="form-control" required name="payment_account">
                                <option value="1">YES</option>
                                <option value="2">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">STATUS:*</label>
                            <select class="form-control" name="status" required>
                                <option value="1">ACTIVE</option>
                                <option value="2">IN ACTIVE</option>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="control-label">DESCRIPTION:*</label>
                            <textarea class="form-control" placeholder="DESCRIPTION" autocomplete="off" name="description" type="text"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success save_button">SAVE</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>$(document).ready(function(){$('.select2').select2()})</script>