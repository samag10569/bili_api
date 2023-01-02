@extends('layouts.site.master')
@section('title',$scientific->title)
@section('keywords',$scientific->keywords)
@section('description',$scientific->description)
@section('content')

	<section>
        <div class="container-fluid">
            <div class="row main-content">


                <div class="col-md-12">

                    <div class="box main-page">
                        <div class="head">
                            <h4>{{$scientific->title}}</h4>
                            <ul>
                                <span class="starRating" id="rate{{$scientific->id}}"> 	
									<input class="stars{{$scientific->id}}" id="rating5{{$scientific->id}}" type="radio" name="rating{{$scientific->id}}" value="5"> 	
									<label for="rating5{{$scientific->id}}">5</label> 			
									<input class="stars{{$scientific->id}}" id="rating4{{$scientific->id}}" type="radio" name="rating{{$scientific->id}}" value="4"> 
									<label for="rating4{{$scientific->id}}">4</label> 				
									<input class="stars{{$scientific->id}}" id="rating3{{$scientific->id}}" type="radio" name="rating{{$scientific->id}}" value="3"> 	
									<label for="rating3{{$scientific->id}}">3</label> 			
									<input class="stars{{$scientific->id}}" id="rating2{{$scientific->id}}" type="radio" name="rating{{$scientific->id}}" value="2"> 	
									<label for="rating2{{$scientific->id}}">2</label> 				
									<input class="stars{{$scientific->id}}" id="rating1{{$scientific->id}}" type="radio" name="rating{{$scientific->id}}" value="1"> 		
									<label for="rating1{{$scientific->id}}">1</label> 			
								</span>
                            </ul>
							
							
							
                        </div>
                        <!-- .head -->
                        <div class="body">
                            <ul class="bread-crumb">
                               @foreach($categories as $item)
								<li>
									<a style="text-decoration: none;" href="{{URL::action('Site\ScientificController@getIndex', $item->id)}}">
										{{$item->title}}
									</a>
								</li>
								@endforeach
                            </ul>
                            <!-- /.bread-crumb -->
                            <div class="author pull-left">ارسال شده توسط : <span>{{@$scientific->user->name.' '.@$scientific->user->family}}</span>
                            </div>
                            <!-- /.author -->



                            <div class="post">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
										@if(file_exists('assets/uploads/scientific/medium/' . $scientific->image))
											<img src="{!! asset('assets/uploads/scientific/medium/'.$scientific->image) !!}" class="img-rounded img-responsive" 
											alt="{!! $scientific->title !!}" style="width: 402px;height: 267px;">
										@else
											<img src="{!! asset('assets/uploads/notFound.jpg') !!}"  alt="{!! $scientific->title !!}" class="img-rounded img-responsive"  style="width: 402px;height: 267px;">
										@endif
                                    </div>
                                    <div class="col-md-8 col-sm-12">
										{!! $scientific->content !!}
                                    </div>
                                </div>

                            </div>
                            <!-- /.post -->
							
							
							
								

                            <span href="" class="link blue pull-left"><i class="fa fa-eye"></i> تعداد بازدید : 
							{{$scientific->hits}}
							بازدید
									<a data-original-title="Twitter" rel="tooltip"  href="https://twitter.com/home?status={{URL::current()}}" class="social-ejavan"  data-placement="left">
										<i class="fa fa-twitter"></i>
									</a>
									<a data-original-title="Facebook" rel="tooltip"  href="https://www.facebook.com/sharer/sharer.php?u={{URL::current()}}" class="" data-placement="left">
										<i class="fa fa-facebook"></i>
									</a>
									<a data-original-title="Google+" rel="tooltip"  href="https://plus.google.com/share?url={{URL::current()}}" class="social-ejavan" data-placement="left">
										<i class="fa fa-google-plus"></i>
									</a>
									
									<a data-original-title="LinkedIn" rel="tooltip"  href="https://www.linkedin.com/shareArticle?mini=true&url={{URL::current()}}&title={{$scientific->title}}&summary={{$scientific->lid}}&source={{URL::action('Site\HomeController@getIndex')}}" class="social-ejavan" data-placement="left">
										<i class="fa fa-linkedin"></i>
									</a>
									
									<a data-original-title="Pinterest" rel="tooltip" class="social-ejavan"  href="https://pinterest.com/pin/create/button/?url={{URL::current()}}&media=&description={{$scientific->lid}}" data-placement="left">
										<i class="fa fa-pinterest"></i>
									</a>
									
									<a  data-original-title="telegram" target="_blank" class="social-ejavan"  rel="tooltip" href="https://telegram.me/share/url?url={{URL::current()}}" data-placement="left">
										<i class="fa fa-telegram"></i>
									</a>
									
									<a  data-original-title="Email" rel="tooltip" class="social-ejavan"   href="mailto:?&subject={{$scientific->title}}&body={{$scientific->content}}" data-placement="left">
										<i class="fa fa-envelope"></i>
									</a>
											
							
							</span>
							
                        </div>
                        <!-- .body -->
                    </div>
                    <!-- .box -->

                    <div class="box main-page">
                        <div class="head">
                            <h4>مطالب مرتبط</h4>

                        </div>
                        <!-- .head -->
                        <div class="body">
                            <div class="row">
								@foreach($relation as $item)
                                     <div class="col-md-2 col-sm-4 col-xs-6">
										 <a href="{{URL::action('Site\ScientificController@getDetails',[$item->id,Classes\Helper::seo($item->title)])}}">
											@if(file_exists('assets/uploads/scientific/medium/' . $item->image))
												<img src="{!! asset('assets/uploads/scientific/medium/'.$item->image) !!}" class="img-responsive" 
												alt="{!! $item->title !!}" style="width: 188px;height: 124px;">
											@else
												<img src="{!! asset('assets/uploads/notFound.jpg') !!}"  alt="{!! $item->title !!}" class="img-responsive"  style="width: 188px;height: 124px;">
											@endif
											<center>
												<h4>{!! $item->title !!}</h4>
											</center>
										</a>
									</div>
								@endforeach
                            </div>

                        </div>
                        <!-- .body -->
                    </div>
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
                    @if(Auth::user())
                    <div class="box hasForm" style="margin-top:20px;">
                        <div class="head">
                            <h4>افزودن دیدگاه</h4>

                        </div>
                        <!-- .head -->
                        <div class="body">
                            {!! Form::open(array('action' => array('Site\ScientificController@postComment',$scientific->id),'role' => 'form','files' => 'true','id' => 'comment_form')) !!}
                            <div class="profile">
                                <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12">
                                        <img src="images/profile.jpg" alt="" class="avatar">
                                        <span class="author">{{Auth::user()->name}}</span>
                                        <span class="field">{{@Auth::user()->info->branch}}</span>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 ">
                                        <textarea class="form-control" rows="5" name="comment" id="comment"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button class="link blue link-hover pull-left">ذخیره</button>
                            {!! Form::close() !!}

                        </div>
                        <!-- .body -->
                    </div>
                    <!-- .box -->
                    @endif
                    <div class="box hasForm" style="margin-top:20px;">
                        <div class="head">
                            <h4>دیدگاه ها</h4>

                        </div>
                        <!-- .head -->
                        <div class="body">
                            <div class="container">
                                <div class="post-comments">



                                    <div class="comments-nav">
                                        <ul class="nav nav-pills">
                                            <li role="presentation" class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                 5 نظر وجود دارد <span class="caret"></span>
                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#">بهترین ها</a>
                                                    </li>
                                                    <li><a href="#">آخرین ها</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="row">
                                        @if($scientific->comments)
                                        @foreach($scientific->comments as $sc)
                                                @include('site.scientific.comment', ['sc'=>$sc])
                                        @endforeach
                                        @endif
                                    </div>

                                </div>
                                <!-- post-comments -->
                            </div>
                        </div>
                        <!-- .body -->
                    </div>
                    <!-- .box -->




                </div>

            </div>
        </div>
    </section>
   
   

@endsection

@section('js')  
   <script>    
		 $(document).ready(function(){ 
			 $('input[type=radio][name=rating{{$scientific->id}}]').change(        
				 function(){                       
					 var rate = $('input[name=rating{{$scientific->id}}]:checked').val()  
					 $.ajax({               
						url: " {{URL::action('Site\ScientificController@getRate',[$scientific->id])}}",
						data: 'rate='+rate
					 });           
				 }         
			 );      
		 });   
	</script>
@endsection