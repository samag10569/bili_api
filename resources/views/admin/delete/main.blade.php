@extends ("layouts.admin.master")

@section('title','مدیریت حذف')
@section('content')

        <!-- Small boxes (Stat box) -->
<div class="row">
    @include('layouts.admin.blocks.message')
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">مدیریت حذف</h3>
            </div>
        </div>



        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{!! $help !!}</h3>
                    <p>راهنمایی در بخش ها</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tag"></i>
                </div>
                <a href="{{URL::action('Admin\DeleteController@getHelp')}}" class="small-box-footer">مشاهده <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{!! $scientific_category !!}</h3>
                    <p>دسته بندی مطالب علمی</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{{URL::action('Admin\DeleteController@getScientificCategory')}}" class="small-box-footer">مشاهده <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{!! $scientific !!}<sup style="font-size: 20px"></sup></h3>
                    <p>مطالب علمی</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bars"></i>
                </div>
                <a href="{{URL::action('Admin\DeleteController@getScientific')}}" class="small-box-footer"> مشاهده <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{!! $news !!}</h3>
                    <p>اخبار</p>
                </div>
                <div class="icon">
                    <i class="fa fa-calendar"></i>
                </div>
                <a href="{{URL::action('Admin\DeleteController@getNews')}}" class="small-box-footer">مشاهده <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->



    <div class="col-xs-12">


        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{!! $user !!}</h3>
                    <p>پرونده کاربران حذف شده</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{{URL::action('Admin\DeleteController@getIndex')}}" class="small-box-footer">مشاهده <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->
</div>
@stop