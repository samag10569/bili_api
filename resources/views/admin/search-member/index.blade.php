@extends ("layouts.admin.master")
@section('title','جستجو پیشرفته')
@section('part','جستجو پیشرفته')
@section('content')
	<div class="row">
		@include('layouts.admin.blocks.message')
		<div class="col-xs-12">
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title"></h3>
			  {!! Form::open(array('action' => array('Admin\SearchMemberController@getResualt'),'class' => 'form-horizontal','method' => 'GET')) !!}
				  <div class="box-body">
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
							{!! Form::select('city',$city,null,array('class'=>'form-control','placeholder' => '')) !!}
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
							{!! Form::select('branch',$branch_id,null,array('class'=>'form-control','placeholder' => 'رشته تحصیلی')) !!}
						</div>
					</div>

					  <div class="form-group">
						  {!! Form::label('reshteh','انتخاب گرایش تحصیلی',array('class'=>'col-lg-2 control-label')) !!}
						  <div class="col-lg-4">
							  {!! Form::select('reshteh',$reshteh,null,array('class'=>'form-control')) !!}
						  </div>
						  {!! Form::label('job','انتخاب دسته شغلی',array('class'=>'col-lg-2 control-label')) !!}
						  <div class="col-lg-4">
							  {!! Form::select('job',$dasteh,null,array('class'=>'form-control','placeholder' => '')) !!}
						  </div>
					  </div>
				  </div>
				  
				  <div class="box-footer">
					<button type="submit" class="btn btn-primary">جستجو</button>
				  </div>
			  
			  
				{!! Form::close() !!}
			</div><!-- /.box-header -->
		  </div><!-- /.box -->
		</div>
	  </div>

@stop

@section('css')
    <link href="{{ asset('assets/admin/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/admin/css/bootstrap-select.min.css')}}" rel="stylesheet">
@stop

	
@section('js')
	<script src="{{ asset('assets/admin/js/bootstrap-select.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.fa.min.js')}}"></script>

    <script src="{{ asset('assets/admin/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			$(".date").datepicker({
				changeMonth: true,
				changeYear: true,
				isRTL: true
			});
			
			$('.job').hide();  
			
			$('input[name=job_status]').change(function(){
				if ($( this ).val() == 1) {
					$('.job').show();
				}
				else {
					$('.job').hide();
				}
			});
			
		});
		
		$('.article_title').hide();
			$('#article').change(function() {
				if(this.checked) {
					$('.article_title').show();
				}else{
					$('.article_title').hide();
				} 
			});
		
			$('.invention_title').hide();
			$('#invention').change(function() {
				if(this.checked) {
					$('.invention_title').show();
				}else{
					$('.invention_title').hide();
				} 
			});
		
			$('.ideas_title').hide();
			$('#ideas').change(function() {
				if(this.checked) {
					$('.ideas_title').show();
				}else{
					$('.ideas_title').hide();
				} 
			});
		
		
			$('.expertise').hide();
			$('#expertise').change(function() {
				if(this.checked) {
					$('.expertise').show();
				}else{
					$('.expertise').hide();
				} 
			});
				
		  $(function () {
			$("[data-mask]").inputmask();
		  });
	
    </script>

@stop