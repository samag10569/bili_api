@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">ویرایش پروفایل {{$data->name.' '.$data->family}}</a></li>
				</ul>
			</div>
		</div>
		<!-- /.page-navigator -->
	</div>
</section>
@stop

@section('content')


	<!----------------------------------- RIGHT SIDE ------------------------------->
		
	<div class="col-md-8">
		@include('layouts.site.blocks.help')
		
		<div class="box hasForm" style="margin-top:20px;">
			<div class="head">
				<h4>اطلاعات عمومی کاربری</h4>

			</div><!-- .head -->
			<div class="body">
				{!! Form::model($data,array('action' => array('Crm\ProfileController@postEdit'),'role' => 'form','files' => 'true','id' => 'ejavan_form2')) !!}

					<div class="profile">
						<div class="form-group form-inline">
								<label > نام :</label>
								{!! Form::text('name',null,array(
											'class'=>'form-control',
											'placeholder'=>'نام را وارد کنید . . .')) !!}
							</div>
							<div class="form-group form-inline">
								<label > نام خانوادگی :</label>
								{!! Form::text('family',null,array(
											'class'=>'form-control',
											'placeholder'=>'نام خانوادگی را وارد کنید . . .')) !!}
							</div>
							
						<div class="form-group form-inline">
								<div class="row">
									<div class="col-md-4">
										<label > تصویر :</label>
											{!! Form::file('image',array()) !!}
											
									</div>
									
									<div class="col-md-4">
										 @if(file_exists('assets/uploads/user/medium/'.$data->image))
											<img src="{!! asset('assets/uploads/user/medium/'.$data->image) !!}" 
												class="img-rounded"
												style="width: 110px; height: 100px;">
										@else
											<img src="{!! asset('assets/site/images/avatar.png') !!}" 
												class="img-rounded"
												style="width: 110px; height: 100px;">
										@endif
									</div>
									
									<div class="col-md-4">
									
									</div>
								</div>
							</div>
					
							<div class="form-group form-inline">
								<label>نام پدر:</label>
								{!! Form::text('father_name',@$info_data->father_name,array(
									'class'=>'form-control',
									'placeholder'=>'نام پدر را وارد کنید . . .')) !!}
							</div>
							<div class="form-group form-inline">
								<label > تاریخ تولد :</label>
								{!! Form::text('birth',jdate('d/m/Y',@$info_data->birth,'','','en'),array(
											'class'=>'form-control',
											'id'=>'birth',
											'placeholder'=>'تاریخ تولد را وارد کنید . . .')) !!}
							</div>
							<div class="form-group form-inline">
								<label > کد ملی :</label>
								{!! Form::text('national_id',@$info_data->national_id,array(
											'class'=>'form-control',
											'maxlength'=>'10',
											'placeholder'=>'کد ملی را وارد کنید . . .')) !!}
							</div>
							<div class="form-group form-inline">
								<label > شماره همراه :</label>
								{!! Form::text('mobile',null,array(
											'class'=>'form-control',
											'placeholder'=>'شماره همراه را وارد کنید . . .')) !!}
							</div>
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
							
							<span class="loading" id="loading" style="margin-right: 15%;">
								در حال بررسی اطلاعات <img src="{{ asset('assets/admin/img/loading.gif')}}" width="30" height="30"/>
							</span>
							
							<div class="form-group form-inline">
								<label > ایمیل :</label>
								{!! Form::text('email',null,array(
											'class'=>'form-control',
											'disabled'=>'',
											'placeholder'=>'ایمیل را وارد کنید . . .')) !!}
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
							<div class="form-group form-inline">
								<label> استان :</label>
								{!! Form::select('state_id',$state_id,@$info_data->state_id,array('class'=>'form-control')) !!}
							</div>
							<div class="form-group form-inline">
								<label> آدرس :</label>
								{!! Form::text('city',@$info_data->city,array(
									'class'=>'form-control',
									'style'=>"width: 80%;",
									'placeholder'=>'آدرس را وارد کنید . . .')) !!}
							</div>
							<div class="form-group form-inline">
								<label> کدپستی :</label>
								{!! Form::text('postal_code',@$info_data->postal_code,array(
									'class'=>'form-control',
									'maxlength'=>'10',
									'placeholder'=>'کدپستی را وارد کنید . . .')) !!}
							</div>

					</div><!-- /.profile -->
					<button class="link green link-hover pull-left" type="submit"> ذخیره تغییرات</button>
				{!! Form::close() !!}

			</div><!-- .body -->
		</div><!-- .box -->
		</br>
		<div class="box hasForm">
			<div class="head">
				<h4>اطلاعات کاربر</h4>

			</div><!-- .head -->
			<div class="body">
				{!! Form::model($data,array('action' => array('Crm\ProfileController@postPro'),'role' => 'form','id' => 'ejavan_form')) !!}

				<div class="profile">
						<div class="form-group form-inline">
							<label for="email">شاخه تصیلی :</label>
							{!! Form::select('category_id',$category_id,null,array('class'=>'form-control')) !!}
						</div>
						<div class="form-group form-inline">
							<label for="email">مقطع تحصیلی :</label>
							{!! Form::select('branch_id',$branch_id,null,array('class'=>'form-control')) !!}
						</div>
						<div class="form-group form-inline">
							<label >رشته تحصیلی :</label>
							{!! Form::text('branch',@$info_data->branch,array(
									'class'=>'form-control',
									'placeholder'=>'رشته تحصیلی را وارد کنید . . .')) !!}
						</div>
						@php
							$article = false;
							$invention = false;
							$ideas = false;
							$expertise = false;
							if(@$info_data->article) $article = true;
							if(@$info_data->invention) $invention = true;
							if(@$info_data->ideas) $ideas = true;
							if(@$info_data->expertise) $expertise = true;
						@endphp
						<div class="form-group form-inline">
							<label for="email"> دستاورد های شما :</label>
							<div class="checkbox">
								<label>{!!Form::checkbox('article', 1, $article , ['id'=>'article'])!!} مقاله دارم </label>
							</div>
							<div class="checkbox">
								<label>{!!Form::checkbox('invention', 1,$invention, ['id'=>'invention'])!!} ثبت اختراع </label>
							</div>
							<div class="checkbox">
								<label>{!!Form::checkbox('ideas', 1,$ideas, ['id'=>'ideas'])!!} ایده دارم </label>
							</div>
							<div class="checkbox">
								<label>{!!Form::checkbox('expertise', 1,$expertise, ['id'=>'expertise'])!!} تخصص دارم </label>
							</div>
						</div>

						<div id="input-wrap" class="article_title">
							<div class="form-group form-inline">
								<label>عنوان مقاله شما : </label>
								{!! Form::text('article_title',@$info_data->article_title,array(
									'class'=>'form-control',
									'placeholder'=>'عنوان مقاله را وارد کنید . . .')) !!}
							</div>
						</div><!-- /#input-wrap1-->
						<div id="input-wrap2" class="invention_title">
							<div class="form-group form-inline ">
								<label>عنوان ثبت اختراع : </label>
								{!! Form::text('invention_title',@$info_data->invention_title,array(
									'class'=>'form-control',
									'placeholder'=>'عنوان اختراع را وارد کنید . . .')) !!}
							</div>
						</div><!-- /#input-wrap2-->
						<div id="input-wrap3" class="ideas_title">
							<div class="form-group form-inline ">
								<label>عنوان ایده : </label>
								{!! Form::text('ideas_title',@$info_data->ideas_title,array(
									'class'=>'form-control',
									'placeholder'=>'عنوان ایده را وارد کنید . . .')) !!}
							</div>
						</div><!-- /#input-wrap3-->
						<div class="form-group form-inline">
							<p></p>
						</div>
						{{--<div class="form-group form-inline">--}}
							{{--<label >مهارت ها :</label>--}}
							{{--<select id="tags" name="skills[]" multiple="multiple" class="tags">--}}
								{{--@foreach($skills as $item)--}}
									{{--<option value="{{$item->id}}" @if(in_array($item->id, $skillId)) selected @endif>{{$item->title}}</option>--}}
								{{--@endforeach--}}
							{{--</select>--}}
						{{--</div>--}}
						{{----}}
						{{--<div class="form-group form-inline">--}}
							{{--<label >مهارت ها :</label>--}}
							 {{--<select name="skills[]"  data-placeholder="مهارت های خود را انتخاب نمایید . . " class="chosen-select" multiple tabindex="4">--}}
								{{--@foreach($skills as $item)--}}
									{{--<option value="{{$item->id}}" @if(in_array($item->id, $skillId)) selected @endif>{{$item->title}}</option>--}}
								{{--@endforeach--}}
							{{--</select>--}}
						{{--</div>--}}

						<div class="form-group form-inline expertise">
							<label >مهارت ها :</label>
							 <select name="skills[]" class="selectpicker form-control" multiple>
								@foreach($skills as $item)
									<option value="{{$item->id}}" @if(in_array($item->id, $skillId)) selected @endif>{{$item->title}}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group ">
							<label> رزومه علمی :</label>
							{!! Form::textarea('cv',null,array(
									'class'=>'form-control ckeditor',
									'placeholder'=>'رزومه را وارد کنید . . .')) !!}

						</div>
						
						@php
							$job_status1 = null;
							$job_status0 = null;
							if(@$info_data->job_status == 1)
								$job_status1 = true;
							else
								$job_status0 = true;
						@endphp
							
						<div class="form-group form-inline">
							<div class="checkbox">
								<label>
									{!!Form::radio('job_status', 1, $job_status1)!!}
									شاغل هستم
								</label>
							</div>
							<div class="checkbox">
								<label>
									{!!Form::radio('job_status', 0, $job_status0)!!}
									شاغل نیستم
								</label>
							</div>

						</div>
						<div class="form-group form-inline job">
							<label> عنوان شغل :</label>
							{!! Form::text('employment_status',@$info_data->employment_status,array(
								'class'=>'form-control',
								'id'=>'employment_status',
								'placeholder'=>'عنوان شغل را وارد کنید . . .')) !!}
						</div>
						<div class="form-group form-inline job">
							<label>شرکت:</label>
							{!! Form::text('company',@$info_data->company,array(
								'class'=>'form-control',
								'placeholder'=>'شرکت را وارد کنید . . .')) !!}
						</div>
						<div class="form-group form-inline job">
							<label>نوع صنعت :</label>
							{!! Form::text('industry',@$info_data->industry,array(
								'class'=>'form-control',
								'placeholder'=>'نوع صنعت را وارد کنید . . .')) !!}
						</div>
				</div><!-- /.profile -->


				<button class="link green link-hover pull-left"  type="submit"> ذخیره تغییرات</button>
				{!! Form::close() !!}

			</div><!-- .body -->
		</div><!-- .box -->
		
		<div class="box hasForm" style="margin-top:20px;">
			<div class="head">
				<h4>تغییر رمز عبور  </h4>

			</div><!-- .head -->
			<div class="body">
				{!! Form::model($data,array('action' => array('Crm\ProfileController@postPass'),'role' => 'form','id' => 'ejavan_form3')) !!}
					<div class="profile">
							<div class="form-group form-inline">
								<label > رمز عبور فعلی :</label>
								<input type="password" name="old_password" class="form-control"  placeholder="رمز عبور فعلی">
							</div>
							<div class="form-group form-inline">
								<label > رمز عبور جدید :</label>
								<input type="password" name="password" class="form-control"  placeholder="رمز عبور جدید">
							</div>
							<div class="form-group form-inline">
								<label > تکرار رمز عبور جدید :</label>
								<input type="password" name="password_confirmation" class="form-control"  placeholder="تکرار رمز عبور جدید">
							</div>

					</div><!-- /.profile -->
					<button class="link green link-hover pull-left"  type="submit"> ذخیره تغییرات</button>
				{!! Form::close() !!}
			</div><!-- .body -->
		</div><!-- .box -->

	</div>
	@include('layouts.crm.blocks.sidebar')

