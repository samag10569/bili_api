<div class="box-body">
    <div class="form-group">
        <div class="col-md-4">
        {!! Form::label('name','نام',array('class'=>'control-label')) !!}

            {!! Form::text('name',null,array('class'=>'form-control')) !!}
        </div>
        <div class="col-md-4">
        {!! Form::label('email','پست الکترونیک',array('class'=>' control-label')) !!}
            {!! Form::text('email',null,array('class'=>'form-control','placeholder' => 'ایمیل ')) !!}
        </div>
        <div class="col-md-4">
            {!! Form::label('phone','موبایل',array('class'=>' control-label')) !!}
            {!! Form::text('phone',null,array('class'=>'form-control','placeholder' => 'موبایل')) !!}
        </div>

        <div class="col-md-3">
            {!! Form::label('status','وضعیت',array('class'=>' control-label')) !!}
            {!! Form::select('status',$status,null,array(
                'class'=>'form-control')) !!}
        </div>
    </div>

</div>


<div class="box-footer">
    <button type="submit" class="btn btn-primary">ذخیره</button>
</div>