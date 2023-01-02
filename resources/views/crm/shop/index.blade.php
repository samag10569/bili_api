@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">تخصیص خدمت</a></li>
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
				<h4>استفاده از خدمات رشد علم جوان </h4>

			</div>
			<!-- .head -->
			<div class="body">

				@foreach($cart as $row)
					<span class="product clearfix">
						<ul class="left-option pull-left clearfix">		
							@if($row->options->price_orginal == 0)
								<p class="link gray small">خدمات رایگان</p>
							@else
								@if($row->options->gold_price == 0)
									<li class="new">{{number_format($row->options->price_orginal)}} تومان</li>
								@else
									<li class="new">{{number_format($row->options->gold_price)}} تومان</li>
									<li class="old"><del>{{number_format($row->options->price_orginal)}} تومان</del></li>
								@endif
							@endif
						</ul><!-- /.left-option -->

						<div class="post clearfix">
							<div class="row">
								<div class="col-md-3 col-sm-12">
									@if(is_file('assets/uploads/allotment/medium/' . $row->options->image))
									<img src="{!!asset('assets/uploads/allotment/medium/'.$row->options->image)!!}" alt="{{$row->name}}" class="img-rounded img-responsive">
									@else
										<img src="{!! asset('assets/uploads/notFound.jpg') !!}"  alt="{{$row->name}}" class="img-rounded img-responsive">
									@endif
								</div>
								<div class="col-md-9 col-sm-12">
							   <div class="content">
								   <h4>{{$row->name}}</h4>
									<p>{{$row->options->content}}</p>
								</div>
								</div>
								@if($row->options->gold_price != 0)
									<p href="" class="link yellow pull-right"> تخفیف ویژه اعضای طلایی</p>
								@endif
							</div>
							<hr>
						</div><!-- /.post -->
					</span>
				@endforeach
				
				
				<div class="basket">
					<p>جمع کل خرید شما : 
						<span> {{ number_format($total_price) }} ریال</span>
					</p>
					<p>مبلغ پرداختی : 
						<span> {{ Cart::subtotal(0, ',', ',') }} ریال</span>
					</p>
					
					<ul>
						<li><img src="{!!asset('assets/site/images/sarmaye.png')!!}" alt=""></li>
						<li><img src="{!!asset('assets/site/images/mellat.png')!!}" alt=""></li>
					</ul>
				</div><!-- /.basket -->
				{!! Form::open(array('action' => array('Crm\ShopController@postBank'))) !!}
					<button href="" class="link blue link-hover pull-left">
					<span class="fa fa-credit-card"></span>
					پرداخت بانک
					</button>
				{!! Form::close() !!}
				
				{!! Form::open(array('action' => array('Crm\ShopController@postRemoveAllCart'))) !!}
					<button href="" class="link red link-hover pull-right">
					<span class="fa fa-trash"></span> حذف سبد خرید
					</button>
				{!! Form::close() !!}



			</div>
			<!-- .body -->
		</div>
		<!-- .box -->



	</div>
	@include('layouts.crm.blocks.sidebar')

@endsection
