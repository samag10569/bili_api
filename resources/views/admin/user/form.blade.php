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
				<label>ایمیل:</label>
				{!! Form::email('email',null,array(
				'class'=>'form-control',
				'placeholder'=>'ایمیل را وارد کنید . . .')) !!}
			</div>
			<div class="col-md-6">
				<label>وضعیت:</label>
				{!! Form::select('status',$status,null,array(
					'class'=>'form-control')) !!}
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label>رمز:</label>
				{!! Form::password('password',array(
					'class'=>'form-control',
					'placeholder'=>'رمز را وارد کنید . . .')) !!}
			</div>
			<div class="col-md-6">
				<label>تکرار رمز:</label>
				{!! Form::password('repassword',array(
					'class'=>'form-control',
					'placeholder'=>'تکرار رمز را وارد کنید . . .')) !!}
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
					<img src="{!!asset('assets/uploads/user/medium/'.$data->image)!!}"
							class="img-rounded"
							style="width: 100px; height: 60px;">
				@endif
			</div>
			<div class="col-md-2">
				{!! Form::checkbox('admin', 1) !!}
				<span style="margin: 2px;"> دسترسی به admin </span>
			</div>
			<div class="col-md-2">
				{!! Form::checkbox('out', 1) !!}
				<span style="margin: 2px;"> دسترسی به out </span>
			</div>
		</div>
	</div>
										
										
	<div class="form-group">
		<label>گروه کاربری:</label>
		<div class="row">
				@foreach($groups as $group)
					
					<div class="col-md-6">
						{!! Form::checkbox('group[]', $group->id, in_array($group->id, $groupsId)) !!}
						<span style="margin: 2px;"> {{ $group->name }} </span>
					
					</div>
				@endforeach
			</div>
		</div>
	
  <div class="box-footer">
	<button type="submit" class="btn btn-primary">ذخیره</button>
  </div>