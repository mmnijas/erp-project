<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="{{route('banking-account-groups.store')}}" accept-charset="UTF-8" id="createForm">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">ADD BANK ACCOUNT GROUPS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
        
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">NAME:*</label>
                    <input class="form-control" required="" placeholder="GROUP NAME" autocomplete="off" name="name" type="text">
                </div>
                
                <div class="form-group">
                    <label for="name" class="control-label">PARENT GROUP:*</label>
                    <select name="parent_id" id="" class="form-control select2" required style="width:100%">
                        <option value="">SELECT GROUP</option>
                        @foreach ($parent_groups as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">CODE:*</label>
                    <input class="form-control" required="" placeholder="GROUP CODE" autocomplete="off" name="code" type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">STATUS:*</label>
                    <select class="form-control" name="status" required>
                        <option value="1">ACTIVE</option>
                        <option value="2">IN ACTIVE</option>
                    </select>    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success save_button">SAVE</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->