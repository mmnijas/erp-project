<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="{{route('careers.update',$careers->id)}}" accept-charset="UTF-8" id="edit_form">
            <input name="_method" type="hidden" value="PUT">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">EDIT CAREERS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">CAREERS NAME:*</label>
                    <input class="form-control" required="" value="{{$careers->name}}" placeholder="CAREERS NAME" autocomplete="off" name="name" type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">QUALIFICATIONS</label>
                    <select class="form-control" name="qualification_id" required>
                        <option value="">SELECT</option>
                        @foreach ($qualifications as $item)
                            <option value="{{$item->id}}" @if($item->id == $careers->qualification_id) selected @endif>{{$item->name}}</option>
                        @endforeach
                    </select>    
                </div>
                <div class="form-group">
                    <label class="control-label">JOB TYPE</label>
                    <select class="form-control" name="job_type_id" required>
                        <option value="">SELECT</option>
                        @foreach ($job_types as $item)
                            <option value="{{$item->id}}" @if($item->id == $careers->job_type_id) selected @endif>{{$item->name}}</option>
                        @endforeach
                    </select>    
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">DESCRIPTIONS</label>
                    <textarea class="form-control" placeholder="DESCRIPTION" autocomplete="off" name="description">{{$careers->description}}</textarea>
                </div>
                <div class="form-group">
                    <label class="control-label">STATUS</label>
                    <select class="form-control" name="status" required>
                        <option value="1" @if($careers->status == 1) selected @endif>ACTIVE</option>
                        <option value="2" @if($careers->status == 2) selected @endif>INACTIVE</option>
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