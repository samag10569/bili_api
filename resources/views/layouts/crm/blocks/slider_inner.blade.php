<section>
    <div class="container-fluid">
        <div class="row">
            <div id="myCarousel" class="carousel slide inner-page-slider" data-ride="carousel"  style="background: #0099ff;">
                <div id="large-header">
                    <canvas id="demo-canvas"></canvas>
                </div>
                <!-- /#large-header -->

                <!-- /#large-header -->
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php $counter = 0;  ?>
                    @foreach($banner_inner as $row)
                        <li data-target="#myCarousel" data-slide-to="{{$counter}}"
                            @if($counter == 0)class="active" @endif></li>
                        <?php $counter++; ?>
                    @endforeach
                </ol>
                <!-- /.carousel-indicators -->

                <div class="carousel-inner" role="listbox">
                    <?php $active = true;  ?>
                    @foreach($banner_inner as $row)
                        <div style="cursor:pointer;" onclick=" window.location = '{{$row->link}}'" class="item @if($active) active @endif">
                            <img src="{!! asset('assets/uploads/banner/big/'.$row->image) !!}"
                                 alt="{!! $row->title !!}" style="width: 2000px;height: 230px;">
                        </div>
                        <?php $active = false; ?>
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