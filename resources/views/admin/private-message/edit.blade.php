@extends ("layouts.admin.master")
@section('title','ویرایش پیام خصوصی')
@section('part','ویرایش خصوصی')
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
				{!! Form::model($data,array('action' => array('Admin\PrivateMessagesController@postEdit',$data->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
				<div class="box-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>عنوان:</label>
								{!! Form::text('subject',null,array(
                                    'class'=>'form-control',
                                    )) !!}
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
                                title: "required",
                                content: "required",

                            },
                            messages: {
                                title: "این فیلد الزامی است.",
                                content: "این فیلد الزامی است.",

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