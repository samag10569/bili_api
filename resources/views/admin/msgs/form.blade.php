<div class="box-body">
    <div class="form-group">
        {!! Form::label('title','موضوع',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-10">
            {!! Form::text('title',null,array('class'=>'form-control','placeholder' => 'موضوع ')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('body','متن ',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-10">
            {!! Form::textarea('body',null,array(
                'class'=>'form-control ckeditor',)) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('name','نام',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('name',null,array('class'=>'form-control ','placeholder' => '')) !!}
        </div>
        {!! Form::label('family','نام خانوادگی',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('family',null,array('class'=>'form-control ','placeholder' => '')) !!}
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
        {!! Form::label('email','آدرس ایمیل',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('email',null,array('class'=>'form-control','placeholder' => '')) !!}
        </div>
        {!! Form::label('user_code','کد یکتا',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('user_code',null,array('class'=>'form-control','placeholder' => ' ')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('mobile1','شماره تماس از رنچ',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('mobile1',null,array('class'=>'form-control','placeholder' => '')) !!}
        </div>
        {!! Form::label('mobile2','شماره تماس تا رنچ',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('mobile2',null,array('class'=>'form-control','placeholder' => '')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('gender ','جنسیت',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::select('gender',$gender,null,array('class'=>'form-control')) !!}
        </div>
        {!! Form::label('birth_date ','تاریخ تولد',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('birth_date',null,array('class'=>'form-control date','placeholder' => 'تاریخ تولد')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('state','استان',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::select('state',$state_id,null,array('class'=>'form-control')) !!}
        </div>
        {!! Form::label('city','شهر',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('city',null,array('class'=>'form-control','placeholder' => '')) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('ncode1','رنج کد ملی از',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('ncode1',null,array('class'=>'form-control','placeholder' => '')) !!}
        </div>
        {!! Form::label('ncode2','رنج کد ملی تا',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('ncode2',null,array('class'=>'form-control','placeholder' => '')) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('postal_code1','رنج کد پستی از',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('postal_code1',null,array('class'=>'form-control','placeholder' => '')) !!}
        </div>
        {!! Form::label('postal_code2','رنج کد پستی تا',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('postal_code2',null,array('class'=>'form-control','placeholder' => '')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('shakhe','شاخه تحصیلی',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::select('shakhe',$shakhe,null,array('class'=>'form-control')) !!}
        </div>
        {!! Form::label('branch','رشته تحصیلی',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('branch',null,array('class'=>'form-control','placeholder' => 'رشته تحصیلی')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('reshteh','انتخاب گرایش تحصیلی',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::select('reshteh',$reshteh,null,array('class'=>'form-control')) !!}
        </div>
        {!! Form::label('job','انتخاب دسته شغلی',array('class'=>'col-lg-2 control-label')) !!}
        <div class="col-lg-4">
            {!! Form::text('job',null,array('class'=>'form-control','placeholder' => '')) !!}
        </div>
    </div>
</div>



<div class="box-footer">
    <button type="submit" class="btn btn-primary">ذخیره</button>
</div>