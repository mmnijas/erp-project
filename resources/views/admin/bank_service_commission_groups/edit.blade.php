 <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="{{route('bank-service-commission-groups.update',$bankservice_commission_groups->id)}}" accept-charset="UTF-8" id="edit_form">

            <input name="_method" type="hidden" value="PUT">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">EDIT BANK SERVICE COMMISSION GROUP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">NAME:*</label>
                    <input class="form-control" required="" value="{{$bankservice_commission_groups->name}}" placeholder="NAME" autocomplete="off" name="name" type="text">
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">DISCRIPTION:*</label>
                    <input class="form-control" required="" value="{{$bankservice_commission_groups->descriptions}}" placeholder="NAME" autocomplete="off" name="descriptions" type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">STATUS</label>
                    <select class="form-control" name="status" required>
                        <option value="1" @if($bankservice_commission_groups->status == 1) selected @endif>ACTIVE</option>
                        <option value="2" @if($bankservice_commission_groups->status == 2) selected @endif>INACTIVE</option>
                    </select>    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary save_button">UPDATE</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
            </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->