@endsection

@section('css')
    <link href="{{ asset('assets/admin/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/prism.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/chosen.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/admin/css/bootstrap-select.min.css')}}" rel="stylesheet">
@stop

	
@section('js')
	<script src="{{ asset('assets/admin/js/bootstrap-select.min.js')}}"></script>

    <script src="{{ asset('assets/admin/js/chosen.jquery.js')}}"></script>
    <script src="{{ asset('assets/admin/js/prism.js')}}"></script>
    <script src="{{ asset('assets/admin/js/init.js')}}"></script>
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
			
			@if($info_data->job_status == 1)
				$('.job').show();
			@else
				$('.job').hide();
			@endif
			
			$('input[name=job_status]').change(function(){
				if ($( this ).val() == 1) {
					$('.job').show();
				}
				else {
					$('.job').hide();
				}
			});
			
			@if(!$info_data->invention)
				$('.invention_title').hide();
			@endif
			
			$('#invention').change(function() {
				if(this.checked) {
					$('.invention_title').show();
				}else{
					$('.invention_title').hide();
				} 
			});
		
			@if(!$info_data->ideas)
				$('.ideas_title').hide();
			@endif
			
			$('#ideas').change(function() {
				if(this.checked) {
					$('.ideas_title').show();
				}else{
					$('.ideas_title').hide();
				} 
			});
			
			
			@if(!$info_data->article)
				$('.article_title').hide();
			@endif
			
			$('#article').change(function() {
				if(this.checked) {
					$('.article_title').show();
				}else{
					$('.article_title').hide();
				} 
			});
				
		 
			@if(!$info_data->expertise)
				$('.expertise').hide();
			@endif
			
			$('#expertise').change(function() {
				if(this.checked) {
					$('.expertise').show();
				}else{
					$('.expertise').hide();
				} 
			});
			
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
                            category_id: "required",
							branch_id: "required",
							branch: "required",
							agree: "required"
                        },
                        messages: {
                            category_id: "این فیلد الزامی است.",
							branch_id: "این فیلد الزامی است.",
							branch: "این فیلد الزامی است."
                        },
                        submitHandler: function(form) {
                            form.submit();
                        }
                    });
                    $("#ejavan_form2").validate({
                        rules: {
                            name: "required",
							family: "required",
							mobile: "required",
							phone: "required",
							state_id: "required",
							city: "required",
							postal_code: "required",
							agree: "required"
                        },
                        messages: {
                            name: "این فیلد الزامی است.",
							family: "این فیلد الزامی است.",
							mobile: "این فیلد الزامی است.",
							state_id: "این فیلد الزامی است.",
							city: "این فیلد الزامی است.",
							postal_code: "این فیلد الزامی است.",
							phone: "این فیلد الزامی است."
                        },
                        submitHandler: function(form) {
                            form.submit();
                        }
                    });
                    $("#ejavan_form3").validate({
                        rules: {
                            old_password: "required",
                            password: "required",
							password_confirmation: "required",
							agree: "required"
                        },
                        messages: {
							old_password: "این فیلد الزامی است.",
							password: "این فیلد الزامی است.",
							password_confirmation: "این فیلد الزامی است."
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

