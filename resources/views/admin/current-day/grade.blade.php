@extends ("layouts.admin.master")
@section('title','تعیین گرید علمی')
@section('part','تعیین گرید علمی')
@section('content')
	<div class="row">
		<div class="col-md-12">
		  <!-- general form elements -->
		  <div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">تعیین گرید علمی  {{$user->name.' '.$user->family}}</h3>
			  <h3 class="box-title" style="float: left;">	
				<button class="btn btn-block bg-olive btn-lg">{{$user->user_code}}</button>
			  </h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			@include('layouts.admin.blocks.message')
			{!! Form::model($grade_data,array('action' => array('Admin\CurrentDayMemberController@postGrade',$user->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
			   @include('admin.current-day.form')
			{!! Form::close() !!}
		  </div><!-- /.box -->
		</div>
	</div>
@stop

	