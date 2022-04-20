<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="{{route('districts.update',$districts->id)}}" accept-charset="UTF-8" id="edit_form">
            <input name="_method" type="hidden" value="PUT">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">EDIT DISTRICTS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">STATES:*</label>
                    <select name="state_id" id="" class="form-control select2" style="width:100%" required>
                        <option value="">SELECT GROUP</option>
                        @foreach ($states as $item)
                            <option value="{{$item->id}}" @if($districts->state_id == $item->id) selected @endif>{{$item->name}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label for="name" class="control-label">DISTRICT NAME:*</label>
                    <input class="form-control" name="name" required="" value="{{$districts->name}}" placeholder="NAME" autocomplete="off"  type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">STATUS</label>
                    <select class="form-control" name="status" required>
                        <option value="1" @if($districts->status == 1) selected @endif>ACTIVE</option>
                        <option value="2" @if($districts->status == 2) selected @endif>INACTIVE</option>
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