@extends('layouts.site.master')
@section('title',$allotment->title)
@section('content')

	<section>
        <div class="container-fluid">
            <div class="row main-content">


				@include('layouts.site.blocks.sidebar-allotment')
				<!----------------------------------- RIGHT SIDE ------------------------------->
				<div class="col-md-8">

                    <div class="box main-page">
                        <div class="head">
                            <h4>{{$allotment->title}}</h4>
							
							
                        </div>
                        <!-- .head -->
                        <div class="body">
                            <ul class="bread-crumb">
							
								<li>
									<a style="text-decoration: none;" href="{{URL::action('Crm\AllotmentController@getIndex', @$allotment->category_id)}}">
										{{@$allotment->category->title}}
									</a>
								</li>
								
                            </ul>
                            <!-- /.bread-crumb -->
							
								<ul class="left-option pull-left clearfix">		
									@if($allotment->price == 0)
										<p class="link gray small">خدمات رایگان</p>
									@else
										@if($allotment->gold_price == 0)
											<li class="new">{{number_format($allotment->price)}} ریال</li>
										@else
											<li class="new">{{number_format($allotment->gold_price)}} ریال</li>
											<li class="old"><del>{{number_format($allotment->price)}} ریال</del></li>
										@endif
									@endif
								</ul><!-- /.left-option -->


                            <div class="post">
							
                                <div class="row">
									<div class="col-md-4 col-sm-12">
										@if(file_exists('assets/uploads/allotment/medium/' . $allotment->image) and $allotment->image != null and $allotment->image != '')
											<img src="{!! asset('assets/uploads/allotment/medium/'.$allotment->image) !!}" class="img-rounded img-responsive" 
											alt="{!! $allotment->title !!}" style="width: 402px;">
										@else
											<img src="{!! asset('assets/uploads/notFound.jpg') !!}"  alt="{!! $allotment->title !!}" class="img-rounded img-responsive"  style="width: 402px;">
										@endif
                                    </div>
                                    <div class="col-md-8 col-sm-12" style="text-align: justify;padding: 20px;">
										{!! $allotment->content !!}
                                    </div>
                                </div>
									</br>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
										{!! $allotment->description !!}
                                    </div>
                                </div>

                            </div>
                            <!-- /.post -->
							
							<span href="" class="link blue pull-right">
									<a data-original-title="Twitter" rel="tooltip"  href="https://twitter.com/home?status={{URL::current()}}" class="social-ejavan" data-placement="left">
										<i class="fa fa-twitter"></i>
									</a>
									<a data-original-title="Facebook" rel="tooltip"  href="https://www.facebook.com/sharer/sharer.php?u={{URL::current()}}" class="social-ejavan" data-placement="left">
										<i class="fa fa-facebook"></i>
									</a>
									<a data-original-title="Google+" rel="tooltip"  href="https://plus.google.com/share?url={{URL::current()}}" class="social-ejavan" data-placement="left">
										<i class="fa fa-google-plus"></i>
									</a>
									
									<a data-original-title="LinkedIn" rel="tooltip"  href="https://www.linkedin.com/shareArticle?mini=true&url={{URL::current()}}&title={{$allotment->title}}&summary={{$allotment->lid}}&source={{URL::action('Site\HomeController@getIndex')}}" class="social-ejavan" data-placement="left">
										<i class="fa fa-linkedin"></i>
									</a>
									
									<a data-original-title="Pinterest" class="social-ejavan" rel="tooltip" href="https://pinterest.com/pin/create/button/?url={{URL::current()}}&media=&description={{$allotment->lid}}" data-placement="left">
										<i class="fa fa-pinterest"></i>
									</a>
									
									<a  data-original-title="telegram" target="_blank" rel="tooltip"  class="social-ejavan" href="https://telegram.me/share/url?url={{URL::current()}}" data-placement="left">
										<i class="fa fa-telegram"></i>
									</a>
									
									<a  data-original-title="Email" rel="tooltip" class="social-ejavan" href="mailto:?&subject={{$allotment->title}}&body={{$allotment->content}}" data-placement="left">
										<i class="fa fa-envelope"></i>
									</a>
											
							
							</span>
							
							
			
							@php
								$checkAllotment = Classes\UserCheck::checkAllotment(Auth::id(),$allotment->id);
							@endphp
							@if(!$checkAllotment)
								@if($allotment->price != 0)
									
									{!! Form::open(array('action' => array('Crm\ShopController@postAddCart'))) !!}
										<input type="hidden" value="{{$allotment->id}}" name="allotment_id" />
										<button href="" class="link green  buy link-hover pull-left"> افزودن به سبد خرید</button>
									{!! Form::close() !!}
									
								@else
									
									{!! Form::open(array('action' => array('Crm\ShopController@postAddCart'))) !!}
										<input type="hidden" value="{{$allotment->id}}" name="allotment_id" />
										<button href="" class="link green  small link-hover pull-left"> درخواست خدمت</button>
									{!! Form::close() !!}
								
								@endif
								
							@elseif($checkAllotment == 2)
								<button href="" class="link green  small link-hover pull-left">خدمت به شما تعلق گرفته است</button>
							@else
								<button href="" class="link green  small link-hover pull-left">در انتطار تایید از سمت مدیریت</button>
							@endif

						</div>
						@if($allotment->gold_price != 0)
							<p href="" class="link yellow pull-right"> تخفیف ویژه اعضای طلایی</p>
						@endif
						
						
						
                        </div>
                        <!-- .body -->
                    </div>
                    <!-- .box -->
					
					

                </div>

            </div>
        </div>
    </section>
   
   

@endsection
