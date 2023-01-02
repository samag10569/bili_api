@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">نوع عضویت</a></li>
				</ul>
			</div>
		</div>
		<!-- /.page-navigator -->
	</div>
</section>
@stop

@section('content')


	<!----------------------------------- RIGHT SIDE ------------------------------->
		
	<div class="col-md-8">
		@include('layouts.site.blocks.help')
		<div class="box" style="margin-top:30px;">
			<div class="head">
				<h4>ارتقا عضویت </h4>

			</div>
			<!-- .head -->
			<div class="body">

			@foreach($membershipType as $item)
				<span class="product clearfix">
					<ul class="left-option pull-left clearfix">	
						@if($item->price > 0)					
							<li class="new"> {{number_format($item->price)}} ریال </li>
							<center><p class="link gray small"> {{round($item->time/30)}} ماه </p> </center>
						@else
								<p>&nbsp; </p>
						@endif
					</ul><!-- /.left-option -->
					<div class="post clearfix">
						<div class="row">
							<div class="col-md-3 col-sm-12">
							
							@if(file_exists('assets/uploads/membership-type/medium/'.$item->image) and $item->image != null)
								 <img src="{!! asset('assets/uploads/membership-type/medium/'.$item->image) !!}"  alt="{{$item->title}}" class="img-rounded img-responsive" style="width: 80%;">
							@else
								<img src="{!! asset('assets/site/images/membership.png') !!}"  alt="{{$item->title}}" class="img-rounded img-responsive" style="width: 80%;">
							@endif
									
								
							</div>
							<div class="col-md-9 col-sm-12">
							   <div class="content">
								   <h4>{{$item->title}}</h4>
								   <div>{!!$item->content!!}</div>
								</div>
								
								@if($item->price > 0 and $userInfo->membership_type_id < $item->id)
									{!! Form::open(array('action' => array('Crm\MemberShipTypeController@postBank'))) !!}
										<input type="hidden" name="membership_type_id" value="{{$item->id}}" />
										<button href="" class="link green link-hover pull-left">
										<span class="fa fa-credit-card"></span>
										خرید
										</button>
									{!! Form::close() !!}
								@endif
								
							</div>
							@if($userInfo->membership_type_id == $item->id)
								<p href="" class="link yellow pull-right"> عضویت شما {{$item->title}} می باشد.</p>
							@endif
						</div>
						<hr>
					</div><!-- /.post -->
				</span>
			@endforeach
			
			</div>
			<!-- .body -->
		</div>
		<!-- .box -->



	</div>
	@include('layouts.crm.blocks.sidebar')

@endsection
