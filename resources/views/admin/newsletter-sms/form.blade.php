<div class="box-body">
    <div class="form-group">
        {!! Form::label('count','تعداد ارسال',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('count',null,array('class'=>'form-control','placeholder' => 'تعداد ارسال در هر بار')) !!}
        </div>
        {!! Form::label('sender','ارسال کننده',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('sender',null,array('class'=>'form-control','placeholder' => 'شماره پیامک ارسال ')) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('subject','موضوع',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-10">
            {!! Form::text('subject',null,array('class'=>'form-control','placeholder' => 'موضوع پیامک')) !!}
        </div>
    </div>
	
	<div class="form-group">
		 {!! Form::label('content','متن پیامک',array('class'=>'col-lg-2 control-label')) !!}
		<div class="col-lg-10">
			{!! Form::textarea('content',null,array(
				'class'=>'form-control ckeditor',)) !!}
		</div>
    </div>


</div>


<div class="box-footer">
    <button type="submit" class="btn btn-primary">ذخیره</button>
</div>