@extends('layouts.crm.master')
@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">پیام خصوصی</a></li>
				</ul>
			</div>
		</div>
		<!-- /.page-navigator -->
	</div>
</section>
@stop
@section('content')
	<!----------------------------------- left SIDE -------------------------------->
	<div class="col-md-3 col-sm-12 col-xs-12">
		<div id="right-sidebar">
			<div class="box mainbox" style="margin-bottom:20px;">
				<div class="head">
					<h4>منوی بخش پیام ها </h4>
				</div>
				<!-- .head -->
				<div class="body">
					<ul>
						<li class="default"><a href="{{URL::action('Crm\PrivateMessagesController@getInbox')}}">دریافت شده</a></li>
						<li class="default"><a href="{{URL::action('Crm\PrivateMessagesController@getOutbox')}}">ارسال شده</a></li>
						<li class="default"><a href="{{URL::action('Crm\NetworkController@getIndex')}}">لیست دوستان</a></li>
						<li class="send link-hover"><a href="{{URL::action('Crm\PrivateMessagesController@getSend')}}">ارسال پیام خصوصی جدید</a></li>
					</ul>
				</div>
				<!-- .body -->
			</div>
			<!-- .box -->


		</div>
		<!-- /#left-sidebar -->
	</div>
	<!----------------------------------- left SIDE -------------------------------->
	<!----------------------------------- RIGHT SIDE ------------------------------->
	<div class="col-md-9">

		<div class="box mailbox-details">
			<div class="head">
				<h4>ارسال پیام جدید</h4>

			</div>
			<!-- .head -->
			<div class="body">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						{!! Form::model(null,array('action' => array('Crm\PrivateMessagesController@postSend'),'role' => 'form','id' => 'ejavan_form')) !!}
							<div class="box-body">
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>گیرنده:</label>
											{!! Form::text('user_id_to',$user_id,array(
												'class'=>'form-control',
												'autocomplete'=>'off',
												'id'=>'user_id_to')) !!}
										</div>
										<div class="col-md-6" style="margin-top: 23px;">
											<span id="display"
											  style="background:#ddd;width:100%;display: none;"></span><i
												id="spinner" class="fa fa-spinner fa-spin"
												style="display: none;font-size:20px"></i>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-12">
											<label>عنوان:</label>
											{!! Form::text('subject',null,array(
												'class'=>'form-control',
												'rows'=>3)) !!}
										</div>

									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-12">
											<label>پیام:</label>
											{!! Form::textarea('message',null,array(
												'class'=>'form-control ckeditor','rows'=>'2')) !!}
										</div>
									</div>
								</div>


								<div class="box-footer">
									<button type="submit" class="btn btn-primary">ارسال</button>
								</div>
							</div>
							{!! Form::close() !!}
							
					</div>
				</div>
			</div>
			<!-- .body -->
		</div>
		<!-- .box -->
				<!----------------------------------- RIGHT SIDE ------------------------------->

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
                                user_id_to: "required",
                                subject: "required",
                                message: "required",

                            },
                            messages: {
                                user_id_to: "این فیلد الزامی است.",
                                subject: "این فیلد الزامی است.",
                                message: "این فیلد الزامی است.",

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
	
	<script type='text/javascript'>
        $(document).ready(function () {
			$("#user_id_to").focusout(function () {
					var elem = $("#display");
					var spinner = $("#spinner");
					if ($(this).val() != "") {
						elem.hide(1000);
						spinner.show(1000);
						$.ajax({
							url: "{{ URL::action('Crm\PrivateMessagesController@getUser') }}/" + $(this).val(),
							success: function (result) {
								var data = jQuery.parseJSON(result);
								
								if (data.status === true) {
									elem.attr('style', 'color:green;background:#ddd;width:100%;float:left;padding: 5px;border-radius: 5px;');
								} else {
									elem.attr('style', 'color:red;background:#ddd;width:100%;float:left;padding: 5px;border-radius: 5px;');
								}
								elem.show(1000);
								elem.empty().append(data.text);
								spinner.hide(1000);
							}
						});
					}
				});
			});
		
	</script>
@endsection