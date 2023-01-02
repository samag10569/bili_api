@extends ("layouts.admin.master")
@section('title','ویرایش عضو')
@section('part','ویرایش عضو')
@section('content')
	<div class="row">
		<div class="col-md-12">
		  <!-- general form elements -->
		  <div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">ویرایش عضو</h3>
			  <h3 class="box-title" style="float: left;">	
				<button class="btn btn-block bg-olive btn-lg">{{$data->user_code}}</button>
			  </h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			@include('layouts.admin.blocks.message')
			{!! Form::model($data,array('action' => array('Admin\AssignedServeController@postEdit',$data->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
			  
			  <div class="box-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>نام:</label>
								{!! Form::text('name',null,array(
									'class'=>'form-control',
									'placeholder'=>'نام را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>نام خانوادگی:</label>
								{!! Form::text('family',null,array(
									'class'=>'form-control',
									'placeholder'=>'نام خانوادگی را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<lable>تصویر :</lable>
								{!! Form::file('image',array(
									'class'=>'form-control')) !!}
							</div>
							<div class="col-md-2">
								@if(isset($data) and $data->image!='Not Image' and $data->image!='')
									<img src="{!!asset('assets/uploads/member/medium/'.$data->image)!!}"
											class="img-rounded"
											style="width: 100px; height: 60px;">
								@endif
							</div>
							<div class="col-md-4">
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>نام پدر:</label>
								{!! Form::text('father_name',$info_data->father_name,array(
									'class'=>'form-control',
									'placeholder'=>'نام پدر را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>تاریخ تولد:</label>
								{!! Form::text('birth',jdate('d/m/Y',$info_data->birth,'','','en'),array(
									'class'=>'form-control',
									'id'=>'birth',
									'placeholder'=>'تاریخ تولد را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>کد ملی:</label>
								{!! Form::text('national_id',$info_data->national_id,array(
									'class'=>'form-control',
									'data-inputmask'=>"'mask': ['9999999999']",
									'data-mask'=>"",
									'placeholder'=>'کد ملی را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>شماره همراه:</label>
								{!! Form::text('mobile',null,array(
									'class'=>'form-control',
									'placeholder'=>'شماره همراه را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>ایمیل:</label>
								{!! Form::email('email',null,array(
								'class'=>'form-control',
								'disabled'=>'',
								'placeholder'=>'ایمیل را وارد کنید . . .')) !!}
							</div>
							@php
								$interview_type_id1 = null;
								$interview_type_id0 = null;
								if($info_data->interview_type_id == 1)
									$interview_type_id1 = true;
								else
									$interview_type_id0 = true;
							@endphp
							<div class="col-md-6 ejavan_col">
								<label>نوع مصاحبه:</label>
								&nbsp;&nbsp;&nbsp;
								{!!Form::radio('interview_type_id', 1, $interview_type_id1)!!}
								<label>حضوری</label>
								&nbsp;&nbsp;&nbsp;
								{!!Form::radio('interview_type_id',0, $interview_type_id0)!!}
								<label>غیر حضوری</label>
								
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>تاریخ مصاحبه:</label>
								{!! Form::text('date_interview',jdate('d/m/Y',$data->date_interview,'','','en'),array(
									'class'=>'form-control',
									'id'=>'date_interview',
									'disabled'=>'',
									'placeholder'=>'تاریخ مصاحبه را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>ساعت مصاحبه:</label>
								{!! Form::text('time_interview',null,array(
									'class'=>'form-control',
									'data-inputmask'=>"'mask': ['99:99']",
									'data-mask'=>"",
									'disabled'=>'',
									'placeholder'=>'ساعت مصاحبه را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-2">
								<label>درجه علمی:</label>
							</div>
							<div class="col-md-4">
								<a class="btn btn-block bg-info btn-lg" href="{{URL::action('Admin\AssignedServeController@getAllotment',$data->id)}}">
									تخصیص خدمت به فناور
								</a>
							</div>
							<div class="col-md-4">
								@if(!$allotment)
									<a class="btn btn-block bg-danger btn-lg">خدمتی تخصیص داده نشده است</a>
								@else
									<a class="btn btn-block bg-success btn-lg">{{$allotment}} خدمت به فناور تخصیص داده شده است </a>
								@endif
							</div>
							<div class="col-md-2">
								<a class="btn btn-block bg-success btn-lg"> درجه علمی {{$info_data->grade}}</a>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							@php
								$rejection = false;
								$status_id_1 = false;
								$status_id_2 = false;
								$status_id_3 = false;
								$status_id_4 = false;
								$active = [];
								if(!$allotment) $active = ['disabled'=>''];
								
								if($data->rejection) $rejection = true;
								elseif($data->status_id == 1) $status_id_1 = true;
								elseif($data->status_id == 2) $status_id_2 = true;
								elseif($data->status_id == 3) $status_id_3 = true;
								elseif($data->status_id == 4) $status_id_4 = true;
							@endphp
							<div class="col-md-2 ejavan_col">
								<label>وضعیت عضو:</label>
							</div>
							<div class="col-md-5 ejavan_col">
								
								{!!Form::radio('member_status_id', 1,$status_id_1)!!}
								<label>در انتظار بررسی کارشناس جهت مصاحبه (برگشت پرونده به مرحله قبل)</label>
								</br>
								
								{!!Form::radio('member_status_id',2,$status_id_2)!!}
								<label>  اعضای تایید شده جهت مصاحبه (تعیین گرید)</label>
								</br>
								
								{!!Form::radio('member_status_id',3,$status_id_3)!!}
								<label>  تایید جهت تخصیص خدمت</label>
								</br>
								
								{!!Form::radio('member_status_id',4,$status_id_4,$active)!!}
								<label>  تایید اولیه</label>
								</br>
								
								{!!Form::radio('member_status_id',-1,$rejection,array('id'=>'rejection'))!!}
								<label> رد هرگونه عضویت در کانون رشد نخبگان جوان</label>
								</br>
								
							</div>
							
							<div class="col-md-5">
							
								{!! Form::text('reason_rejection',null,array(
									'class'=>'form-control',
									'id'=>'reason_rejection',
									'placeholder'=>'دلیل رد شدن عضو را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>مقطع تحصیلی:</label>
								{!! Form::select('branch_id',$branch_id,null,array('class'=>'form-control')) !!}
							</div>
							<div class="col-md-6">
								<label>شاخه تحصیلی:</label>
								{!! Form::select('category_id',$category_id,null,array('class'=>'form-control')) !!}
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>رشته تحصیلی:</label>
								{!! Form::text('branch',$info_data->branch,array(
								'class'=>'form-control',
								'placeholder'=>'رشته تحصیلی را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>استان:</label>
								{!! Form::select('state_id',$state_id,$info_data->state_id,array('class'=>'form-control')) !!}
							</div>
							<div class="col-md-6">
								<label>کدپستی:</label>
								{!! Form::text('postal_code',$info_data->postal_code,array(
									'class'=>'form-control',
									'data-inputmask'=>"'mask': ['9999999999']",
									'data-mask'=>"",
									'placeholder'=>'ساعت مصاحبه را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>آدرس محل سکونت:</label>
								{!! Form::text('city',$info_data->city,array(
								'class'=>'form-control',
								'placeholder'=>'آدرس را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>وضعیت شغلی:</label>
								{!! Form::text('employment_status',$info_data->employment_status,array(
								'class'=>'form-control',
								'placeholder'=>'وضعیت شغلی را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>مدیر ثبت نام کننده:</label>
								{!! Form::select('admin_id',$admin_id,null,array('class'=>'form-control')) !!}
							</div>
						</div>
					</div>
					
					@php
						$article = false;
						$invention = false;
						$ideas = false;
						$expertise = false;
						if($info_data->article) $article = true;
						if($info_data->invention) $invention = true;
						if($info_data->ideas) $ideas = true;
						if($info_data->expertise) $expertise = true;
					@endphp
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-2">
								<label>گزینه ها:</label>
							</div>
							<div class="col-md-2">
								{!!Form::checkbox('article', 1, $article )!!}
								&nbsp;
								<label>مقاله دارد</label>
							</div>
							<div class="col-md-2">
								{!!Form::checkbox('invention', 1,$invention)!!}
								&nbsp;
								<label>ثبت اختراع دارد </label>
							</div>
							<div class="col-md-2">
								{!!Form::checkbox('ideas', 1,$ideas)!!}
								&nbsp;
								<label>ایده دارد </label>
							</div>
							<div class="col-md-2">
								{!!Form::checkbox('expertise', 1,$expertise)!!}
								&nbsp;
								<label>تخصص دارد </label>
							</div>
							<div class="col-md-2">
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>عنوان مقاله:</label>
								{!! Form::text('article_title',$info_data->article_title,array(
								'class'=>'form-control',
								'placeholder'=>'عنوان مقاله را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>عنوان اختراع:</label>
								{!! Form::text('invention_title',$info_data->invention_title,array(
								'class'=>'form-control',
								'placeholder'=>'عنوان اختراع را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>عنوان ایده:</label>
								{!! Form::text('ideas_title',$info_data->ideas_title,array(
								'class'=>'form-control',
								'placeholder'=>'عنوان ایده را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>رزومه:</label>
								{!! Form::textarea('cv',null,array(
								'class'=>'form-control ckeditor',
								'placeholder'=>'رزومه را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
				@include('layouts.admin.blocks.message-ajax')
				
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label> توضیحات اضافی</label>
								{!! Form::textarea('content',null,array(
								'class'=>'form-control',
								'rows'=>'3',
								'placeholder'=>'توضیحات اضافی را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
				@foreach($content_data as $item)
					<div class="form-group">
						<div class="row">
							<div class="col-md-10" id="content{{$item->id}}">
								<label>
									{{@$item->admin->name.' '.@$item->admin->family}} 
									&nbsp;&nbsp;&nbsp;
									{{jdate('Y/m/d H:i',$item->created_at->timestamp)}} 
								</label>
								{!! Form::textarea('cv',$item->content,array(
								'class'=>'form-control',
								'rows'=>'3',
								'placeholder'=>'توضیحات اضافه را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-2 ejavan_col">
								<a class="btn btn-danger btn-sm delete_content" id="delete_content{{$item->id}}"
								   style="cursor:pointer" onclick="deleteContent('{{URL::action('Admin\AssignedServeController@getDeleteContent',$item->id)}}',{{$item->id}})" ><i
											class="fa fa-trash"></i> حذف توضیحات</a>
								<center class="loading" id="loading{{$item->id}}">
								<img src="{{ asset('assets/admin/img/loading.gif')}}" width="30" height="30"/>
								در حال حذف اطلاعات لطفا شکیبا باشید.
								</center>
							</div>
						</div>
					</div>
				@endforeach
					
					
				  <div class="box-footer">
					<button type="submit" class="btn btn-primary">ذخیره</button>
				  </div>
			  
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
			
			$('.loading').hide();
			$('.msgno').hide();
			$('.msgok').hide();
			$('#reason_rejection').hide();
			
			$('input[type="radio"]').click(function () {
				if ($(this).attr('id') == 'rejection') {
					$('#reason_rejection').show();
				}
				else {
					$('#reason_rejection').hide();
				}
			});
		
		});
		
		function deleteContent(x,id) {
			$('#loading'+id).show();
			$('#delete_content'+id).hide();
			$.ajax({
				url: x,
				success: function (x) {
					$('#loading'+id).hide();
						var data = JSON.parse(x);
						$('.msg'+data.status).show();
						$("#msg"+data.status).html(data.msg);
						if(data.status == 'ok'){
							$('#content'+id).hide();
						}else{
							$('#delete_content'+id).show();
						}
				},
				error: function(error_thrown){
					$('#loading'+id).hide();
					$('#delete_content'+id).show();
					$('.msgno').show();
					$("#msgno").html('دسترسی شما محدود می باشد.');
				}
			});
		}
		
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
						father_name: "required",
						birth: "required",
						mobile: "required",
						national_id: "required",
						date_interview: "required",
						time_interview: "required",
						branch_id: "required",
						category_id: "required",
						state_id: "required",
						postal_code: "required",
						city: "required",
						branch: "required",
						email: {
							required: true,
							email: true
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