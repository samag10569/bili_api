<div class="box-body">
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label>عنوان:</label>
				{!! Form::text('name',null,array(
					'class'=>'form-control',
					'placeholder'=>'عنوان را وارد کنید . . .')) !!}
			</div>
			<div class="col-md-6" style="margin-top: 25px;">
				{!! Form::checkbox('select_all',1,null,array('id'=>'select_all')) !!}
					<span class="text">انتخاب همه</span>
			</div>
		</div>
	</div>
	
	<hr>
	
	<ul class="nav nav-tabs " style="padding-right:0px">
		<li class="active">
			<a data-toggle="tab" href="#admin"> admin </a>
		</li>
		<li>
			<a data-toggle="tab" href="#out"> out </a>
		</li>
	</ul>
	<div class="tab-content">
		<div id="admin" class="tab-pane active">

			<div class="form-group">
				<?php 
					if(isset($data->permission)){
						$accessDB = unserialize($data->permission);
					}else{
						$accessDB = [];
					}
				?>
				@foreach(Config::get('site.permisions') as $key=>$value)
					<div class="widget col-md-6" style="background-color: rgb(248, 248, 248); border: medium solid;">
						<div class="widget-header bordered-bottom bordered-themesecondary">
							<i class="widget-icon fa fa-unlock-alt themesecondary"></i>
							<span class="widget-caption themesecondary" style="color: #3c8dbc;">{{{ $value['title'] }}}</span>
						</div>
						<!--Widget Header-->
						<div class="widget-body">
							<div class="widget-main no-padding">
								<div class="tickets-container" style="height: 150px;">
									@foreach($value['access'] as $keyAccess => $access)
										<?php
											$check = 0;
											if(isset($accessDB[$key][$keyAccess])) {
												$check = 1;
											}
										?>
										<div class="col-md-6">
											{!! Form::checkbox('access['.$key.']['.$keyAccess.']',1,$check) !!}

											<span class="text">{{{ $access }}}</span>
											
										</div>
									@endforeach
									
									
									<div class="checkbox" style="display: none;">
										<label style="padding-left: 0px;">
											{!! Form::checkbox('access[users][changePassword]',1,1) !!}
										</label>
									</div>
									
									<br/>
								</div>

							</div>
						</div>
					</div>
				@endforeach
			</div>
			
		</div>
		<div id="out" class="tab-pane">
</br>
			<div class="form-group">
				<?php 
					if(isset($data->permission)){
						$accessDB = unserialize($data->permission);
					}else{
						$accessDB = [];
					}
				?>
				<div class="row">
					<div class="col-md-12">
						@foreach(Config::get('site.permisionsOut') as $key=>$value)
							<div class="widget col-md-6" style="background-color: rgb(248, 248, 248); border: medium solid;">
								<div class="widget-header bordered-bottom bordered-themesecondary">
									<i class="widget-icon fa fa-unlock-alt themesecondary"></i>
									<span class="widget-caption themesecondary" style="color: #3c8dbc;">{{{ $value['title'] }}}</span>
								</div>
								<!--Widget Header-->
								<div class="widget-body">
									<div class="widget-main no-padding">
										<div class="tickets-container" style="height: 150px;">
											@foreach($value['access'] as $keyAccess => $access)
												<?php
													$check = 0;
													if(isset($accessDB[$key][$keyAccess])) {
														$check = 1;
													}
												?>
												<div class="col-md-6">
													{!! Form::checkbox('access['.$key.']['.$keyAccess.']',1,$check) !!}

													<span class="text">{{{ $access }}}</span>
													
												</div>
											@endforeach
											
											
											<div class="checkbox" style="display: none;">
												<label style="padding-left: 0px;">
													{!! Form::checkbox('access[users][changePassword]',1,1) !!}
												</label>
											</div>
											
											<br/>
										</div>

									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
			
			<hr>
			
			
				@php
					$accessAllotment =  [
					'totalWaiting' => 'انتظار کل',
					'accepted' => 'تایید شده',
					'totalRejected' => 'رد شده کل',
					'waitingWings' => 'انتظار بال',
					'rejectedWings' => 'رد شده بال',
					'edit' => 'ویرایش',
					];
				@endphp
				@foreach($allotment_category as $row)
					<div class="form-group ejavan_title">
						{{$row->title}}
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
						@foreach($row->allotment as $value)
						@php $key = 'allotment'.$value->id; @endphp
							<div class="widget col-md-3" style="background-color: rgb(248, 248, 248); border: medium solid;">
								<div class="widget-header bordered-bottom bordered-themesecondary" style="height: 40px;">
									<i class="widget-icon fa fa-unlock-alt themesecondary"></i>
									<span class="widget-caption themesecondary" style="color: #3c8dbc;">{{{ $value['title'] }}}</span>
								</div>
								<!--Widget Header-->
								<div class="widget-body">
									<div class="widget-main no-padding">
										<div class="tickets-container" style="height: 110px;padding-top: 10px;">
											@foreach($accessAllotment as $keyAccess => $access)
												<?php
													$check = 0;
													if(isset($accessDB[$key][$keyAccess])) {
														$check = 1;
													}
												?>
												<div class="col-md-6">
													{!! Form::checkbox('access['.$key.']['.$keyAccess.']',1,$check) !!}

													<span class="text">{{{ $access }}}</span>
													
												</div>
											@endforeach
											
											
											<div class="checkbox" style="display: none;">
												<label style="padding-left: 0px;">
													{!! Form::checkbox('access[users][changePassword]',1,1) !!}
												</label>
											</div>
											
											<br/>
										</div>

									</div>
								</div>
							</div>
						@endforeach
						</div>
					</div>	
				</div>
			@endforeach
			
			<div class="checkbox" style="display: none;">
				<label style="padding-left: 0px;">
					{!! Form::checkbox('access[allotment][caller]',1,1) !!}
				</label>
			</div>
			
		</div>
	</div>
									
										
	
	
  <div class="box-footer">
	<button type="submit" class="btn btn-primary">ذخیره</button>
  </div>