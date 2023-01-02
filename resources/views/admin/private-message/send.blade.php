@extends ("layouts.admin.master")
@section('title','ارسال پیام خصوصی')
@section('part','ارسال پیام خصوصی')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"> ویرایش</h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				@include('layouts.admin.blocks.message')
				{!! Form::model(null,array('action' => array('Admin\PrivateMessagesController@postSend'),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
				<div class="box-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>گیرنده:</label>
								{!! Form::text('user_id_to',null,array(
                                    'class'=>'form-control',
                                    'autocomplete'=>'off',
                                    'id'=>'user_id')) !!}
							</div>
							<div class="col-md-6">
								<label>&nbsp;</label>
								<p id="user-info-name">شناسه کاربر را وارد کنید</p>
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
						<button type="submit" class="btn btn-primary">ذخیره</button>
					</div>
				</div>
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
                                subject: "required",
                                message: "required",

                            },
                            messages: {
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
	<script>
        ;(function($){
            $.fn.extend({
                donetyping: function(callback,timeout){
                    timeout = timeout || 1e3; // 1 second default timeout
                    var timeoutReference,
                        doneTyping = function(el){
                            if (!timeoutReference) return;
                            timeoutReference = null;
                            callback.call(el);
                        };
                    return this.each(function(i,el){
                        var $el = $(el);
                        $el.is(':input') && $el.on('keyup keypress paste',function(e){
                            if (e.type=='keyup' && e.keyCode!=8) return;
                            if (timeoutReference) clearTimeout(timeoutReference);
                            timeoutReference = setTimeout(function(){
                                doneTyping(el);
                            }, timeout);
                        }).on('blur',function(){
                            doneTyping(el);
                        });
                    });
                }
            });
        })($);
        $( document ).ready(function() {
            $('#user_id').donetyping(function(){
                $.ajax({
                    method: "POST",
                    dataType: 'json',
                    url: '{!!URL::action('Admin\PrivateMessagesController@postUser')!!}',
                    data: { _token: '{!! csrf_token() !!}' ,code: $('#user_id').val() },
                    success: function(row) {
                        if(row.status=='success')
                            $('#user-info-name').html(row.data)
                        else
                            $('#user-info-name').html('کاربر یافت نشد.')
                    }
                });
                return false;
            });
        });
	</script>
@endsection