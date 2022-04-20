<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="{{route('bank-service-charges.store')}}" accept-charset="UTF-8" id="createForm">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">ADD BANK SERVICE CHARGES</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
        
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
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
                            <label for="name" class="control-label">LOWER LIMIT:*</label>
                            <input class="form-control" required="" placeholder="LOWER LIMIT" maxlength="11" autocomplete="off" name="lower_limit" type="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">UPPER LIMIT:*</label>
                            <input class="form-control" required="" placeholder="UPPER LIMIT" maxlength="11" autocomplete="off" name="upper_limit" type="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">TYPE:*</label>
                            <select class="form-control" name="type" required>
                                <option value="fixed">FIXED</option>
                                <option value="percentage">PERCENTAGE</option>
                            </select>    
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">SERVICE CHARGE:*</label>
                            <input class="form-control" required="" placeholder="SERVICE CHARGE" autocomplete="off" name="value" type="number">
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