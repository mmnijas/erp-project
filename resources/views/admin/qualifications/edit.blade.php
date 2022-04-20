<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="{{route('qualifications.update',$qualification->id)}}" accept-charset="UTF-8" id="edit_form">
            <input name="_method" type="hidden" value="PUT">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">EDIT QUALIFICATION</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">QUALIFICATION NAME:*</label>
                    <input class="form-control" required="" value="{{$qualification->name}}" placeholder="QUALIFICATION NAME" autocomplete="off" name="name" type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">STATUS</label>
                    <select class="form-control" name="status" required>
                        <option value="1" @if($qualification->status == 1) selected @endif>ACTIVE</option>
                        <option value="2" @if($qualification->status == 2) selected @endif>INACTIVE</option>
                    </select>    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">UPDATE</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
            </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->