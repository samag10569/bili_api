<div class="box-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>عنوان:</label>
                {!! Form::text('title',null,array(
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
                <label>موارد بیشتر:</label>
                {!! Form::select('option',$option,null,array(
                    'class'=>'form-control')) !!}
            </div>
            <div class="col-md-6">
                <label>طبقه بندی :</label>
                {!! Form::select('category_id',$category_id,null,array('class'=>'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>قیمت خدمت (رای رایگان 0 وارد کنید):</label>
                {!! Form::number('price',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'برای رایگان 0 وارد کنید.',
                    'min'=>0)) !!}
            </div>
            <div class="col-md-6">
                <label>قیمت با تخفیف اعضای طلایی (برای رایگان 0 وارد کنید):</label>
                {!! Form::number('gold_price',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'برای رایگان 0 وارد کنید.',
                    'min'=>0)) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>سود بال خدماتی :</label>
                {!! Form::number('profit',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'سود بال خدماتی را وارد کنید . . .',
                    'min'=>0)) !!}
            </div>
            <div class="col-md-6">
                <label>ظرفیت خدمت (برای نامحدود 0 وارد کنید):</label>
                {!! Form::number('capacity',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'برای نامحدود 0 وارد کنید',
                    'min'=>0)) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <lable>تصویر :</lable>
                {!! Form::file('image',array(
                    'class'=>'form-control')) !!}
            </div>
            <div class="col-md-2">
                @if(isset($data))
                    @if(file_exists('assets/uploads/allotment/medium/'.$data->image))
                        <img src="{!! asset('assets/uploads/allotment/medium/'.$data->image) !!}"
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
                <label>امتیاز استفاده از خدمت :</label>
                {!! Form::number('score',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'امتیاز استفاده از خدمت را وارد نمایید . . .',
                    'min'=>0)) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>چکیده:</label>
                {!! Form::textarea('content',null,array(
                    'class'=>'form-control',
                    'rows'=>3)) !!}
            </div>

        </div>
    </div>
     <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>توضیحات:</label>
                {!! Form::textarea('description',null,array(
                    'class'=>'form-control ckeditor','rows'=>'2')) !!}
            </div>
        </div>
    </div>


    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>
    </div>