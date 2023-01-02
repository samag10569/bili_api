@extends ("layouts.admin.master")
@section('title','خدمات تخصیص داده شده')
@section('part','خدمات تخصیص داده شده')
@section('content')
	<div class="row">
		<div class="col-md-12">
		  <!-- general form elements -->
		  <div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">خدمات تخصیص داده شده به  {{$user->name.' '.$user->family}}</h3>
			  <h3 class="box-title" style="float: left;">	
				<button class="btn btn-block bg-olive btn-lg">{{$user->user_code}}</button>
			  </h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			@include('layouts.admin.blocks.message')
			
			   
			  <div class="box-body">
				@foreach($allotment_category as $row)
					<div class="form-group ejavan_title">
						{{$row->title}}
					</div>
					@php $count = 1; @endphp
					@foreach($row->allotment as $item)
						<div class="form-group">
							<div class="row">
								<div class="col-md-9">
									{{$count.') '.$item->title}} ({{$item->content}} )
								</div>
								
								<div class="col-md-3">
									@php
										if($allotment_data[$item->id] == null) echo '<a class="btn btn-block bg-danger btn-lg">خیر</a>';
										if($allotment_data[$item->id] == 1 || $allotment_data[$item->id] == 4 || $allotment_data[$item->id] == 5 ) echo '<a class="btn btn-block bg-info btn-lg">ارسال</a>';
										if($allotment_data[$item->id] == 2) echo '<a class="btn btn-block bg-success btn-lg">بلی</a>';
									@endphp
								</div>
							</div>
						</div>
					@if($item->option)
						<div class="form-group">
						@if(count($item->allotmentOption->where('user_id',$user->id)))
							@foreach($item->allotmentOption->where('user_id',$user->id) as $op)
								<div class="row">
									<div class="col-md-6">
										{!! Form::text('allotment_option_old',$op->content,array(
										'class'=>'form-control',
										'id'=>'option'.$op->id,
										'placeholder'=>'موارد بیشتر')) !!}
									</div>
									<div class="col-md-6">
										<a class="btn btn-danger btn-sm deleteOption" id="deleteOption{{$op->id}}"
										   style="cursor:pointer" onclick="deleteOption('{{URL::action('Admin\CoreFacilityController@getDeleteOption',$op->id)}}',{{$op->id}})" ><i
													class="fa fa-trash"></i> حذف توضیحات</a>
										<center class="loading" id="loading{{$op->id}}">
										<img src="{{ asset('assets/admin/img/loading.gif')}}" width="30" height="30"/>
										در حال حذف اطلاعات لطفا شکیبا باشید.
										</center>
									</div>
								</div>
								</br>
							@endforeach
						@endif
						</div>
					@endif
						<hr>
						@php $count++; @endphp
					@endforeach
				@endforeach
				
				
			{!! Form::open(array('action' => array('Admin\CoreFacilityController@postCoreScientific',$user->id),'role' => 'form','id' => 'ejavan_form')) !!}
				@php
					$core_scientific1 = false;
					$core_scientific0 = false;
					if($user->core_scientific) $core_scientific1 = true;
					else $core_scientific0 = true;
				
				@endphp
				
				
		@include('layouts.admin.blocks.message-ajax')
				
				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							شرایط عضویت در هسته علمی را دارد؟
						</div>
						<div class="col-md-3">
							{!!Form::radio('core_scientific', 1, $core_scientific1)!!} 
									بلی
						</div>
						<div class="col-md-3">
							{!!Form::radio('core_scientific', 0, $core_scientific0)!!} 
									خیر
						</div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary">ذخیره</button>
						</div>
					</div>
				</div>
				
				<div class="form-group" id="access">
					<div class="row">
						<div class="col-md-4">
							<label>سمت:</label>
							{!! Form::text('station',$user->station,array(
								'class'=>'form-control',
								'placeholder'=>'سمت را وارد کنید . . .')) !!}
						</div>
						<div class="col-md-8">
							<label>کارشناس:</label>
							<select name="groups[]" class="selectpicker form-control" multiple>
								@foreach($groups as $item)
									<option value="{{$item->id}}" @if(in_array($item->id, $groupsId)) selected @endif>{{$item->title}}</option>
								@endforeach
							</select>
						</div>
					</div>
					
				</div>
			{!! Form::close() !!}
			<div class="form-group ejavan_title">
				عناوین خدمات پیگیری شده هسته تسهیل: 
			</div>
			<div class="form-group">
				@foreach($messages as $message)
					<div class="row">
						<div class="col-md-6">
							{!! Form::text('message',$message->content,array(
							'class'=>'form-control',
							'id'=>'message'.$message->id,
							'placeholder'=>'توضیحات')) !!}
						</div>
						<div class="col-md-3">
							<a class="btn btn-danger btn-sm deleteMessage" id="deleteMessage{{$message->id}}"
							   style="cursor:pointer" onclick="deleteMessage('{{URL::action('Admin\CoreFacilityController@getDeleteMessage',$message->id)}}',{{$message->id}})" ><i
										class="fa fa-trash"></i> حذف</a>
							<a class="btn btn-warning btn-sm editMessage" id="editMessage{{$message->id}}"
							   style="cursor:pointer" onclick="editMessage('{{URL::action('Admin\CoreFacilityController@getEditMessage',$message->id)}}',{{$message->id}})" ><i
										class="fa fa-edit"></i> ویرایش</a>
							<center class="loading" id="loading_msg{{$message->id}}">
								<img src="{{ asset('assets/admin/img/loading.gif')}}" width="30" height="30"/>
							</center>
						</div>
						<div class="col-md-3" id="date_msg{{$message->id}}">
							{{jdate('H:i - Y/m/d', $message->created_at->timestamp)}} &nbsp;
								{{@$message->userAdmin->name.' '.@$message->userAdmin->family}}
						</div>
					</div>
					</br>
				@endforeach
			</div>
			<div class="form-group ejavan_title">
				ثبت خدمات پیگیری شده 
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						{!! Form::select('allotment_id',$allotment_id,null,array('class'=>'form-control','id'=>'allotment_id')) !!}
					</div>
					<div class="col-md-5">
						{!! Form::text('content',null,array(
						'class'=>'form-control',
						'id'=>'content_allotment',
						'placeholder'=>'توضیحات')) !!}
					</div>
					<div class="col-md-1">
						<a class="btn btn-success btn-sm addMessage" id="addMessage"
						   style="cursor:pointer" onclick="addMessage('{{URL::action('Admin\CoreFacilityController@getAddMessage')}}')" ><i
									class="fa fa-plus"></i> ذخیره</a>
						<center class="loading" id="loading_add">
							<img src="{{ asset('assets/admin/img/loading.gif')}}" width="30" height="30"/>
						</center>
					</div>
				</div>
			</div>
	</div>
