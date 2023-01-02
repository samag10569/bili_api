<div class="box-body">
    <div class="form-group">
        {!! Form::label('count','تعداد ارسال',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('count',null,array('class'=>'form-control','placeholder' => 'تعداد ارسال در هر بار')) !!}
        </div>
        {!! Form::label('sender','ارسال کننده',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('sender',null,array('class'=>'form-control','placeholder' => 'ایمیل ارسال کننده')) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('subject','موضوع',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-10">
            {!! Form::text('subject',null,array('class'=>'form-control','placeholder' => 'موضوع ایمیل')) !!}
        </div>
    </div>
	
	<div class="form-group">
		 {!! Form::label('content','متن ایمیل',array('class'=>'col-lg-2 control-label')) !!}
		<div class="col-lg-10">
			{!! Form::textarea('content',null,array(
				'class'=>'form-control ckeditor',)) !!}
		</div>
    </div>


</div>


<div class="box-footer">
    <button type="submit" class="btn btn-primary">ذخیره</button>
</div>