@extends ("layouts.admin.master")
@section('title','ویرایش اعضا ')
@section('part','ویرایش اعضا ')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> ویرایش اعضا </h3>
					<h3 class="box-title" style="float: left;">	
						<button class="btn btn-block bg-olive btn-lg">{{$data->user_code}}</button>
					  </h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                @include('layouts.admin.blocks.message')
                {!! Form::model($data,array('action' => array('Admin\OrdersController@postEdit',$data->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
                @include('admin.orders.form')
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
						father_name: "required",
						birth: "required",
						mobile: "required",
						national_id: "required",
						date_interview: "required",
						time_interview: "required",
						branch_id: "required",
						category_id: "required",
						state_id: "required",
						postal_code: "required",
						city: "required",
						branch: "required",
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