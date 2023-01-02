@extends ("layouts.admin.master")
@section('title','تخصیص خدمت به فناور')
@section('part','تخصیص خدمت به فناور')
@section('content')
	<div class="row">
		<div class="col-md-12">
		@include('layouts.admin.blocks.message-ajax')
		  <!-- general form elements -->
		  <div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">تخصیص خدمت به  {{$user->name.' '.$user->family}}</h3>
			  <h3 class="box-title" style="float: left;">	
				<button class="btn btn-block bg-olive btn-lg">{{$user->user_code}}</button>
			  </h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			@include('layouts.admin.blocks.message')
			{!! Form::model(array('action' => array('Admin\AssignedServeController@postAllotment',$user->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
			   
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
								@php
									$status_0 = false;
									$status_1 = false;
									$status_2 = false;
									if($allotment_data[$item->id] == null) $status_0 = true;
									if($allotment_data[$item->id] == 1 || $allotment_data[$item->id] == 4 || $allotment_data[$item->id] == 5 ) $status_1 = true;
									if($allotment_data[$item->id] == 2) $status_2 = true;
								@endphp
								<div class="col-md-1">
									{!!Form::radio($item->id, 2,$status_2)!!} 
									بلی
								</div>
								<div class="col-md-1">
									{!!Form::radio($item->id, 1,$status_1)!!} 
									ارسال
								</div>
								<div class="col-md-1">
									{!!Form::radio($item->id, 0,$status_0)!!} 
									خیر
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
										   style="cursor:pointer" onclick="deleteOption('{{URL::action('Admin\AssignedServeController@getDeleteOption',$op->id)}}',{{$op->id}})" ><i
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
							<div class="row">
								<div class="col-md-6 lists{{$item->id}}">
									{!! Form::text($item->id.'allotment_option[]',null,array(
									'class'=>'form-control',
									'placeholder'=>'موارد بیشتر')) !!}
								</div>
								<div class="col-md-6">
									<button class="btn btn-info add{{$item->id}}" type="button">
										<i class="fa fa-plus" style="padding-top: 3px;"></i> 
										بیشتر
									</button>
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$('.add{{$item->id}}').click(function () {
									$('</br><input type="text" id="allotment_title" class="form-control"  value="" name="{{$item->id}}allotment_option[]" placeholder="موارد بیشتر" >').appendTo('.lists{{$item->id}}');
								});
						</script>
					@endif
						<hr>
						@php $count++; @endphp
					@endforeach
				@endforeach
				
				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							تعیین استاد راهنمای مقاله موظفی 
						</div>
						<div class="col-md-4">
							{!! Form::select('factualy',$factualy,$user->factualy_id,array('class'=>'form-control','id'=>'factualy')) !!}
						</div>
						<div class="col-md-4">
							<center class="loading" id="supervisorLoader">
							<img src="{{ asset('assets/admin/img/loading.gif')}}" width="30" height="30"/>
							در حال بارگزاری، لطفا شکیبا باشید
							</center>
							{!! Form::select('supervisor',$supervisor,$user->supervisor,array('class'=>'form-control','id'=>'supervisor')) !!}
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

	$(document).ready(function(){
		$('.loading').hide();
		$('.msgno').hide();
		$('.msgok').hide();
		
		var supervisor = $("#supervisor");
		$("#factualy").on('change', function () {
			$('#supervisorLoader').show();
			$('#supervisor').hide();
			var factualy_id = $(this).val();
			$('.btn-primary').attr('disabled', 'disabled');
			$.ajax({
				url: "{!! URL::action('Admin\AssignedServeController@postSupervisorAjax') !!}",
				data: {
					_token: "{!! csrf_token() !!}",
					key: factualy_id
				},
				method: 'POST',
				success: function (result) {
					$('#supervisorLoader').hide();
					$('#supervisor').show();
					var data = jQuery.parseJSON(result);
					if (data.status === true) {
						supervisor.empty();
						supervisor.append(data.value);
						$('.btn-primary').removeAttr('disabled');
					} else {
						alert(data.error);
					}
				}
			});
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
</script>
@stop
