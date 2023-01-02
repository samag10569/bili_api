@extends ("layouts.admin.master")
	@section('title','تغییر رمز عبور')
	@section('part','تغییر رمز عبور')
	@section('content')
	
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						  <h3 class="box-title">ویرایش رمز عبور</h3>
						  <h3 class="box-title" style="float: left;">	
							<button class="btn btn-block bg-olive btn-lg">{{$data->user_code}}</button>
						  </h3>
						</div><!-- /.box-header -->
					<div class="box-body">
					@include('layouts.admin.blocks.message')
					
						<form method="post" action="{{URL::action('Admin\SearchMemberController@postChangePassword',$data->id)}}" id="my_form">
						{{ csrf_field() }}
							
							<div class="form-group">
								<label>ایمیل:</label>
								<input class="form-control" type="email" name="email" value="{{$data->email}}" placeholder="ایمیل" disabled>
							</div>
							
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>رمز:</label>
											<input class="form-control" type="password" id="password" name="password" placeholder="رمز عبور">
									</div>
									<div class="col-md-6">
										<label>تکرار رمز:</label>
											<input class="form-control" type="password" id="repassword" name="repassword" placeholder="تکرار رمز عبور">
									</div>
								</div>
							</div>
							
							
							<button data-toggle="tooltip"  data-original-title="ذخیره در بانک اطلاعات" class="btn btn-info my_bt" type="submit">ذخیره</button>
					</form>

					</div>
				</div>
			</div>
		</div>
	@stop
	
	@section('js')
	
	<script>
	

/**
  * Basic jQuery Validation Form Demo Code
  * Copyright Sam Deering 2012
  * Licence: http://www.jquery4u.com/license/
  */
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#my_form").validate({
                rules: {
                    password: "required",
                    agree: "required"
                },
                messages: {
                    password: "این فیلد الزامی است."
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
	
	@stop