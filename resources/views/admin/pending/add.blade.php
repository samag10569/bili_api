@extends ("layouts.admin.master")
@section('title','عضو جدید')
@section('part','عضو جدید')
	@section('content')
		<div class="row">
			<div class="col-md-12">
			  <!-- general form elements -->
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">عضو جدید</h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				@include('layouts.admin.blocks.message')
				{!! Form::open(array('action' => array('Admin\PendingMemberController@postAdd'), 'role' => 'form','id' => 'ejavan_form')) !!}
				  @include('admin.pending.form')
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
		
			$('input[name=interview_type_id]').change(function(){
				if ($( this ).val() == 1) {
					$('.date_interview_box').show();
				}
				else {
					$('.date_interview_box').hide();
				}
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
						date_interview: {
						  required: function(element) {
							if($("input[name='interview_type_id']:checked").val() == 1)
								return true;
							else
								return false;
							}
						},
						time_interview: {
						  required: function(element) {
							if($("input[name='interview_type_id']:checked").val() == 1)
								return true;
							else
								return false;
							}
						},
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
						article_title: "این فیلد الزامی است.",
						invention_title: "این فیلد الزامی است.",
						ideas_title: "این فیلد الزامی است.",
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