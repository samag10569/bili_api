@extends('layouts.site.master')
@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="#">ثبت نام</a></li>
				</ul>
			</div>
		</div>
		<!-- /.page-navigator -->
	</div>
</section>
@stop
@section('content')

	<!---------------------------------- CONTENT --------------------------------------->
	<section>
		<div class="container-fluid">
			<div class="row main-content">
				<!----------------------------------- RIGHT SIDE ------------------------------->
				<div class="col-md-12">
					<div class="box hasForm steps">
						<div class="head">
							<h4>ثبت نام اولیه در سامانه  - مرحله 1</h4>
						</div>
						<!-- .head -->
						<div class="body">
						@include('layouts.site.blocks.message')
						<img src="{!! asset('assets/site/images/avatar2.png') !!}" class="pull-left avatar" id="blah" alt="عکس خود را انتخاب کنید">
							<div class="profile">
								{!! Form::open(array('action' => array('Site\RegisterController@postStep1'), 'class' => 'form','id' => 'ejavan_form','files' => 'true')) !!}
									
									<input type="file" name="image" id="imgInp" style="display:none"  accept="image/*"/>
									<div class="form-group form-inline">
										<label> نام :</label>
										{!! Form::text('name',null,array(
											'class'=>'form-control',
											'placeholder'=>'نام را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline">
										<label> نام خانوادگی :</label>
										{!! Form::text('family',null,array(
											'class'=>'form-control',
											'placeholder'=>'نام خانوادگی را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline">
									@php
										if(Session::has('reagent_email'))
											$reagent_email = Session::get('reagent_email');
										else
											$reagent_email = null;
									@endphp
										<label>ایمیل:</label>
										{!! Form::text('email',$reagent_email,array(
											'class'=>'form-control',
											'placeholder'=>'ایمیل را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline">
										<label>شماره همراه :</label>
										{!! Form::text('mobile',null,array(
											'class'=>'form-control',
											'maxlength'=>'11',
											'placeholder'=>'شماره همراه را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline">
										<label>شماره ثابت :</label>
										{!! Form::text('phone',null,array(
											'class'=>'form-control',
											'maxlength'=>'11',
											'placeholder'=>'شماره ثابت را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline">
										<label>رمز عبور انتخابی شما :</label>
										{!! Form::password('password',array(
											'class'=>'form-control',
											'placeholder'=>'رمز عبور را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline">
										<label>تکرار رمز عبور انتخابی شما:</label>
										{!! Form::password('rePassword',array(
											'class'=>'form-control',
											'placeholder'=>'تکرار رمز عبور را وارد کنید . . .')) !!}
									</div>
									<?php /*
									<div class="form-group form-inline">
										<div class="checkbox">
											<label>
												{!!Form::radio('interview_type_id', 0)!!}
												مصاحبه غیر حضوری
											</label>
										</div>
										<div class="checkbox">
											<label>
												{!!Form::radio('interview_type_id', 1, true)!!}
												مصاحبه حضوری
											</label>
										</div>
		
									</div>
									<div class="form-group form-inline date_interview_box">
										<label>تاریخ مصاحبه:</label>
										{!! Form::text('date_interview',null,array(
											'class'=>'form-control',
											'id'=>'date_interview',
											'placeholder'=>'تاریخ مصاحبه را وارد کنید . . .')) !!}
									</div>
									*/ ?>
									<div class="form-group form-inline">
										<label>کد امنیتی :</label>
										<input class="form-control" type="text" placeholder="کد امنیتی" id="captcha" name="captcha" autocomplete="off">
									</div>
									
									<div class="form-group form-inline">
										<label></label>
										<span class="refereshrecapcha">
											{!! \Mews\Captcha\Facades\Captcha::img() !!}
										</span>
										<a href="javascript:void(0)" onclick="refreshCaptcha()"><i class="fa fa-refresh"></i></a>
									</div>
						
									<p>در صورتی که قبلا ثبت نام کردید <a href="{{URL::action('Auth\LoginController@getCrmLogin')}}">اینجا</a> کلیک کنید</p>

									<button type="submit" class="link green link-hover pull-left">ادامه ثبت نام</button>


								{!! Form::close() !!}
							</div>
							<!-- /.profile -->

						</div>
						<!-- .body -->
					</div>
					<!-- .box -->

					<!----------------------------------- RIGHT SIDE ------------------------------->


				</div>
			</div>
	</section>
@endsection


@section('css')
    <link href="{{ asset('assets/admin/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
	<style>
		img.avatar {
			cursor: pointer;
		}
	</style>
@stop


@section('js')

    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.fa.min.js')}}"></script>
	
    <script src="{{ asset('assets/admin/plugins/input-mask/jquery.inputmask.js')}}"></script>

    <script>

        $(document).ready(function(){
			
			/*$('input[name=interview_type_id]').change(function(){
				if ($( this ).val() == 1) {
					$('.date_interview_box').show();
				}
				else {
					$('.date_interview_box').hide();
				}
			});*/
		});

		$("#date_interview").datepicker({
			minDate: 0,
			changeMonth: true,
			changeYear: true
		});
				
		
	(function($,W,D)
	{
		var JQUERY4U = {};

		JQUERY4U.UTIL =
		{
			setupFormValidation: function()
			{
				//form validation rules
				$("#ejavan_form").validate({
					rules: {
						name: "required",
						family: "required",
						mobile: "required",
						phone: "required",
					/*	date_interview: {
						  required: function(element) {
							if($("input[name='interview_type_id']:checked").val() == 1)
								return true;
							else
								return false;
							}
						},
						interview_type_id: "required",*/
						password: "required",
						rePassword: "required",
						email: {
							required: true,
							email: true
						},
						agree: "required"
					},
					messages: {
						name: "این فیلد الزامی است.",
						family: "این فیلد الزامی است.",
						mobile: "این فیلد الزامی است.",
						phone: "این فیلد الزامی است.",
						//date_interview: "این فیلد الزامی است.",
						//interview_type_id: "این فیلد الزامی است.",
						password: "این فیلد الزامی است.",
						rePassword: "این فیلد الزامی است.",
						email: "لطفا یک آدرس ایمیل معتبر وارد کنید."
					},
					submitHandler: function(form) {
						form.submit();
					}
				});
			}
		}

		//when the dom has loaded setup form validation rules
		$(D).ready(function($) {
			JQUERY4U.UTIL.setupFormValidation();
		});

	})(jQuery, window, document);
	
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#blah').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#imgInp").change(function(){
		readURL(this);
	});

	$('#blah').click(function(){ $('#imgInp').trigger('click'); });
	
</script>		

@endsection