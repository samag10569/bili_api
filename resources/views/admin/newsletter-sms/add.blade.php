@extends ("layouts.admin.master")
@section('title','ارسال پیامک به اعضای خبرنامه')
@section('part','ارسال پیامک به اعضای خبرنامه')
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
				{!! Form::open(array('action' => array('Admin\NewsletterSmsController@postAdd'), 'role' => 'form','files' => 'true','id' => 'ejavan_form','class' => 'form-horizontal')) !!}
				  @include('admin.newsletter-sms.form')
				{!! Form::close() !!}
			  </div><!-- /.box -->
			</div>
		</div>
	@stop
	
	
@section('js')

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
                        sender: "required",
						agree: "required"
					},
					messages: {
						count: "این فیلد الزامی است.",
						subject: "این فیلد الزامی است.",
						content: "این فیلد الزامی است.",
						sender: "لطفا شماره فرستنده معتبر وارد کنید."
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