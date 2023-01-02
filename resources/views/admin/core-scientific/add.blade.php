@extends ("layouts.admin.master")
@section('title','اعضا هسته علمی')
@section('part','اعضا هسته علمی')
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
				{!! Form::open(array('action' => array('Admin\CoreScientificController@postAdd'), 'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
				  <div class="box-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>کد یکتا کاربر:</label>
								{!! Form::text('user_id',null,array(
									'class'=>'form-control',
									'id'=>'user_id',
									'placeholder'=>'کد یکتا را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6 ejavan_col">
								  <span id="display"
								  style="background:#ddd;width:100%;float:left;display: none;"></span><i
									id="spinner" class="fa fa-spinner fa-spin"
									style="display: none;font-size:20px"></i>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>نام:</label>
								{!! Form::text('name',null,array(
									'class'=>'form-control',
									'id'=>'name',
									'placeholder'=>'نام را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>نام خانوادگی:</label>
								{!! Form::text('family',null,array(
									'class'=>'form-control',
									'id'=>'family',
									'placeholder'=>'نام خانوادگی را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>مقطع تحصیلی:</label>
								{!! Form::select('branch_id',$branch_id,null,array('class'=>'form-control','id'=>'branch_id')) !!}
							</div>
							<div class="col-md-6">
								<label>شاخه تحصیلی:</label>
								{!! Form::select('category_id',$category_id,null,array('class'=>'form-control','id'=>'category_id')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>سمت:</label>
								{!! Form::text('station',null,array(
									'class'=>'form-control',
									'id'=>'station',
									'placeholder'=>'سمت را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>شماره تماس:</label>
								{!! Form::text('mobile',null,array(
									'class'=>'form-control',
									'id'=>'mobile',
									'disabled'=>'',
									'placeholder'=>'شماره تماس را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>ایمیل:</label>
								{!! Form::email('email',null,array(
								'class'=>'form-control',
								'id'=>'email',
								'disabled'=>'',
								'placeholder'=>'ایمیل را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>وضعیت:</label>
								{!! Form::select('status',$status,null,array(
									'class'=>'form-control',
									'id'=>'status')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label>کارشناس:</label>
						<select name="groups[]" class="selectpicker form-control" multiple>
							@foreach($groups as $item)
								<option value="{{$item->id}}" @if(in_array($item->id, $groupsId)) selected @endif>{{$item->title}}</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<lable>تصویر :</lable>
								{!! Form::file('image',array(
									'class'=>'form-control')) !!}
							</div>
							<div class="col-md-2">
								<img src="{!!asset('assets/uploads/notFound.jpg')!!}"
										class="img-rounded"
										id="image"
										style="width: 100px; height: 60px;">
							</div>
							<div class="col-md-4">
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>رزومه:</label>
								{!! Form::textarea('cv',null,array(
								'class'=>'form-control ckeditor',
								'id'=>'cv',
								'placeholder'=>'رزومه را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
										
				  <div class="box-footer">
					<button type="submit" class="btn btn-primary">ذخیره</button>
				  </div>
				{!! Form::close() !!}
			  </div><!-- /.box -->
			</div>
		</div>
	@stop
	
@section('css')
	<link href="{{ asset('assets/admin/css/bootstrap-select.min.css')}}" rel="stylesheet">
@stop

	
@section('js')
	<script src="{{ asset('assets/admin/js/bootstrap-select.min.js')}}"></script>
    <script>
	
	$(document).ready(function () {
		$("#user_id").focusout(function () {
			var elem = $("#display");
			var spinner = $("#spinner");
			if ($(this).val() != "") {
				elem.hide(1000);
				spinner.show(1000);
				$.ajax({
					url: "{{ URL::action('Admin\CoreScientificController@getUserAjax') }}/" + $(this).val(),
					success: function (result) {
						var data = jQuery.parseJSON(result);
						if (data.status === true) {
							elem.attr('style', 'color:green;background:#ddd;width:100%;float:left;padding: 5px;border-radius: 5px;');
							var user = jQuery.parseJSON(data.user);
							$('#name').val(user.name);
							$('#family').val(user.family);
							$('#branch_id').val(user.branch_id);
							$('#category_id').val(user.category_id);
							$('#station').val(user.station);
							$('#mobile').val(user.mobile);
							$('#email').val(user.email);
							$('#status').val(user.status);
							$('#cv').val(user.cv);
							$("#image").attr("src","{!!asset('assets/uploads/user/medium/')!!}/"+user.image);
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
						branch_id: "required",
						category_id: "required",
						station: "required",
						mobile: "required",
						email: {
							required: true,
							email: true
						},
						agree: "required"
					},
					messages: {
						name: "این فیلد الزامی است.",
						family: "این فیلد الزامی است.",
						branch_id: "این فیلد الزامی است.",
						category_id: "این فیلد الزامی است.",
						station: "این فیلد الزامی است.",
						mobile: "این فیلد الزامی است.",
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
</script>		
@endsection