@extends ("layouts.admin.master")
	@section('title','تغییر رمز عبور')
	@section('part','تغییر رمز عبور')
	@section('content')
		<div class="content my_cont">
			<div class="row dashbord-a dash_b">
				<div class="row">
						<div class="col-md-12">
							<div class="tabbable-panel">
								<div class="tabbable-line">
									<div class="tab-content">
											<div class="row">
												<div class="col-md-12">
												
												
												@include('layouts.admin.blocks.message')
												
													<form method="post" action="{{URL::action('Admin\UserController@postChangePassword')}}" id="my_form">
													{{ csrf_field() }}
														
														<div class="form-group">
															<lable>ایمیل:</lable>
															<input class="form-control" type="email" name="email" value="{{Auth::user()->email}}" placeholder="ایمیل" disabled>
														</div>
														
														<div class="form-group">
															<div class="row">
																<div class="col-md-6">
																	<lable>تکرار رمز:</lable>
																		<input class="form-control" type="password" id="repassword" name="repassword" placeholder="تکرار رمز عبور">
																</div>
																<div class="col-md-6">
																	<lable>رمز:</lable>
																		<input class="form-control" type="password" id="password" name="password" placeholder="رمز عبور">
																</div>
															</div>
														</div>
														
														
														<button data-toggle="tooltip"  data-original-title="ذخیره در بانک اطلاعات" class="btn btn-info my_bt" type="submit">ذخیره</button>
												</form>

												</div>
											</div>
									</div>
								</div>
							</div>


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