@extends ("layouts.out.master")
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
			{!! Form::model($data,array('route' => array('post.edit.'.$allotment_id,$data->id),'role' => 'form', 'id' => 'ejavan_form')) !!}
			  <div class="box-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>نام:</label>
								{!! Form::text('name',null,array(
									'class'=>'form-control',
									'disabled'=>'',
									'placeholder'=>'نام را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>نام خانوادگی:</label>
								{!! Form::text('family',null,array(
									'class'=>'form-control',
									'disabled'=>'',
									'placeholder'=>'نام خانوادگی را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>نام پدر:</label>
								{!! Form::text('father_name',$info_data->father_name,array(
									'class'=>'form-control',
									'disabled'=>'',
									'placeholder'=>'نام پدر را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>تاریخ تولد:</label>
								{!! Form::text('birth',jdate('d/m/Y',$info_data->birth,'','','en'),array(
									'class'=>'form-control',
									'id'=>'birth',
									'disabled'=>'',
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
									'disabled'=>'',
									'placeholder'=>'کد ملی را وارد کنید . . .')) !!}
							</div>
							<div class="col-md-6">
								<label>شماره همراه:</label>
								{!! Form::text('mobile',null,array(
									'class'=>'form-control',
									'disabled'=>'',
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
							<div class="col-md-6">
								<label>تاریخ مصاحبه:</label>
								{!! Form::text('date_interview',jdate('d/m/Y',$data->date_interview,'','','en'),array(
									'class'=>'form-control',
									'id'=>'date_interview',
									'disabled'=>'',
									'placeholder'=>'تاریخ مصاحبه را وارد کنید . . .')) !!}
								
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>مقطع تحصیلی:</label>
								{!! Form::text('branchInfo',@$data->branchInfo->title,array(
								'class'=>'form-control',
								'disabled'=>'')) !!}
							</div>
							<div class="col-md-6">
								<label>شاخه تحصیلی:</label>
								{!! Form::text('category',@$data->category->title,array(
								'class'=>'form-control',
								'disabled'=>'')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>استان:</label>
								{!! Form::text('state',@$info_data->state->title,array(
								'class'=>'form-control',
								'disabled'=>'')) !!}
							</div>
							<div class="col-md-6">
								<label>رشته تحصیلی:</label>
								{!! Form::text('branch',$info_data->branch,array(
								'class'=>'form-control',
								'disabled'=>'',
								'placeholder'=>'رشته تحصیلی را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>آدرس محل سکونت:</label>
								{!! Form::text('city',$info_data->city,array(
								'class'=>'form-control',
								'disabled'=>'',
								'placeholder'=>'آدرس را وارد کنید . . .')) !!}
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label>{{$allotment_title}} : </label>
							</div>
							@foreach($allotment_status as $key=>$item)
								@php
									$check = false;
									if($allotment_data_status == $key) $check = true;
								@endphp
								<div class="col-md-3">
									{!!Form::radio('allotment_status', $key, $check)!!}
									&nbsp;
									<label>{{$item}}</label>
								</div>
							@endforeach
						</div>
					</div>
					
					<div class="form-group">
						<label>توضیحات:</label>
						{!! Form::text('allotment_message',@$message->content,array(
							'class'=>'form-control',
							'id'=>'allotment_message',
							'placeholder'=>'توضیحات را وارد کنید . . .')) !!}
					</div>
					
					@php
						$inspector_status_price = false;
						$inspector_status_free = false;
						if(@$allotment_user->inspector_amount == 0 || @$allotment_user->inspector_amount == null) $inspector_status_free = true;
						else $inspector_status_price = true;
					
					
					@endphp
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label>هزینه دریافتی از فناور : </label>
							</div>
							<div class="col-md-3">
								{!! Form::text('inspector_amount',@$allotment_user->inspector_amount,array(
									'class'=>'form-control',
									'id'=>'inspector_amount',
									'placeholder'=>'هزینه دریافتی از فناور')) !!}
							</div>
							<div class="col-md-3">
								{!!Form::radio('inspector_status', 1, $inspector_status_price)!!}
								&nbsp;
								<label>هزینه خدمت دریافت گردید </label>
							</div>
							<div class="col-md-3">
								{!!Form::radio('inspector_status', 0, $inspector_status_free)!!}
								&nbsp;
								<label>خدمت رایگان ارائه گردید </label>
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
@section('js')
<script type="text/javascript">

        $(document).ready(function () {
			document.getElementById("allotment_message").disabled = false;
			if ($('input[name="allotment_status"]:checked').val() == 1 || $('input[name="allotment_status"]:checked').val() == 4) {
				document.getElementById("allotment_message").disabled = true;
			}
				
            $('input[name="allotment_status"]').click(function () {
                if ($('input[name="allotment_status"]:checked').val() == 1 || $('input[name="allotment_status"]:checked').val() == 4) {
					document.getElementById("allotment_message").disabled = true;
                } else {
					document.getElementById("allotment_message").disabled = false;
                }

            });
			
			
			document.getElementById("inspector_amount").disabled = false;
			if ($('input[name="inspector_status"]:checked').val() == 0) {
				document.getElementById("inspector_amount").disabled = true;
			}
				
            $('input[name="inspector_status"]').click(function () {
                if ($('input[name="inspector_status"]:checked').val() == 0) {
					document.getElementById("inspector_amount").disabled = true;
                } else {
					document.getElementById("inspector_amount").disabled = false;
                }

            });
		});
		
 </script>
@stop
