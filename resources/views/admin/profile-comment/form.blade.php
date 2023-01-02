<div class="box-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>نظر:</label>
                {!! Form::textarea('comment',null,array(
                    'class'=>'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>
</div>