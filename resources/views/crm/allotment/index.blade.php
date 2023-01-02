@extends('layouts.site.master')

@section('map')
	<section>
		<div class="container-fluid">
			<div class="row page-navigator">
				<div class="col-md-12">
					<ul>
						<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
						<li><a href="/">صفحه اصلی</a></li><span>/</span>
						<li><a href="">خدمات</a></li>
					</ul>
				</div>
			</div>
			<!-- /.page-navigator -->
		</div>
	</section>
@stop

@section('content')

	<section>
		<div class="container-fluid">
			<div class="row main-content">

			
				@include('layouts.site.blocks.sidebar-allotment')
				<!----------------------------------- RIGHT SIDE ------------------------------->
				<div class="col-md-8">
					<div class="box">
						<div class="head">
							<h4>استفاده از خدمات رشد علم جوان </h4>

						</div>
						<!-- .head -->
						<div class="body">
						@foreach($allotment as $row)
							<span class="product clearfix">
								<ul class="left-option pull-left clearfix">		
									@if($row->price == 0)
										<p class="link gray small">خدمات رایگان</p>
									@else
										@if($row->gold_price == 0)
											<li class="new">{{number_format($row->price)}} ریال</li>
										@else
											<li class="new">{{number_format($row->gold_price)}} ریال</li>
											<li class="old"><del>{{number_format($row->price)}} ریال</del></li>
										@endif
									@endif
								</ul><!-- /.left-option -->

											
								<div class="post clearfix">
									<div class="row">
										<div class="col-md-3 col-sm-12">
											@if(file_exists('assets/uploads/allotment/medium/'.$row->image) and $row->image != null)
											<img src="{!!asset('assets/uploads/allotment/medium/'.$row->image)!!}" alt="{{$row->title}}" class="img-rounded img-responsive">
											@else
												<img src="{!! asset('assets/uploads/notFound.jpg') !!}"  alt="{{$row->title}}" class="img-rounded img-responsive">
											@endif
										</div>
										<div class="col-md-9 col-sm-12">
									   <div class="content">
										   <h4>{{$row->title}}</h4>
											<p>{{$row->content}}</p>
										</div>

											<a href="{{URL::action('Crm\AllotmentController@getDetails', $row->id)}}" class="link blue small link-hover  pull-left"> مطالعه بیشتر ...</a>
											@php
												$checkAllotment = Classes\UserCheck::checkAllotment(Auth::id(),$row->id);
											@endphp
											@if(!$checkAllotment)
												@if($row->price != 0)
													
													{!! Form::open(array('action' => array('Crm\ShopController@postAddCart'))) !!}
														<input type="hidden" value="{{$row->id}}" name="allotment_id" />
														<button href="" class="link green  buy link-hover pull-left"> افزودن به سبد خرید</button>
													{!! Form::close() !!}
													
												@else
													
													{!! Form::open(array('action' => array('Crm\ShopController@postAddCart'))) !!}
														<input type="hidden" value="{{$row->id}}" name="allotment_id" />
														<button href="" class="link green  small link-hover pull-left"> درخواست خدمت</button>
													{!! Form::close() !!}
												
												@endif
												
											@elseif($checkAllotment == 2)
												<button href="" class="link green  small link-hover pull-left">خدمت به شما تعلق گرفته است</button>
											@else
												<button href="" class="link green  small link-hover pull-left">در انتطار تایید از سمت مدیریت</button>
											@endif

										</div>
										@if($row->gold_price != 0)
											<p href="" class="link yellow pull-right"> تخفیف ویژه اعضای طلایی</p>
										@endif
									</div>
									<hr>
								</div><!-- /.post -->
							</span>
						@endforeach
					
						</div>
					</div>
				</div>
				<!----------------------------------- RIGHT SIDE ------------------------------->
				
				 <center>
					@if(count($allotment))
						{!! $allotment->appends(Request::except('page'))->render() !!}
					@endif
				</center>

			</div>
		</div>
	</section>
   
   

@endsection