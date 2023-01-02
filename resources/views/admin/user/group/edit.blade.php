@extends ("layouts.admin.master")
@section('title','سطح دسترسی')
@section('part','سطح دسترسی')
@section('content')
	<div class="row">
		<div class="col-md-12">
		  <!-- general form elements -->
		  <div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">مدیر جدید</h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			@include('layouts.admin.blocks.message')
			{!! Form::model($data,array('action' => array('Admin\UserController@postGroupEdit',$data->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
			  @include('admin.user.group.form')
			{!! Form::close() !!}
		  </div><!-- /.box -->
		</div>
	</div>
@stop


	
@section('js')

    <script>
	
	$(document).ready(function () {
		$("#select_all").on('click', function () {
			$.each($("input"), function (index, value) {
				if (value.type == 'checkbox') {
					value.checked = $("#select_all")[0].checked;
				}
			});
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
						agree: "required"
					},
					messages: {
						name: "این فیلد الزامی است."
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