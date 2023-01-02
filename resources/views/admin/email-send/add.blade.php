@extends ("layouts.admin.master")
@section('title','ارسال ایمیل به کاربران')
@section('part','ارسال ایمیل به کاربران')
	@section('content')
		<div class="row">
			<div class="col-md-12">
			  <!-- general form elements -->
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">جدید</h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				@include('layouts.admin.blocks.message')
				{!! Form::open(array('action' => array('Admin\EmailSendController@postAdd'), 'role' => 'form','files' => 'true','id' => 'ejavan_form','class' => 'form-horizontal')) !!}
				  @include('admin.email-send.form')
				{!! Form::close() !!}
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

    <script>

        $(".date").datepicker({
            changeMonth: true,
            changeYear: true,
            isRTL: true
        });

    <script>
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
						count: "required",
						content: "required",
						subject: "required",
						sender: {
							required: true,
							email: true
						},
						agree: "required"
					},
					messages: {
						count: "این فیلد الزامی است.",
						subject: "این فیلد الزامی است.",
						content: "این فیلد الزامی است.",
						sender: "لطفا یک آدرس ایمیل معتبر وارد کنید."
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