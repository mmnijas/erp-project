<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form method="POST" action="{{route('customer-bank-accounts.update',$account->id)}}" accept-charset="UTF-8" id="edit_form">
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
                            <label for="name" class="control-label">BANK:*</label>
                            <select name="bank_id" id="" class="form-control select2" required style="width:100%">
                                <option value="">SELECT BANK</option>
                                @foreach ($banks as $item)
                                    <option value="{{$item->id}}" @if($account->bank_id == $item->id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">ACCOUNT NUMBER:*</label>
                            <input class="form-control" required="" value="{{$account->account_number}}" placeholder="ACCOUNT NUMBER" autocomplete="off" name="account_number" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">NAME:*</label>
                            <input class="form-control" required="" value="{{$account->name}}" placeholder="ENTER NAME" autocomplete="off" name="name" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">PHONE:*</label>
                            <input class="form-control" required="" value="{{$account->phone}}" placeholder="ENTER PHONE" autocomplete="off" name="phone" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">IFSC:*</label>
                            <input class="form-control" placeholder="ENTER IFSC" value="{{$account->ifsc}}" maxlength="11" autocomplete="off" name="ifsc" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">STATUS:*</label>
                            <select class="form-control" name="status" required>
                                <option value="1" @if($account->status == 1) selected @endif>ACTIVE</option>
                                <option value="2" @if($account->status == 2) selected @endif>IN ACTIVE</option>
                            </select>    
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