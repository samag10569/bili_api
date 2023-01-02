@if(count(Request::segments()))

    <section>
        <div class="container-fluid">
            <div class="row logo-area-pages">
                <div class="col-md-9  col-sm-12">
                   <a href="{{URL::action('Site\NewsController@getDetails',[$lastNews->id,Classes\Helper::seo($lastNews->title)])}}">
						<p id="info"><span>اطلاع رسانی : </span>
							{{$lastNews->title}}
						</p>
					</a>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div id="logos">
                        <img src="{!! asset('assets/site/images/logo.png') !!}" alt="" id="logo">
                        <ul class="text">
                            <li>اولین هایپر فناوری ایرانی</li>
                            <li>net.علم</li>
                            <li>شبکه رشد علم جوان</li>
                        </ul>
                        <!-- .text -->
                    </div>
                    <!--/#logos -->
                </div>
            </div>
            <!-- /.logo-area -->
        </div>

    </section>

@else

    <section>
        <div class="container-fluid">
            <div class="row info-area">
                <div class="col-md-12">
                   <a href="{{URL::action('Site\NewsController@getDetails',[$lastNews->id,Classes\Helper::seo($lastNews->title)])}}">
						<p id="info"><span>اطلاع رسانی : </span>
							{{$lastNews->title}}
						</p>
					</a>
                    <!-- /.info -->
                </div>
            </div>
        </div>
    </section>

@endif