<footer>
    <div class="container-fluid">
        <div id="top-footer">
            <div class="row">
                @foreach($ftab as $row)
                    <div class="col-md-4 col-sm-12">
                        <h3>
                            {{ $row->title }}
                        </h3>
                        <ul class="links">
                            @foreach($row->footerUnderMenu as $item)
                                <li>
                                    <a href="{{$item->link}}">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

                <div class="col-md-4 col-sm-12">
                    <div id="namad-area">
                        <div id="namads" class="">
                            <span class="center first"><img src="{{ asset('assets/site/images/nokhbe2.png') }}"
                                                            alt=""></span>
                            <span class="center second"><img src="{{ asset('assets/site/images/nokhbe.png') }}"
                                                             alt=""></span>

                            <span class="top around" title="نماداعتماد الکترونیکی" data-toggle="tooltip">
                                    <img src="{{ asset('assets/site/images/enamad.png') }}" class="sh" alt="">
								<img src="{{ asset('assets/site/images/enamad2.png') }}" class="hd" alt=""></span>
                            <a href="/ssl"><span class="ltop around" title="گواهی امنیت سمت کاربر SSL" data-toggle="tooltip">
                                    <img src="{{ asset('assets/site/images/gholf.png') }}" class="sh" alt="">
								<img src="{{ asset('assets/site/images/gholf2.png') }}" class="hd" alt=""></span></a>
                            <span class="rtop around" title="نشان ملی ثبت" data-toggle="tooltip">
                                    <img src="{{ asset('assets/site/images/resane.png') }}" class="sh" alt="">
								<img src="{{ asset('assets/site/images/resane2.png') }}" class="hd" alt=""></span>
                            <a href="/garantee"><span class="rbottom around" title="ضمانت تضمین کیفیت خدمات" data-toggle="tooltip">
                                    <img src="{{ asset('assets/site/images/tazmin.png') }}" class="sh" alt="">
                                    <img src="{{ asset('assets/site/images/tazmin2.png') }}" class="hd" alt=""></span></a>
                            <a href="https://t.me/ejavan_net"><span class="lbottom around" title="@ejavan_net" data-toggle="tooltip">
                                    <img src="{{ asset('assets/site/images/telg.png') }}" class="sh" alt="">
								<img src="{{ asset('assets/site/images/telg2.png') }}" class="hd" alt=""></span><a/>
                        </div>
                        <!-- /#namads -->
                    </div>
                    <!-- /#namad-area -->

                </div>
            </div>
        </div>
        <!-- /#top-footer -->
        <div id="mid-footer">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <form class="form-inline ">
                        <div class="form-group feed">
                            <label for="email">عضویت در خبر نامه ما:</label>
                            <input type="email" class="form-control" placeholder="آدرس ایمیل خود را وارد کنید">
                        </div>
                        <div class="form-group contactus">
                            <input type="text" class="form-control" placeholder="شماره تماس خود را وارد کنید">
                        </div>
                        <button type="submit" class="btn btn-default">ثبت</button>
                    </form>


                </div>


            </div>


        </div>
        <!-- /#mid-footer -->
        <div id="brands">
            <div class="container-fluid">
                <div class="row brands-area foot-title">
                    <h4>همکاران علمی</h4>
                    <div class="line"></div>

                </div>
            </div>
            <div class="container">
                <div class="row">

                    <div class="col-md-12">

                        <div id="foot-slider" class="carousel slide">


                            <!-- Carousel items -->
                            <div class="carousel-inner">
                                @php
                                    $lists = $logos->chunk(6);
                                    $m = $lists->toArray();
                                    $active = true;
                                @endphp
                                @foreach($lists as $item)
                                    <div class="item  @if($active) active @endif">
                                        <div class="row">
                                            @foreach($item as $row)
                                                <div class="col-md-2">
                                                    <a href="{{$row->link}}" class="thumbnail" target="_blank">
                                                        <img
                                                                src="{{ asset('assets/uploads/logo/medium/'.$row->image) }}"
                                                                alt="{{$row->title}}"
                                                                style="max-width:100%;height: 68px;width: 155px;"
                                                                title="{{$row->title}}"
                                                                data-toggle="tooltip"
                                                                data-original-title="{{$row->title}}">
                                                    </a>
                                                </div>
                                            @endforeach

                                        </div>
                                        <!--.row-->
                                    </div>
                                    <!--.item-->
                                    @php $active = false; @endphp
                                @endforeach

                            </div>
                            <!--.carousel-inner-->
                            <a data-slide="prev" href="#foot-slider" class="right carousel-control">‹</a>
                            <a data-slide="next" href="#foot-slider" class="left carousel-control">›</a>
                        </div>
                        <!--.Carousel-->


                    </div>
                </div>
            </div>
        </div>
        <!-- /#brands -->
        <div id="bot-footer">
            <div class="container-fluid">
                <div class="row brands-area foot-title">
                    <a href="#top" class="goup"><img src="{{ asset('assets/site/images/up.png') }}" alt=""></a>
                    <div class="line"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div id="copyright">
                            <img src="{{ asset('assets/site/images/barcode.jpg') }}" class="barcode" alt="">
                            <p>
                                امروز:
                                {{jdate('l')}}
                                {{jdate('d')}}
                                {{jdate('F')}}
                                {{jdate('Y')}}
                                اکنون ساعت
                                {{jdate('H:i')}}
                                به وقت تهران میباشد.
                                <br> تمامی حقوق متعلق به شرکت تسهیلگران رشد نوابغ جوان ( ترنج ) می باشد

                            </p>
                            <ul id="footer-social">
                                <li>
                                    <a href=""><img src="{{ asset('assets/site/images/tlegram.png') }}" alt=""></a>
                                </li>
                                <li>
                                    <a href=""><img src="{{ asset('assets/site/images/email.png') }}" alt=""></a>
                                </li>
                                <li>
                                    <a href=""><img src="{{ asset('assets/site/images/feed.png') }}" alt=""></a>
                                </li>
                                <li>
                                    <a href=""><img src="{{ asset('assets/site/images/headset.png') }}" alt=""></a>
                                </li>
                            </ul>
                        </div>
                        <!-- /#copyright -->
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>

            </div>
            <!-- /#bot-footer -->

        </div>
</footer>
