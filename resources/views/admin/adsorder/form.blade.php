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
            <div class="col-md-12">
                <label>توضیحات </label>
                {!! Form::text('content',null,array(
                    'class'=>'form-control')) !!}
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <lable>تصویر :</lable>
                {!! Form::file('image',array(
                    'class'=>'form-control')) !!}
                @if(isset($data))
                    @if(file_exists('assets/uploads/ads_image/medium/'.$data->image))
                        <img src="{!! asset('assets/uploads/ads_image/medium/'.$data->image) !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @else
                        <img src="{!! asset('assets/uploads/notFound.jpg') !!}"
                             class="img-rounded"
                             style="width: 100px; height: 60px;">
                    @endif
                @endif
            </div>
        </div>
    </div>



    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>دسته بندی</label>
                {!! Form::select('category_id',$cats,null,array(
                    'class'=>'form-control')) !!}
            </div>



        </div>
    </div>



    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>
    </div>
