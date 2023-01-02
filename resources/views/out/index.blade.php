@extends ("layouts.out.master")
	@section('content')
	
	<!-- Small boxes (Stat box) -->
	  <div class="row">
	  @include('layouts.out.blocks.message')
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-aqua">
			<div class="inner">
			  <h3>۱۵۰</h3>
			  <p>سفارش جدید</p>
			</div>
			<div class="icon">
			  <i class="fa fa-tag"></i>
			</div>
			<a href="#" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
		  </div>
		</div><!-- ./col -->
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-green">
			<div class="inner">
			  <h3>۵۳<sup style="font-size: 20px">%</sup></h3>
			  <p>افزایش آمار</p>
			</div>
			<div class="icon">
			  <i class="fa fa-bars"></i>
			</div>
			<a href="#" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
		  </div>
		</div><!-- ./col -->
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-yellow">
			<div class="inner">
			  <h3>۴۴</h3>
			  <p>کاربر ثبت نام کرده</p>
			</div>
			<div class="icon">
			  <i class="fa fa-user"></i>
			</div>
			<a href="#" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
		  </div>
		</div><!-- ./col -->
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-red">
			<div class="inner">
			  <h3>۶۵</h3>
			  <p>بازدید کننده یکتا</p>
			</div>
			<div class="icon">
			  <i class="fa fa-calendar"></i>
			</div>
			<a href="#" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
		  </div>
		</div><!-- ./col -->
	  </div><!-- /.row -->
	  
	  
	  <!-- Main row -->
	  <div class="row">
		
	  </div><!-- /.row (main row) -->
	@stop