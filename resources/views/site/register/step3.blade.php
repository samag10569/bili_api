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
							<h4>ثبت نام اولیه در سامانه  - مرحله 3</h4>
						</div>
						<!-- .head -->
						<div class="body">
						@include('layouts.site.blocks.message')
							<div class="profile">
									<span class="loading" id="loading" style="margin-right: 15%;">
										در حال بررسی اطلاعات <img src="{{ asset('assets/admin/img/loading.gif')}}" width="30" height="30"/>
									</span>
								{!! Form::open(array('action' => array('Site\RegisterController@postStep3'), 'class' => 'form','id' => 'ejavan_form')) !!}
									
									<div class="form-group form-inline">
										<label> تاییدیه شماره همراه :</label>
										<input class="form-control" placeholder="کد ارسالی به شماره همراه" type="text" id="mobile_confirm_code" name="mobile_confirm_code">
										@if(!Auth::user()->phone_confirm)
											<a style="cursor:pointer" onclick="confirm('mobile')" class="link blue link-hover mobile">تایید شماره همراه</a>
											<a class="link green link-hover" id="mobile">شماره شما تایید شد</a>
										@else
											<a class="link green link-hover">شماره شما تایید شد</a>
										@endif
									</div>
									<div class="form-group form-inline">
										<label> تاییدیه ایمیل :</label>
										<input class="form-control" placeholder="کد ارسالی به ایمیل " type="text" id="email_confirm_code" name="email_confirm_code">
										@if(!Auth::user()->email_confirm)
											<a style="cursor:pointer"  onclick="confirm('email')" class="link blue link-hover email">تایید ایمیل</a>
											<a class="link green link-hover" id="email">ایمیل شما تایید شد</a>
										@else
											<a class="link green link-hover">ایمیل شما تایید شد</a>
										@endif
										
									</div>
									
									
									
									<h3>اطلاعات تکمیلی </h3>
									<hr>
									
									<div class="form-group form-inline">
										<label> نام پدر :</label>
										{!! Form::text('father_name',null,array(
											'class'=>'form-control',
											'placeholder'=>'نام پدر را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline">
										<label> تاریخ تولد :</label>
										{!! Form::text('birth',null,array(
											'class'=>'form-control',
											'id'=>'birth',
											'placeholder'=>'تاریخ تولد را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline">
										<label>کد ملی:</label>
										{!! Form::text('national_id',null,array(
											'class'=>'form-control',
											'maxlength'=>'10',
											'placeholder'=>'کد ملی را وارد کنید . . .')) !!}
									</div>
									
									<div class="form-group form-inline">
										<label> شاخه تحصیلی :</label>
										{!! Form::select('category_id',$category_id,null,array('class'=>'form-control')) !!}
									</div>
									
									<div class="form-group form-inline">
										<label> مقطع تحصیلی :</label>
										{!! Form::select('branch_id',$branch_id,null,array('class'=>'form-control')) !!}
									</div>
									
									<div class="form-group form-inline">
										<label>رشته تحصیلی :</label>
										{!! Form::text('branch',null,array(
											'class'=>'form-control',
											'placeholder'=>'رشته تحصیلی را وارد کنید . . .')) !!}
									</div>
									
									<div class="form-group form-inline">
										<div class="checkbox">
											{!!Form::checkbox('article', 1, null, ['id'=>'article'])!!}
												&nbsp;
											<label>مقاله دارد</label>
										</div>
										<div class="checkbox">
											{!!Form::checkbox('expertise', 1, null, ['id'=>'expertise'])!!}
												&nbsp;
											<label>تخصص دارد</label>
										</div>
										<div class="checkbox">
											{!!Form::checkbox('ideas', 1, null, ['id'=>'ideas'])!!}
												&nbsp;
											<label>ایده دارد</label>
										</div>
										<div class="checkbox">
											{!!Form::checkbox('invention', 1, null, ['id'=>'invention'])!!}
												&nbsp;
											<label>ثبت اختراع دارد</label>
										</div>
									</div>
									
									<div class="form-group form-inline article_title">
										<label> عنوان مقاله :</label>
										{!! Form::text('article_title',null,array(
											'class'=>'form-control',
											'placeholder'=>' عنوان مقاله را وارد کنید . . .')) !!}
									</div>
									
									<div class="form-group form-inline ideas_title">
										<label> عنوان ایده :</label>
										{!! Form::text('ideas_title',null,array(
											'class'=>'form-control',
											'placeholder'=>' عنوان ایده را وارد کنید . . .')) !!}
									</div>
									
									<div class="form-group form-inline invention_title">
										<label> عنوان اختراع :</label>
										{!! Form::text('invention_title',null,array(
											'class'=>'form-control',
											'placeholder'=>' عنوان اختراع را وارد کنید . . .')) !!}
									</div>
									
									<div class="form-group form-inline expertise">
										<label >مهارت ها :</label>
										<select id="tags" name="skills[]" multiple="multiple" class="tags">
											@foreach($skills as $item)
												<option value="{{$item->id}}" @if(in_array($item->id, $skillId)) selected @endif>{{$item->title}}</option>
											@endforeach
										</select>
									</div>
									
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
@stop


@section('js')

    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.fa.min.js')}}"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){

			$("#birth").datepicker({
				maxDate: 0,
				changeMonth: true,
				changeYear: true,
				isRTL: true
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
		
	 
		});
	
		$('.expertise').hide();
		$('#expertise').change(function() {
			if(this.checked) {
				$('.expertise').show();
			}else{
				$('.expertise').hide();
			} 
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
						father_name: "required",
						birth: "required",
						national_id: "required",
						category_id: "required",
						branch_id: "required",
						branch: "required",
						article_title: {
						  required: function(element) {
							  return $("#article").is(":checked");
							}
						},
						invention_title: {
						  required: function(element) {
							  return $("#invention").is(":checked");
							}
						},
						ideas_title: {
						  required: function(element) {
							  return $("#ideas").is(":checked");
							}
						},
						agree: "required"
					},
					messages: {
						father_name: "این فیلد الزامی است.",
						birth: "این فیلد الزامی است.",
						national_id: "این فیلد الزامی است.",
						category_id: "این فیلد الزامی است.",
						branch_id: "این فیلد الزامی است.",
						article_title: "این فیلد الزامی است.",
						invention_title: "این فیلد الزامی است.",
						ideas_title: "این فیلد الزامی است.",
						branch: "این فیلد الزامی است."
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
	
	$('#loading').hide();
	$('#mobile').hide();
	$('#email').hide();
	function confirm(type) {
		$('#loading').show();
		$('.' + type).hide();
		if(type == "mobile")
			confirm_code = $('#mobile_confirm_code').val();
		else
			confirm_code = $('#email_confirm_code').val();
		
		
		$.ajax({
			url: "{{URL::action('Site\RegisterController@postConfirm')}}",
			method: 'post',
			data: {
				_token: "{{ csrf_token() }}",
				type: type,
				confirm_code: confirm_code
			},
			success: function (x) {
				$('#loading').hide();
				var data = JSON.parse(x);
				if(data.status == 'ok'){
					$('#' + data.type).show();
				}else{
					$('.' + data.type).show();
				}
			}
		});
					
	}
	
</script>		

@endsection