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
                <lable>تصویر :</lable>
                {!! Form::file('image',array(
                    'class'=>'form-control')) !!}
                @if(isset($data))
                    @if(file_exists('assets/uploads/scientific/medium/'.$data->image))
                        <img src="{!! asset('assets/uploads/scientific/medium/'.$data->image) !!}"
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
                    <label>مجموعه: </label>
                    {!! Form::select('category_id',$category,null,array('class'=>'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">

            <div class="col-md-12">
                <label>چکیده:</label>
                {!! Form::text('content_short',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'چکیده را وارد کنید . . .')) !!}
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

 <div class="form-group">
        <div class="row">

            <div class="col-md-12">
                <label>کلمات کلیدی:</label>
                {!! Form::text('keywords',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'کلمات کلیدی با | جدا شود')) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>توضیحات سئو:</label>
                {!! Form::textarea('description',null,array(
                    'class'=>'form-control','rows'=>'3',
                    'maxlength'=>255)) !!}
            </div>
        </div>
    </div>


    <div class="box-footer">
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </div>
    </div>