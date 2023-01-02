@extends('layouts.site.master')
@section('title',$pages->title)
@section('content')

	<section>
        <div class="container-fluid">
            <div class="row main-content">


                <div class="col-md-12">

                    <div class="box main-page">
                        <div class="head">
                            <h4>{{$pages->title}}</h4>	
                        </div>
                        <!-- .head -->
                        <div class="body">
                            <div class="post">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
										@if(file_exists('assets/uploads/page/medium/' . $pages->image))
											<img src="{!! asset('assets/uploads/page/medium/'.$pages->image) !!}" class="img-rounded img-responsive" 
											alt="{!! $pages->title !!}" style="width: 402px;height: 267px;">
										@else
											<img src="{!! asset('assets/uploads/notFound.jpg') !!}"  alt="{!! $pages->title !!}" class="img-rounded img-responsive"  style="width: 402px;height: 267px;">
										@endif
                                    </div>
                                    <div class="col-md-8 col-sm-12">
										{!! $pages->content !!}
                                    </div>
                                </div>

                            </div>
                            <!-- /.post -->

                        </div>
                        <!-- .body -->
                    </div>
                    <!-- .box -->
                </div>

            </div>
        </div>
    </section>
   
   

@endsection
