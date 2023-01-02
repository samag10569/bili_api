
<ul class="nav nav-tabs " style="padding-right:0px">
    <li class="active">
        <a data-toggle="tab" href="#tab_default_1">

            تنظیمات   </a>
    </li>

    <li>
        <a data-toggle="tab" href="#tab_default_2">

            تنظیمات سئو   </a>
    </li>



</ul>
    <div class="tab-content">
    <div id="tab_default_1" class="tab-pane active">

<div class="box-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>عنوان:</label>
                {!! Form::text('title',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'عنوان را وارد کنید . . .')) !!}
            </div>

        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <lable>واتر مارک :</lable>
                {!! Form::file('logo_water_mark',array(
                    'class'=>'form-control')) !!}
            </div>
            <div class="col-md-2">
                @if(isset($data))
                    @if(file_exists(public_path('assets/uploads/setting/'.$data->logo_water_mark)))
                        <img src="{!! asset('assets/uploads/setting/'.$data->logo_water_mark) !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @else
                        <img src="{!! asset('assets/uploads/notFound.jpg') !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @endif
                @endif
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <lable>تصویر فوآیکون :</lable>
                {!! Form::file('favicon',array(
                    'class'=>'form-control')) !!}
            </div>
            <div class="col-md-2">
                @if(isset($data))
                     @if(file_exists(public_path('assets/uploads/setting/'.$data->favicon)))
                        <img src="{!! asset('assets/uploads/setting/'.$data->favicon) !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @else
                        <img src="{!! asset('assets/uploads/notFound.jpg') !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @endif
                @endif
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <lable>اوگو هدر :</lable>
                {!! Form::file('logo_header',array(
                    'class'=>'form-control')) !!}
            </div>
            <div class="col-md-2">
                @if(isset($data))
                    @if(file_exists(public_path('assets/uploads/setting/'.$data->logo_header)))
                        <img src="{!! asset('assets/uploads/setting/'.$data->logo_header) !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @else
                        <img src="{!! asset('assets/uploads/notFound.jpg') !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @endif
                @endif
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <lable>لوگو فوتر :</lable>
                {!! Form::file('logo_footer',array(
                    'class'=>'form-control')) !!}
            </div>
            <div class="col-md-2">
                @if(isset($data))
                    @if(file_exists(public_path('assets/uploads/setting/'.$data->logo_footer)))
                        <img src="{!! asset('assets/uploads/setting/'.$data->logo_footer) !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @else
                        <img src="{!! asset('assets/uploads/notFound.jpg') !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @endif
                @endif
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
    </div>
        </div>





    <div id="tab_default_2" class="tab-pane">

        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <label>کلمات کلیدی:</label>
                        {!! Form::text('keyword',null,array(
                            'class'=>'form-control',
                            'placeholder'=>'کلمات کلیدی را وارد کنید . . .')) !!}
                    </div>
                    </div>
                </div>


            <div class="form-group">
                <div class="row">

                <div class="col-md-12">
                <label>توضیحات کلیدی:</label>
                {!! Form::textarea('description',null,array(
                    'class'=>'form-control',)) !!}
            </div>
            </div>
            </div>

                </div>
            </div>


        </div>




    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>
