<div class="box-body">
    <div class="form-group">
			<div class="row">
				<div class="col-md-12">
					<label>عنوان:</label>
					{!! Form::text('title',null,array(
						'class'=>'form-control',
						'placeholder'=>'عنوان را وارد کنید . . .')) !!}
				</div>
			</div>
		</div>
		   <div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label>هزینه:</label>
					{!! Form::text('price',null,array(
						'class'=>'form-control',
						'placeholder'=>'هزینه را وارد کنید . . .')) !!}
				</div>

				<div class="col-md-6">
					<label>روز:</label>
					{!! Form::text('time',null,array(
						'class'=>'form-control',
						'placeholder'=>'روز را وارد کنید . . .')) !!}
				</div>

			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label>تصویر :</label>
					{!! Form::file('image',array(
						'class'=>'form-control')) !!}
				</div>
				<div class="col-md-2">
					@if(isset($data))
						@if(file_exists('assets/uploads/membership-type/medium/'.$data->image))
							<img src="{!! asset('assets/uploads/membership-type/medium/'.$data->image) !!}"
								 class="img-rounded"
								 style="width: 100px; height: 60px;">
						@else
							<img src="{!! asset('assets/uploads/notFound.jpg') !!}"
								 class="img-rounded"
								 style="width: 100px; height: 60px;">
						@endif
					@endif
				</div>
				<div class="col-md-4">
				</div>
			</div>
		</div>


		<div class="form-group">
			<div class="row">
				<div class="col-md-12">
				<label>توضیحات:</label>
				{!! Form::textarea('content',null,array(
					'class'=>'form-control ckeditor',)) !!}
				</div>
			</div>
		</div>

        <div class="col-md-4 ejavan_col">
            <button type="submit" class="btn btn-primary">ذخیره</button>
        </div>
    </div>
</div>
