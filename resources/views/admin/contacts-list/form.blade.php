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
        {!! Form::label('subject','عنوان',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-10">
            {!! Form::text('subject',null,array('class'=>'form-control','placeholder' => 'عنوان')) !!}
        </div>
    </div>

	
	<div class="form-group">
		<div class="col-lg-2">
		</div>
		<div class="col-lg-6 ejavan_title">
			فیلتر ارسال ایمیل به کاربران
		</div>
		<div class="col-lg-4">
		</div>
    </div>
	
    <div class="form-group">
        {!! Form::label('start',' ازتاریخ',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('start',null,array('class'=>'form-control','placeholder' => 'ازتاریخ','id'=>'date1')) !!}
        </div>
        {!! Form::label('end',' تا تاریخ',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('end',null,array('class'=>'form-control','placeholder' => 'تا تاریخ','id'=>'date2')) !!}
        </div>
    </div>
	
    <div class="form-group">
        {!! Form::label('user_id',' کد یکتا معرف',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('user_id',null,array('class'=>'form-control','placeholder' => ' کد یکتا معرف')) !!}
        </div>
		
        {!! Form::label('send_email','دعوت نامه',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
           {!! Form::select('send_email',$send_email,null,array('class'=>'form-control')) !!}
        </div>
		
    </div>

</div>


<div class="box-footer">
    <button type="submit" class="btn btn-primary">ذخیره</button>
</div>