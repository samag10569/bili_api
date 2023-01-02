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
				<label>نام پدر:</label>
				{!! Form::text('father_name',null,array(
					'class'=>'form-control',
					'placeholder'=>'نام پدر را وارد کنید . . .')) !!}
			</div>
			<div class="col-md-6">
				<label>تاریخ تولد:</label>
				{!! Form::text('birth',null,array(
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
				{!! Form::text('national_id',null,array(
					'class'=>'form-control',
					'data-inputmask'=>"'mask': ['9999999999']",
					'data-mask'=>"",
					'placeholder'=>'کد ملی را وارد کنید . . .')) !!}
			</div>
			<div class="col-md-6">
				<label>شماره همراه:</label>
				{!! Form::text('mobile',null,array(
					'class'=>'form-control',
					'data-inputmask'=>"'mask': ['99999999999']",
					'data-mask'=>"",
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
				'placeholder'=>'ایمیل را وارد کنید . . .')) !!}
			</div>
			<div class="col-md-6 ejavan_col">
				<label>نوع مصاحبه:</label>
				&nbsp;&nbsp;&nbsp;
				{!!Form::radio('interview_type_id', 1, true)!!}
				<label>حضوری</label>
				&nbsp;&nbsp;&nbsp;
				{!!Form::radio('interview_type_id', 0)!!}
				<label>غیر حضوری</label>
				
			</div>
		</div>
	</div>
	
	<div class="form-group date_interview_box">
		<div class="row">
			<div class="col-md-6">
				<label>تاریخ مصاحبه:</label>
				{!! Form::text('date_interview',null,array(
					'class'=>'form-control',
					'id'=>'date_interview',
					'placeholder'=>'تاریخ مصاحبه را وارد کنید . . .')) !!}
			</div>
			<div class="col-md-6">
				<label>ساعت مصاحبه:</label>
				{!! Form::text('time_interview',null,array(
					'class'=>'form-control',
					'data-inputmask'=>"'mask': ['99:99']",
					'data-mask'=>"",
					'placeholder'=>'ساعت مصاحبه را وارد کنید . . .')) !!}
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
				{!! Form::text('branch',null,array(
				'class'=>'form-control',
				'placeholder'=>'رشته تحصیلی را وارد کنید . . .')) !!}
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label>استان:</label>
				{!! Form::select('state_id',$state_id,null,array('class'=>'form-control')) !!}
			</div>
			<div class="col-md-6">
				<label>کدپستی:</label>
				{!! Form::text('postal_code',null,array(
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
				{!! Form::text('city',null,array(
				'class'=>'form-control',
				'placeholder'=>'آدرس را وارد کنید . . .')) !!}
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<div class="col-md-2">
				<label>گزینه ها:</label>
			</div>
			<div class="col-md-2">
				{!!Form::checkbox('article', 1, null, ['id'=>'article'])!!}
				&nbsp;
				<label>مقاله دارد</label>
			</div>
			<div class="col-md-2">
				{!!Form::checkbox('invention', 1, null, ['id'=>'invention'])!!}
				&nbsp;
				<label>ثبت اختراع دارد </label>
			</div>
			<div class="col-md-2">
				{!!Form::checkbox('ideas', 1, null, ['id'=>'ideas'])!!}
				&nbsp;
				<label>ایده دارد </label>
			</div>
			<div class="col-md-2">
				{!!Form::checkbox('expertise', 1, null, ['id'=>'expertise'])!!}
				&nbsp;
				<label>تخصص دارد </label>
			</div>
			<div class="col-md-2">
			</div>
		</div>
	</div>
	
	
	<div class="form-group article_title">
		<div class="row">
			<div class="col-md-12">
				<label>عنوان مقاله:</label>
				{!! Form::text('article_title',null,array(
				'class'=>'form-control',
				'id'=>'article_title',
				'placeholder'=>'عنوان مقاله را وارد کنید . . .')) !!}
			</div>
		</div>
	</div>
	
	 
	<div class="form-group invention_title">
		<div class="row">
			<div class="col-md-12">
				<label>عنوان اختراع:</label>
				{!! Form::text('invention_title',null,array(
				'class'=>'form-control',
				'id'=>'invention_title',
				'placeholder'=>'عنوان اختراع را وارد کنید . . .')) !!}
			</div>
		</div>
	</div>
	
	
	<div class="form-group ideas_title">
		<div class="row">
			<div class="col-md-12">
				<label>عنوان ایده:</label>
				{!! Form::text('ideas_title',null,array(
				'class'=>'form-control',
				'id'=>'ideas_title',
				'placeholder'=>'عنوان ایده را وارد کنید . . .')) !!}
			</div>
		</div>
	</div>
	
	<div class="form-group expertise">
		<label>عنوان تخصص ها (توانایی ها ) را وارد کنید:</label>
		<select name="skills[]" class="selectpicker form-control" multiple>
			@foreach($skills as $item)
				<option value="{{$item->id}}" @if(in_array($item->id, $skillId)) selected @endif>{{$item->title}}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col-md-12">
				<label>توضیحات اضافی:</label>
				{!! Form::textarea('content',null,array(
				'class'=>'form-control',
				'placeholder'=>'توضیحات اضافی را وارد کنید . . .')) !!}
			</div>
		</div>
	</div>
	
	
  <div class="box-footer">
	<button type="submit" class="btn btn-primary">ذخیره</button>
  </div>