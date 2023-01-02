@extends('layouts.site.master')

@section('content')

	<section>
		<div class="container-fluid">
			<div class="row main-content">

				@include('layouts.site.blocks.sidebar')
				<!----------------------------------- RIGHT SIDE ------------------------------->
				<div class="col-md-8">
				@foreach($news as $row)
					<div class="box main-page">
						<div class="head">
							<h4>{{$row->title}}</h4>
						</div>
						<!-- .head -->
						<div class="body">
							<div class="post">
								<div class="row">
									<div class="col-md-4 col-sm-12">
										@if(file_exists('assets/uploads/news/medium/' . $row->image))
											<img src="{!! asset('assets/uploads/news/medium/'.$row->image) !!}" class="img-rounded img-responsive" 
											alt="{!! $row->title !!}" style="width: 254px;height: 169px;">
										@else
											<img src="{!! asset('assets/uploads/notFound.jpg') !!}"  alt="{!! $row->title !!}" class="img-rounded img-responsive"  style="width: 254px;height: 169px;">
										@endif
									</div>
									<div class="col-md-8 col-sm-12">


										<p>{{$row->content_short}}</p>

										<a href="{{URL::action('Site\NewsController@getDetails',[$row->id,Classes\Helper::seo($row->title)])}}" class="link green link-hover pull-left">مشاهده</a>
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
					@if(count($news))
						{!! $news->appends(Request::except('page'))->render() !!}
					@endif
				</center>
					
			</div>
		</div>
	</section>
   
   

@endsection