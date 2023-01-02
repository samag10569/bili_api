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
							<h4>ثبت نام اولیه در سامانه  - مرحله 2</h4>
						</div>
						<!-- .head -->
						<div class="body">
						@include('layouts.site.blocks.message')
							<div class="profile">
								{!! Form::open(array('action' => array('Site\RegisterController@postStep2'), 'class' => 'form','id' => 'ejavan_form')) !!}
									
									<div class="form-group form-inline">
										<label> استان :</label>
										{!! Form::select('state_id',$state_id,null,array('class'=>'form-control')) !!}
									</div>
									<div class="form-group form-inline">
										<label> آدرس :</label>
										{!! Form::text('city',null,array(
											'class'=>'form-control',
											'placeholder'=>'آدرس را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline">
										<label> کدپستی :</label>
										{!! Form::text('postal_code',null,array(
											'class'=>'form-control',
											'maxlength'=>'10',
											'placeholder'=>'کدپستی را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline">
										<div class="checkbox">
											<label>
												{!!Form::radio('job_status', 1, true)!!}
												شاغل هستم
											</label>
										</div>
										<div class="checkbox">
											<label>
												{!!Form::radio('job_status', 0)!!}
												شاغل نیستم
											</label>
										</div>
		
									</div>
									<div class="form-group form-inline job">
										<label> عنوان شغل :</label>
										{!! Form::text('employment_status',null,array(
											'class'=>'form-control',
											'id'=>'employment_status',
											'placeholder'=>'عنوان شغل را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline job">
										<label>شرکت:</label>
										{!! Form::text('company',null,array(
											'class'=>'form-control',
											'placeholder'=>'شرکت را وارد کنید . . .')) !!}
									</div>
									<div class="form-group form-inline job">
										<label>نوع صنعت :</label>
										{!! Form::text('industry',null,array(
											'class'=>'form-control',
											'placeholder'=>'نوع صنعت را وارد کنید . . .')) !!}
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

@section('js')

    <script type="text/javascript">
	
		$(document).ready(function(){
			
			if($('input[name=job_status]').val() == 1)
				$('.job').show();
			else
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
						state_id: "required",
						city: "required",
						postal_code: "required",
						agree: "required"
					},
					messages: {
						state_id: "این فیلد الزامی است.",
						city: "این فیلد الزامی است.",
						postal_code: "این فیلد الزامی است."
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
	
	
</script>		

@endsection