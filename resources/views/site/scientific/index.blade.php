@extends('layouts.site.master')

@section('map')
	<section>
		<div class="container-fluid">
			<div class="row page-navigator">
				<div class="col-md-12">
					<ul>
						<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
						<li><a href="/">صفحه اصلی</a></li><span>/</span>
						<li><a href="">مطالب علمی</a></li>
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

				@include('layouts.site.blocks.sidebar')
				<!----------------------------------- RIGHT SIDE ------------------------------->
				<div class="col-md-8">
				@foreach($scientific as $row)
					<div class="box main-page">
						<div class="head">
							<h4>{{$row->title}}</h4>
							<ul>
								<li>
									<div class="star-five active"></div>
								</li>
								<li>
									<div class="star-five active"></div>
								</li>
								<li>
									<div class="star-five active"></div>
								</li>
								<li>
									<div class="star-five"></div>
								</li>
								<li>
									<div class="star-five"></div>
								</li>
							</ul>
						</div>
						<!-- .head -->
						<div class="body">
							<ul class="bread-crumb">
							@foreach($categories[$row->id] as $item)
								<li>
									<a style="text-decoration: none;" href="{{URL::action('Site\ScientificController@getIndex', $item->id)}}">
										{{$item->title}}
									</a>
								</li>
							@endforeach
							</ul>
							<!-- /.bread-crumb -->
							<div class="author pull-left">ارسال شده توسط : <span>{{@$row->user->name.' '.@$row->user->family}}</span></div>
							<!-- /.author -->



							<div class="post">
								<div class="row">
									<div class="col-md-4 col-sm-12">
										@if(file_exists('assets/uploads/scientific/medium/' . $row->image))
											<img src="{!! asset('assets/uploads/scientific/medium/'.$row->image) !!}" class="img-rounded img-responsive" 
											alt="{!! $row->title !!}" style="width: 254px;height: 169px;">
										@else
											<img src="{!! asset('assets/uploads/notFound.jpg') !!}"  alt="{!! $row->title !!}" class="img-rounded img-responsive"  style="width: 254px;height: 169px;">
										@endif
									</div>
									<div class="col-md-8 col-sm-12">


										<p>{{$row->content_short}}</p>

										<a href="{{URL::action('Site\ScientificController@getDetails',[$row->id,Classes\Helper::seo($row->title)])}}" class="link green link-hover pull-left">مشاهده</a>
									</div>
								</div>

							</div>
							<!-- /.post -->

							<span href="" class="link green link-hover pull-right"><i class="fa fa-eye"></i> تعداد بازدید : 
							{{$row->hits}}
							بازدید</span>
						</div>
						<!-- .body -->
					</div>
					<!-- .box -->
				@endforeach
					
				</div>
				<!----------------------------------- RIGHT SIDE ------------------------------->
				
				 <center>
					@if(count($scientific))
						{!! $scientific->appends(Request::except('page'))->render() !!}
					@endif
				</center>

			</div>
		</div>
	</section>
   
   

@endsection