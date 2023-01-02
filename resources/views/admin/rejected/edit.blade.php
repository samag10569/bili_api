@extends ("layouts.admin.master")
@section('title','ویرایش اعضا رایگان')
@section('part','ویرایش اعضا رایگان')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> ویرایش اعضا رایگان</h3>
					<h3 class="box-title" style="float: left;">	
						<button class="btn btn-block bg-olive btn-lg">{{$data->user_code}}</button>
					  </h3>
					  
			@if(Auth::user()->hasPermission('search-member.signIn'))
			  <h3 class="box-title" style="float: left;padding-left: 10px;">	
					<a href="{{URL::action('Admin\SearchMemberController@getSignIn',[$data->id])}}" data-toggle="tooltip"
					   data-original-title="ورود به پنل کاربر" class="btn btn-block bg-info btn-lg"><i
								class="fa fa-sign-in"></i> ورود به پنل کاربر </a>
			  </h3>
			@endif
			  
			@if(Auth::user()->hasPermission('search-member.changePassword'))
			  <h3 class="box-title" style="float: left;padding-left: 10px;">	
					<a target="_blank" href="{{URL::action('Admin\SearchMemberController@getChangePassword',[$data->id])}}" data-toggle="tooltip"
					   data-original-title="تغییر رمز" class="btn btn-block bg-danger btn-lg"><i
								class="fa fa-lock"></i> تغییر رمز </a>
			  </h3>
			@endif
                </div><!-- /.box-header -->
                <!-- form start -->
                @include('layouts.admin.blocks.message')
                {!! Form::model($data,array('action' => array('Admin\RejectedController@postEdit',$data->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
                @include('admin.rejected.form')
                {!! Form::close() !!}
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

			$("#birth").datepicker({
				changeMonth: true,
				changeYear: true,
				isRTL: true
			});
			$("#date_interview").datepicker({
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
			
			
			$('.loading').hide();
			$('.msgno').hide();
			$('.msgok').hide();
			$('#reason_rejection').hide();
			
			$('input[type="radio"]').click(function () {
				if ($(this).attr('id') == 'rejection') {
					$('#reason_rejection').show();
				}
				else {
					$('#reason_rejection').hide();
				}
			});
		
		});
		
		function deleteContent(x,id) {
			$('#loading'+id).show();
			$('#delete_content'+id).hide();
			$.ajax({
				url: x,
				success: function (x) {
					$('#loading'+id).hide();
						var data = JSON.parse(x);
						$('.msg'+data.status).show();
						$("#msg"+data.status).html(data.msg);
						if(data.status == 'ok'){
							$('#content'+id).hide();
						}else{
							$('#delete_content'+id).show();
						}
				},
				error: function(error_thrown){
					$('#loading'+id).hide();
					$('#delete_content'+id).show();
					$('.msgno').show();
					$("#msgno").html('دسترسی شما محدود می باشد.');
				}
			});
		}
		
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
						//father_name: "required",
						//birth: "required",
						mobile: "required",
						//national_id: "required",
						//date_interview: "required",
						//time_interview: "required",
						//branch_id: "required",
						//category_id: "required",
						//state_id: "required",
						//postal_code: "required",
						//city: "required",
						//branch: "required",
						email: {
							required: true,
							email: true
						},
						agree: "required"
					},
					messages: {
						name: "این فیلد الزامی است.",
						family: "این فیلد الزامی است.",
						father_name: "این فیلد الزامی است.",
						birth: "این فیلد الزامی است.",
						mobile: "این فیلد الزامی است.",
						national_id: "این فیلد الزامی است.",
						date_interview: "این فیلد الزامی است.",
						time_interview: "این فیلد الزامی است.",
						branch_id: "این فیلد الزامی است.",
						category_id: "این فیلد الزامی است.",
						state_id: "این فیلد الزامی است.",
						postal_code: "این فیلد الزامی است.",
						city: "این فیلد الزامی است.",
						branch: "این فیلد الزامی است.",
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

	
      $(function () {
        $("[data-mask]").inputmask();
      });
    </script>
@endsection