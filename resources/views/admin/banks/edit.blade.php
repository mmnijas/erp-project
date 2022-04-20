<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="{{route('banks.update',$banks->id)}}" accept-charset="UTF-8" id="edit_form">
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
                            <label for="name" class="control-label">BANK NAME:*</label>
                            <input class="form-control" required="" value="{{$banks->name}}" placeholder="NAME" maxlength="50" autocomplete="off" name="name" type="text" id="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">COMMISSION GROUP:*</label>
                            <select name="group_id" id="" class="form-control select2" style="width:100%" required>
                                <option value="">SELECT GROUP</option>
                                @foreach ($groups as $item)
                                    <option value="{{$item->id}}" @if($banks->group_id == $item->id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">COMMON IFSC:*</label>
                            <input class="form-control" required="" value="{{$banks->common_ifsc}}" placeholder="COMMON IFSC" maxlength="11" autocomplete="off" name="common_ifsc" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">ACCOUNT NUMBER LENGTH:*</label>
                            <input class="form-control" required="" value="{{$banks->account_number_length}}" placeholder="ACCOUNT NUMBER LENGTH" max="20" autocomplete="off" name="account_number_length" type="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">STATUS:*</label>
                            <select class="form-control" name="status" required>
                                <option value="1" @if($banks->status == 1) selected @endif>ACTIVE</option>
                                <option value="2" @if($banks->status == 2) selected @endif>INACTIVE</option>
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