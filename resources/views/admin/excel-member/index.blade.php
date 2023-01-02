@extends ("layouts.admin.master")
@section('title','خروجی اکسل')
@section('part','خروجی اکسل')
@section('content')
	<div class="row">
		@include('layouts.admin.blocks.message')
		<div class="col-xs-12">
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title"></h3>
			  {!! Form::open(array('action' => array('Admin\ExcelMemberController@getResualt'),'class' => 'form-horizontal','method' => 'GET')) !!}
				  <div class="box-body">
					<div class="form-group">
						{!! Form::label('start_interview','تاریخ مصاحبه از',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('start_interview',null,array('class'=>'form-control date','placeholder' => 'ازتاریخ')) !!}
						</div>
						{!! Form::label('end_interview','تاریخ مصاحبه تا',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('end_interview',null,array('class'=>'form-control date','placeholder' => 'تا تاریخ')) !!}
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
						{!! Form::label('name','نام',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('name',null,array('class'=>'form-control','placeholder' => 'نام')) !!}
						</div>
						{!! Form::label('family','نام خانوادگی',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('family',null,array('class'=>'form-control','placeholder' => 'نام خانوادگی')) !!}
						</div>
					</div>
					
					<div class="form-group">
						{!! Form::label('user_code','کد شناسه کاربری',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('user_code',null,array('class'=>'form-control','placeholder' => 'کد شناسه کاربری')) !!}
						</div>
						{!! Form::label('id','کد یکتا',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('id',null,array('class'=>'form-control','placeholder' => 'کد یکتا')) !!}
						</div>
					</div>
				
					<div class="form-group">
						{!! Form::label('email','ایمیل',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('email',null,array('class'=>'form-control','placeholder' => 'ایمیل')) !!}
						</div>
						{!! Form::label('mobile','شماره همراه',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('mobile',null,array('class'=>'form-control','placeholder' => 'شماره همراه')) !!}
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
						{!! Form::label('credibility_id','اعتبار طرح و ایده',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
						   {!! Form::select('credibility_id',$credibility_id,null,array('class'=>'form-control')) !!}
						</div>
						{!! Form::label('degree_id','درجه علمی',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
						   {!! Form::select('degree_id',$degree_id,null,array('class'=>'form-control')) !!}
						</div>
					</div>
					
					<div class="form-group">
						{!! Form::label('interview_type_id','نوع مصاحبه',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
						   {!! Form::select('interview_type_id',$interview_type_id,null,array('class'=>'form-control')) !!}
						</div>
						{!! Form::label('core_scientific','عضویت هسته علمی',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
						   {!! Form::select('core_scientific',$core_scientific,null,array('class'=>'form-control')) !!}
						</div>
					</div>
				
					<div class="form-group">
						{!! Form::label('state_id','استان',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
						   {!! Form::select('state_id',$state_id,null,array('class'=>'form-control')) !!}
						</div>
						{!! Form::label('category_id','مدیر ثبت کننده',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
						   {!! Form::select('category_id',$category_id,null,array('class'=>'form-control')) !!}
						</div>
					</div>
					
					<div class="form-group">
						{!! Form::label('employment_status','وضعیت شغلی',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('employment_status',null,array('class'=>'form-control','placeholder' => 'وضعیت شغلی')) !!}
						</div>
						{!! Form::label('project_required','پروژه موظفی',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('project_required',null,array('class'=>'form-control','placeholder' => 'پروژه موظفی')) !!}
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-lg-2">
							</div>
							
							<div class="col-lg-2">
								{!!Form::checkbox('article', 1)!!}
								&nbsp;
								<label>مقاله دارد</label>
							</div>
							<div class="col-lg-2">
								{!!Form::checkbox('expertise', 1)!!}
								&nbsp;
								<label>تخصص دارد </label>
							</div>
							
							
							<div class="col-lg-2">
							</div>
							
							<div class="col-lg-2">
								{!!Form::checkbox('ideas', 1)!!}
								&nbsp;
								<label>ایده دارد </label>
							</div>
							<div class="col-lg-2">
								{!!Form::checkbox('invention', 1)!!}
								&nbsp;
								<label>ثبت اختراع دارد </label>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						{!! Form::label('article_title','عنوان مقاله',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('article_title',null,array('class'=>'form-control','placeholder' => 'عنوان مقاله')) !!}
						</div>
						{!! Form::label('ideas_title','عنوان ایده',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('ideas_title',null,array('class'=>'form-control','placeholder' => 'عنوان ایده')) !!}
						</div>
					</div>
					
					<div class="form-group">
						{!! Form::label('expertise_title','عنوان تخصص',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('expertise_title',null,array('class'=>'form-control','placeholder' => 'عنوان تخصص')) !!}
						</div>
						{!! Form::label('invention_title','عنوان اختراع',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
							{!! Form::text('invention_title',null,array('class'=>'form-control','placeholder' => 'عنوان اختراع')) !!}
						</div>
					</div>
					
					<div class="form-group">
						{!! Form::label('content','جستجو در توضیحات اضافه',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-10">
							{!! Form::text('content',null,array('class'=>'form-control','placeholder' => 'جستجو در توضیحات اضافه')) !!}
						</div>
					</div>
					
					<div class="form-group">
						{!! Form::label('content','وضعیت',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-md-4">
								
								{!!Form::checkbox('status_id_1', 1)!!}
								<label>در انتظار بررسی کارشناس جهت مصاحبه</label>
								</br>
								
								{!!Form::checkbox('status_id_2',2)!!}
								<label>  اعضای تایید شده جهت مصاحبه (تعیین گرید)</label>
								</br>
								
								{!!Form::checkbox('status_id_3',3)!!}
								<label>  تایید جهت تخصیص خدمت</label>
								</br>
								
								{!!Form::checkbox('status_id_4',4)!!}
								<label>  تایید اولیه</label>
								</br>
								
								{!!Form::checkbox('status_id_5',5)!!}
								<label>  تایید نهایی</label>
								</br>
								
								{!!Form::checkbox('rejection',1)!!}
								<label> رد هرگونه عضویت در کانون رشد نخبگان جوان</label>
								</br>
								
							</div>
						{!! Form::label('sort','مرتب سازی',array('class'=>'col-lg-2 control-label')) !!}
						<div class="col-lg-4">
						   {!! Form::select('sort',$sort,null,array('class'=>'form-control')) !!}
						</div>
					</div>
				  </div>
				  
				  <div class="box-footer">
					<button type="submit" class="btn btn-primary">دریافت خروجی اکسل</button>
				  </div>
			  
			  
				{!! Form::close() !!}
			</div><!-- /.box-header -->
		  </div><!-- /.box -->
		</div>
	  </div>

@stop

@section('css')
    <link href="{{ asset('assets/admin/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@stop


@section('js')

    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.fa.min.js')}}"></script>

    <script type="text/javascript">
	$(document).ready(function(){
        $(".date").datepicker({
            changeMonth: true,
            changeYear: true,
            isRTL: true
        });
	});
	
    </script>

@stop