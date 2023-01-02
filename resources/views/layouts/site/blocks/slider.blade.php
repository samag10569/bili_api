<section>
    <div class="container-fluid">
        <style>@media screen and (max-width: 992px) {
                body {
                    background: #22a3d4
                }
            }</style>
        <div class="row">
            <div id="myCarousel" class="carousel slide" data-ride="carousel"  style="background: #0099ff;">
                <div id="large-header">
                    <canvas id="demo-canvas"></canvas>
                </div>
                <!-- /#large-header -->
                <div id="logo-area">
                    <img src="{!! asset('assets/uploads/setting/'.$setting->logo_header) !!}" alt="شبکه رشد علم جوان">
                    <p class="title-big">شبکه رشد علم جوان</p>
                    <p class="title-small">اولین هایپر فناوری ایرانی</p>
                    <p class="title-small">net.علم</p>
                    @if(!Auth::check())
                        <a href="" class="link-hover" data-toggle="modal" data-target="#myModal">ورود / ثبت نام</a>
                    @endif
                </div>

                <!-- /#logo-area -->

                <!-- /#large-header -->
                <!-- Indicators -->

                <ol class="carousel-indicators">
                    <?php $counter = 0;  ?>
                    @foreach($banner as $row)

                        <li data-target="#myCarousel" data-slide-to="{{$counter}}"
                            @if($counter == 0)class="active" @endif></li>
                        <?php $counter++; ?>
                    @endforeach

                </ol>
                <!-- /.carousel-indicators -->

                <div class="carousel-inner" role="listbox" style="background: #0099ff;">
                    <?php $counter = 0;  ?>
                    @foreach($banner as $row)

                        <div style="cursor:pointer;" onclick=" window.location = '{{$row->link}}'" 
							@if($counter == 0) class="item active" @else class="item" @endif>

                            <img src="{!! asset('assets/uploads/banner/big/'.$row->image) !!}"
                                 alt="{!! $row->title !!}" style="width: 2000px;height: 770px;">

                        </div>
                        <?php $counter++; ?>
                    @endforeach

                </div>
                <!-- /.carousel-inner -->

                <!--
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>  -->
            </div>
            <!-- /#myCarousel -->
        </div>
    </div>
</section>