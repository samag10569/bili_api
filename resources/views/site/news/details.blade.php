@extends('layouts.site.master')
@section('title',$news->title)
@section('keywords',$news->keywords)
@section('description',$news->description)
@section('content')

	<section>
        <div class="container-fluid">
            <div class="row main-content">


                <div class="col-md-12">

                    <div class="box main-page">
                        <div class="head">
                            <h4>{{$news->title}}</h4>	
                        </div>
                        <!-- .head -->
                        <div class="body">
                            <div class="post">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
										@if(file_exists('assets/uploads/news/medium/' . $news->image))
											<img src="{!! asset('assets/uploads/news/medium/'.$news->image) !!}" class="img-rounded img-responsive" 
											alt="{!! $news->title !!}" style="width: 402px;">
										@else
											<img src="{!! asset('assets/uploads/notFound.jpg') !!}"  alt="{!! $news->title !!}" class="img-rounded img-responsive"  style="width: 402px;">
										@endif
                                    </div>
                                    <div class="col-md-8 col-sm-12">
										{!! $news->content !!}
                                    </div>
                                </div>

                            </div>
                            <!-- /.post -->

                            <span href="" class="link blue pull-left"><i class="fa fa-eye"></i> تعداد بازدید : 
							{{$news->hits}}
							بازدید
									<a data-original-title="Twitter" rel="tooltip"  href="https://twitter.com/home?status={{URL::current()}}" class="social-ejavan" data-placement="left">
										<i class="fa fa-twitter"></i>
									</a>
									<a data-original-title="Facebook" rel="tooltip"  href="https://www.facebook.com/sharer/sharer.php?u={{URL::current()}}" class="social-ejavan" data-placement="left">
										<i class="fa fa-facebook"></i>
									</a>
									<a data-original-title="Google+" rel="tooltip"  href="https://plus.google.com/share?url={{URL::current()}}" class="social-ejavan" data-placement="left">
										<i class="fa fa-google-plus"></i>
									</a>
									
									<a data-original-title="LinkedIn" rel="tooltip"  href="https://www.linkedin.com/shareArticle?mini=true&url={{URL::current()}}&title={{$news->title}}&summary={{$news->lid}}&source={{URL::action('Site\HomeController@getIndex')}}" class="social-ejavan" data-placement="left">
										<i class="fa fa-linkedin"></i>
									</a>
									
									<a data-original-title="Pinterest" class="social-ejavan" rel="tooltip" href="https://pinterest.com/pin/create/button/?url={{URL::current()}}&media=&description={{$news->lid}}" data-placement="left">
										<i class="fa fa-pinterest"></i>
									</a>
									
									<a  data-original-title="telegram" target="_blank" rel="tooltip"  class="social-ejavan" href="https://telegram.me/share/url?url={{URL::current()}}" data-placement="left">
										<i class="fa fa-telegram"></i>
									</a>
									
									<a  data-original-title="Email" rel="tooltip" class="social-ejavan" href="mailto:?&subject={{$news->title}}&body={{$news->content}}" data-placement="left">
										<i class="fa fa-envelope"></i>
									</a>
											
							
							</span>
							
                        </div>
                        <!-- .body -->
                    </div>
                    <!-- .box -->
                    <!-- .box -->
                    <div class="box hasForm">
                        <div class="head">
                            <h4>لغات کلیدی</h4>

                        </div>
                        <!-- .head -->
                        <div class="body">
                            <div class="profile">
                                <div class="labels">
								@foreach($keywords as $item)
                                    <span>{{$item}}</span>
								@endforeach
                                </div>
                            </div>
                            <!-- /.profile -->

                        </div>
                        <!-- .body -->
                    </div>
                    <!-- .box -->
                </div>

            </div>
        </div>
    </section>
   
   

@endsection
