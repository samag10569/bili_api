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
        {!! Form::label('start','عضویت ازتاریخ',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('start',null,array('class'=>'form-control date','placeholder' => 'ازتاریخ')) !!}
        </div>
        {!! Form::label('end','عضویت تا تاریخ',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('end',null,array('class'=>'form-control date','placeholder' => 'تا تاریخ')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('branch_id','مقطع تحصیلی',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::select('branch_id',$branch_id,null,array('class'=>'form-control')) !!}
        </div>
        {!! Form::label('category_id','شاخه تحصیلی',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::select('category_id',$category_id,null,array('class'=>'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('branch','رشته تحصیلی',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('branch',null,array('class'=>'form-control','placeholder' => 'رشته تحصیلی')) !!}
        </div>
        {!! Form::label('city','آدرس محل سکونت',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('city',null,array('class'=>'form-control','placeholder' => 'آدرس محل سکونت')) !!}
        </div>
    </div>




    <div class="form-group">
        {!! Form::label('state_id','استان',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::select('state_id',$state_id,null,array('class'=>'form-control')) !!}
        </div>
    </div>

</div>


<div class="box-footer">
    <button type="submit" class="btn btn-primary">ذخیره</button>
</div>