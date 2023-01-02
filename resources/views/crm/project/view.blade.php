@extends('layouts.site.master')
@section('content')
	<section>
        <div class="container-fluid">
            <div class="row main-content">
                <div class="col-md-8">
		@include('layouts.site.blocks.help')
                    <div class="box main-page">
                        <div class="head">
                            <h4>{{$data->title}}
							<span style="float: left;">
								{{@$data->projectRequiredType->title}}
							</span>
							</h4>	
                        </div>
                        <!-- .head -->
                        <div class="body">
                            <div class="post">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
										@if(file_exists('assets/uploads/required/'.$data->file) and $data->file != '' and $data->file != null)
											<a href="{!! asset('assets/uploads/required/'.$data->file) !!}" target="_blank">
												دانلود فایل 
												<i class="fa fa-download"></i>
											</a>
										@else
											 فایلی برای دانلود وجود ندارد
										@endif
										
										@if($data->status_id == 2)
											<a href="{{URL::action('Crm\ProjectController@getEdit',$data->id)}}" class="link red link-hover" style="float: left">
												تایید
											</a>
										@endif
										<hr>
									
									<span class="ejavan-alert">چکیده: </span>
										{!! $data->abstract !!}
										
										<hr>
									<span class="ejavan-alert">	متن: </span>
										{!! $data->content !!}
										
										<hr>
									<span class="ejavan-alert">منابع:</span>
										{!! $data->source !!}
                                    </div>
                                </div>

                            </div>
                            <!-- /.post -->
                        </div>
                        <!-- .body -->
                    </div>
                    <!-- .box -->
                </div>
				
				@include('layouts.crm.blocks.sidebar')
            </div>
        </div>
    </section>
@endsection
