@extends ("layouts.admin.master")
@section('title','ویرایش')
@section('part','ویرایش')
	@section('content')
		<div class="row">
			<div class="col-md-12">
			  <!-- general form elements -->
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">ویرایش</h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				@include('layouts.admin.blocks.message')
				 {!! Form::model($data,array('action' => array('Admin\EmailExcelController@postEdit',$data->id),'role' => 'form','id' => 'ejavan_form','class' => 'form-horizontal')) !!}
			  
					<div class="box-body">
						<div class="form-group">
							{!! Form::label('count','تعداد ارسال',array('class'=>'col-lg-2 control-label')) !!}
							<div class="col-lg-4">
								{!! Form::text('count',null,array('class'=>'form-control','placeholder' => 'تعداد ارسال در هر بار')) !!}
							</div>
							{!! Form::label('sender','ارسال کننده',array('class'=>'col-lg-2 control-label')) !!}
							<div class="col-lg-4">
								{!! Form::text('sender',null,array('class'=>'form-control','placeholder' => 'ایمیل ارسال کننده')) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('subject','عنوان',array('class'=>'col-lg-2 control-label')) !!}
							<div class="col-lg-10">
								{!! Form::text('subject',null,array('class'=>'form-control','placeholder' => 'عنوان')) !!}
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
	