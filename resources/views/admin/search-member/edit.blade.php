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

			  

			</div><!-- /.box-header -->
			<!-- form start -->
			@include('layouts.admin.blocks.message')
			{!! Form::model($data,array('action' => array('Admin\SearchMemberController@postEdit',$data->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
			  
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
						  <div class="col-md-12">
							  <label>تاریخ عضویت:</label>
							  {!! Form::text('date_c',jdate('d/m/Y',$data->created_at->timestamp,'','','en'),array(
                                  'class'=>'form-control',
                                  'id'=>'date_interview',
                                  'disabled'=>'',
                                  'placeholder'=>'تاریخ عضویت را وارد کنید . . .')) !!}
						  </div>
					</div>


					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>وضعیت:</label>
								{!! Form::select('status',[0=>'غیرفعال',1=>'فعال'],null,array('class'=>'form-control')) !!}
							</div>


							<div class="col-md-6">
								<label>وریفای پیامک:</label>
								{!! Form::select('verified',[0=>'غیرفعال',2=>'فعال'],null,array('class'=>'form-control')) !!}
							</div>

						</div>
					</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>جنسیت:</label>
									{!! Form::select('gender',[0=>'مرد',1=>'زن'],null,array('class'=>'form-control')) !!}
								</div>


								<div class="col-md-6">
									<label>استان:</label>
									{!! Form::select('state',$state_id,null,array('class'=>'form-control')) !!}
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>کدملی:</label>
									{!! Form::text('ncode',null,array('class'=>'form-control')) !!}
								</div>


								<div class="col-md-6">
									<label>آدرس:</label>
									{!! Form::text('address',null,array('class'=>'form-control')) !!}
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>کدپستی:</label>
									{!! Form::text('pcode',null,array('class'=>'form-control')) !!}
								</div>


								<div class="col-md-6">
									<label>شهر:</label>
									{!! Form::text('city',null,array('class'=>'form-control')) !!}
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>رشته تحصیلی:</label>
									{!! Form::select('branch_id',$branch_id,null,array('class'=>'form-control')) !!}
								</div>


								<div class="col-md-6">
									<label>شاخه تحصیلی:</label>
									{!! Form::select('shakhe',$shakhe,null,array('class'=>'form-control')) !!}
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>گرایش تحصیلی:</label>
									{!! Form::select('reshte2',$grayesh,null,array('class'=>'form-control')) !!}
								</div>


								<div class="col-md-6">
									<label>دسته شغلی :</label>
									{!! Form::select('reshte3',$dasteh,null,array('class'=>'form-control')) !!}
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>ایمیل:</label>
									{!! Form::text('email',null,array('class'=>'form-control')) !!}
								</div>


								<div class="col-md-6">
									<label>تاریخ تولد:</label>
									{!! Form::text('birth_date',null,array('class'=>'form-control date')) !!}
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<div id="map" style="width: 100%;height: 200px"></div>
									{!! Form::hidden('lat',null,array('id'=>'lat')) !!}
									{!! Form::hidden('lng',null,array('id'=>'lng')) !!}
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

			<script              src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmT6KGxA4SlYEfOsZiRjqV85qZTZEsVDc">
			</script>
			<script>
				/**
				 * Google Api
				 * ==========================================
				 */
				var map;
				var marker;
				var infowindow;
				var markers=[];
				var lineSymbol;
				var line = null;
				var interval= null ;

				var lat;
				var lng

				lat = $('#lat').val();
				lng = $('#lng').val();
				$(document).ready(function(e) {

					initMap();
				});

				function initMap() {

					marker = '';

					map = new google.maps.Map(document.getElementById('map'), {
						center: {lat: 35.6835359, lng: 51.3912069},
						zoom: 11,
						gestureHandling: 'greedy'
					});


					if(lat!=''){
						marker = new google.maps.Marker({
							position: new google.maps.LatLng(lat, lng),
							map: map,
							draggable: false
						});
					}

					infowindow = new google.maps.InfoWindow;


					google.maps.event.addListener(map, 'click', function(event) {
						if (marker) {
							marker.setPosition(event.latLng)
						} else {
							marker = new google.maps.Marker({
								position: event.latLng,
								map: map,
								draggable: false
							});
						}
						$('input[name=lat]').val(marker.getPosition().lat());
						$('input[name=lng]').val(marker.getPosition().lng());
					});





				}
			</script>
@stop



@section('css')
    <link href="{{ asset('assets/admin/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/admin/css/bootstrap-select.min.css')}}" rel="stylesheet">
@stop

	
@section('js')
	<script src="{{ asset('assets/admin/js/bootstrap-select.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.fa.min.js')}}"></script>
	
    <script src="{{ asset('assets/admin/plugins/input-mask/jquery.inputmask.js')}}"></script>

    <script type="text/javascript">
		$(document).ready(function () {
			$(".date").datepicker({
				changeMonth: true,
				changeYear: true,
				isRTL: true
			});
		});
	</script>
@endsection