<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="{{route('bank-service-commission-groups.store')}}" accept-charset="UTF-8" id="createForm">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">ADD BANK SERVICE COMMISSION GROUP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>

            <div class="modal-body">
                
                <div class="form-group">
                    <label for="name" class="control-label">NAME:*</label>
                    <input class="form-control" required="" placeholder="NAME" autocomplete="off" name="name" type="text" id="name">
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">DISCRIPTION:*</label>
                    <input class="form-control" required="" placeholder="DISCRIPTION" autocomplete="off" name="descriptions" type="text" id="descriptions">
                </div>
                <div class="form-group">
                    <label class="control-label">STATUS</label>
                    <select class="form-control" name="status" required>
                        <option value="1">ACTIVE</option>
                        <option value="2">IN ACTIVE</option>
                    </select>    
                </div>
            </div>
        
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary save_button">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
