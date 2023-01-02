<div class="box-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>عنوان:</label>
                {!! Form::text('name',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'عنوان را وارد کنید . . .')) !!}
            </div>
            <div class="col-md-6">
                <label>وضعیت:</label>
                {!! Form::select('status',$status,null,array(
                    'class'=>'form-control')) !!}
            </div>

        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <lable>تصویر :</lable>
                {!! Form::file('image',array(
                    'class'=>'form-control')) !!}
                @if(isset($data))
                    @if(file_exists('assets/uploads/billboard/medium/'.$data->image))
                        <img src="{!! asset('assets/uploads/billboard/medium/'.$data->image) !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @else
                        <img src="{!! asset('assets/uploads/notFound.jpg') !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @endif
                @endif
            </div>
            <div class="col-md-6">
                <label>هوشمندی بیلبورد</label>
                {!! Form::select('type',$type,null,array(
                    'class'=>'form-control')) !!}
            </div>

        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>استان</label>
                {!! Form::select('state_id',$state_id,null,array('class'=>'form-control')) !!}
            </div>
            <div class="col-md-6">
                <label>شهر</label>
                 {!! Form::text('city',null,array(
                    'class'=>'form-control')) !!}
            </div>            
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>آدرس بیلبورد:</label>
                {!! Form::text('location',null,array(
                    'class'=>'form-control')) !!}
            </div>
            <div class="col-md-6">
                <label>نوع بیلبورد:</label>
                {!! Form::select('type2',$type2,null,array(
                    'class'=>'form-control')) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>آیدی دوربین در سرور اکسون</label>
                {!! Form::text('id_camera',null,array(
                 'class'=>'form-control')) !!}
            </div>
            <div class="col-md-6">
                <label>آی پی تلوزیون هوشمند</label>
                {!! Form::text('ip_tv',null,array(
                   'class'=>'form-control')) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>هزینه اجاره ساعتی</label>
                {!! Form::text('price_1h',null,array(
                 'class'=>'form-control')) !!}
            </div>
            <div class="col-md-6">
                <label>هزینه اجاره روزانه</label>
                {!! Form::text('price_1d',null,array(
                   'class'=>'form-control')) !!}
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>هزینه اجاره ماهانه</label>
                {!! Form::text('price_1m',null,array(
                 'class'=>'form-control')) !!}
            </div>
            <div class="col-md-6">
                <label>هزینه اجاره یه ماهه</label>
                {!! Form::text('price_3m',null,array(
                   'class'=>'form-control')) !!}
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>هزینه اجاره شش ماهه</label>
                {!! Form::text('price_6m',null,array(
                 'class'=>'form-control')) !!}
            </div>
            <div class="col-md-6">
                <label>هزینه اجاره سالانه</label>
                {!! Form::text('price_1yr',null,array(
                   'class'=>'form-control')) !!}
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>توضیحات:</label>
                {!! Form::textarea('content',null,array(
                    'class'=>'form-control ckeditor',)) !!}
            </div>
        </div>
    </div>


    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>
    </div>