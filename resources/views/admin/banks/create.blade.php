<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="{{route('banks.store')}}" accept-charset="UTF-8" id="createForm">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">ADD BANKS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
        
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="control-label">BANK NAME:*</label>
                            <input class="form-control" required="" placeholder="NAME" maxlength="50" autocomplete="off" name="name" type="text" id="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">COMMISSION GROUP:*</label>
                            <select name="group_id" id="" class="form-control select2" required style="width:100%">
                                <option value="">SELECT GROUP</option>
                                @foreach ($groups as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">COMMON IFSC:*</label>
                            <input class="form-control" required="" placeholder="COMMON IFSC" maxlength="11" autocomplete="off" name="common_ifsc" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">ACCOUNT NUMBER LENGTH:*</label>
                            <input class="form-control" required="" placeholder="A/C NUMBER LENGTH" max="20" autocomplete="off" name="account_number_length" type="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">STATUS:*</label>
                            <select class="form-control" name="status" required>
                                <option value="1">ACTIVE</option>
                                <option value="2">IN ACTIVE</option>
                            </select>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success save_button">SAVE</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>$(document).ready(function(){$('.select2').select2()})</script>