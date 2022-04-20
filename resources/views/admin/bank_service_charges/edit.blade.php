<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="{{route('bank-service-charges.update',$charge->id)}}" accept-charset="UTF-8" id="edit_form">
            <input name="_method" type="hidden" value="PUT">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">EDIT BANKS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="control-label">COMMISSION GROUP:*</label>
                            <select name="group_id" id="" class="form-control select2" required style="width:100%" disabled>
                                <option value="">SELECT GROUP</option>
                                @foreach ($groups as $item)
                                    <option value="{{$item->id}}" @if($charge->group_id == $item->id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">LOWER LIMIT:*</label>
                            <input class="form-control" disabled required="" value="{{$charge->lower_limit}}" placeholder="LOWER LIMIT" maxlength="11" autocomplete="off" name="lower_limit" type="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">UPPER LIMIT:*</label>
                            <input class="form-control" disabled required="" value="{{$charge->upper_limit}}"  placeholder="UPPER LIMIT" maxlength="11" autocomplete="off" name="upper_limit" type="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">TYPE:*</label>
                            <select class="form-control" name="type" required>
                                <option value="fixed" @if($charge->type == 'fixed') selected @endif>FIXED</option>
                                <option value="percentage" @if($charge->type == 'percentage') selected @endif>PERCENTAGE</option>
                            </select>    
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">SERVICE CHARGE:*</label>
                            <input class="form-control" required="" value="{{$charge->value}}" placeholder="SERVICE CHARGE" autocomplete="off" name="value" type="number">
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