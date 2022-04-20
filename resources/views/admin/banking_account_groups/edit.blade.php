<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="{{route('banking-account-groups.update',$group->id)}}" accept-charset="UTF-8" id="edit_form">
            <input name="_method" type="hidden" value="PUT">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">EDIT BANKS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">NAME:*</label>
                    <input class="form-control" required value="{{$group->name}}" placeholder="GROUP NAME" autocomplete="off" name="name" type="text">
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">PARENT GROUP:*</label>
                    <select name="parent_id" id="" class="form-control select2" required style="width:100%">
                        <option value="">SELECT GROUP</option>
                        @foreach ($parent_groups as $item)
                            <option value="{{$item->id}}" @if($group->parent_id == $item->id) selected @endif>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">CODE:*</label>
                    <input class="form-control" required value="{{$group->code}}" placeholder="LEDGER CODE" autocomplete="off" name="code" type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">STATUS:*</label>
                    <select class="form-control" name="status" required>
                        <option value="1" @if($group->status == 1) selected @endif>ACTIVE</option>
                        <option value="2" @if($group->status == 2) selected @endif>IN ACTIVE</option>
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