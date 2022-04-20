<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form method="POST" action="{{route('banking-account-ledgers.update',$ledger->id)}}" accept-charset="UTF-8" id="edit_form">
            <input name="_method" type="hidden" value="PUT">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">EDIT BANKS</h4>
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
                                    <option value="{{$item->id}}" @if($ledger->banking_account_group_id == $item->id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">NAME:*</label>
                            <input class="form-control" required value="{{$ledger->name}}" placeholder="LEDGER NAME" autocomplete="off" name="name" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">CODE:*</label>
                            <input class="form-control" required value="{{$ledger->code}}" placeholder="LEDGER CODE" autocomplete="off" name="code" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">OPENING BALANCE:*</label>
                            <input class="form-control" required value="{{$ledger->opening_balance}}" placeholder="OPENING BALANCE" autocomplete="off" name="opening_balance" type="number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">OPENING BALANCE TYPE:*</label>
                            <select class="form-control" required name="opening_balance_dc">
                                <option value="D" @if($ledger->opening_balance_dc == 'D') selected @endif>DEBIT</option>
                                <option value="C" @if($ledger->opening_balance_dc == 'C') selected @endif>CREDIT</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">VISIBILITY:*</label>
                            <select class="form-control" required name="visibility">
                                <option value="1" @if($ledger->visibility == 1) selected @endif>SHOW</option>
                                <option value="2" @if($ledger->visibility == 2) selected @endif>HIDE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">PAYMENT ACCOUNT:*</label>
                            <select class="form-control" required name="payment_account">
                                <option value="1" @if($ledger->payment_account == 1) selected @endif>YES</option>
                                <option value="2" @if($ledger->payment_account == 2) selected @endif>NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">STATUS:*</label>
                            <select class="form-control" name="status" required>
                                <option value="1" @if($ledger->status == 1) selected @endif>ACTIVE</option>
                                <option value="2" @if($ledger->status == 2) selected @endif>IN ACTIVE</option>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="control-label">DESCRIPTION:*</label>
                            <textarea class="form-control" placeholder="DESCRIPTION" autocomplete="off" name="description" type="text">{{$ledger->description}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary save_button">UPDATE</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
            </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->