@stop
@section('css')
	<link href="{{ asset('assets/admin/css/bootstrap-select.min.css')}}" rel="stylesheet">
@stop

	
@section('js')
<script src="{{ asset('assets/admin/js/bootstrap-select.min.js')}}"></script>
<script type="text/javascript">

	$(document).ready(function(){
		$('.loading').hide();
		$('.msgno').hide();
		$('.msgok').hide();
		$('#access').hide();
		
		if ($('input[name="core_scientific"]:checked').val() == 1) {
			$('#access').show();
		}
			
		$('input[type="radio"]').click(function () {
			if ($('input[name="core_scientific"]:checked').val() == 1) {
				$('#access').show();
			} else {
				$('#access').hide();
			}
		});
			
	});
		
	function deleteOption(x,id) {
			$('#loading'+id).show();
			$('#deleteOption'+id).hide();
			$.ajax({
				url: x,
				success: function (x) {
					$('#loading'+id).hide();
						var data = JSON.parse(x);
						$('.msg'+data.status).show();
						$("#msg"+data.status).html(data.msg);
						if(data.status == 'ok'){
							$('#option'+id).hide();
						}else{
							$('#deleteOption'+id).show();
						}
				},
				error: function(error_thrown){
					$('#loading'+id).hide();
					$('#deleteOption'+id).show();
					$('.msgno').show();
					$("#msgno").html('دسترسی شما محدود می باشد.');
				}
			});
		}
		
	function deleteMessage(x,id) {
			$('#loading_msg'+id).show();
			$('#deleteMessage'+id).hide();
			$('#editMessage'+id).hide();
			$('#date_msg'+id).hide();
			$.ajax({
				url: x,
				success: function (x) {
					$('#loading_msg'+id).hide();
						var data = JSON.parse(x);
						$('.msg'+data.status).show();
						$("#msg"+data.status).html(data.msg);
						if(data.status == 'ok'){
							$('#message'+id).hide();
						}else{
							$('#deleteMessage'+id).show();
							$('#editMessage'+id).show();
							$('#date_msg'+id).show();
						}
				},
				error: function(error_thrown){
					$('#loading_msg'+id).hide();
					$('#deleteMessage'+id).show();
					$('#editMessage'+id).show();
					$('#date_msg'+id).show();
					$('.msgno').show();
					$("#msgno").html('دسترسی شما محدود می باشد.');
				}
			});
		}
	function editMessage(x,id) {
			$('#loading_msg'+id).show();
			$('#editMessage'+id).hide();
			var content = $('#message'+id).val();
			$.ajax({
				url: x,
				data: 'content='+content,
				success: function (x) {
					$('#loading_msg'+id).hide();
						var data = JSON.parse(x);
						$('.msg'+data.status).show();
						$("#msg"+data.status).html(data.msg);
						$('#editMessage'+id).show();
				},
				error: function(error_thrown){
					$('#loading_msg'+id).hide();
					$('#editMessage'+id).show();
					$('.msgno').show();
					$("#msgno").html('دسترسی شما محدود می باشد.');
				}
			});
		}
		
	function addMessage(x) {
			$('#loading_add').show();
			$('#addMessage').hide();
			var content = $('#content_allotment').val();
			var allotment_id = $('#allotment_id').val();
			$.ajax({
				url: x,
				data: 'content='+content+'&user_id='+{{$user->id}}+'&allotment_id='+allotment_id,
				success: function (x) {
					$('#loading_add').hide();
						var data = JSON.parse(x);
						$('.msg'+data.status).show();
						$("#msg"+data.status).html(data.msg);
						$('#addMessage').show();
				},
				error: function(error_thrown){
					$('#loading_add').hide();
					$('#addMessage').show();
					$('.msgno').show();
					$("#msgno").html('دسترسی شما محدود می باشد.');
				}
			});
		}
</script>
@stop
