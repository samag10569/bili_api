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
            <div class="col-md-12">
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
            </div>
            <div class="col-md-2">
                @if(isset($data))
                    @if(file_exists('assets/uploads/help/medium/'.$data->image))
                        <img src="{!! asset('assets/uploads/help/medium/'.$data->image) !!}"
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
                <label>قسمت:</label>
                {!! Form::text('section',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'قسمت را وارد کنید . . .')) !!}
            </div>
			<div class="col-md-6">
                <label>قابل غیرفعال سازی توسط کاربر باشد ؟:</label>
                {!! Form::select('status_user',$status_user,null,array(
                    'class'=>'form-control')) !!}
			</div>
		</div>
    </div>

<?php /*

    <div class="form-group">
        <div class="row">

            <div class="col-md-2">
                <label>مکان ارسال راهنمایی:</label>
                </div>
                <div class="col-md-10">
                    {{ Form::checkbox('status_profile', 1) }}&nbsp;صفحه پروفایل کاربری&nbsp;
                    {{ Form::checkbox('status_grade', 1) }}&nbsp;صفحه تعیین گرید علمی&nbsp;
                    {{ Form::checkbox('status_service', 1) }}&nbsp;صفحه خرید خدمات&nbsp;
                    {{ Form::checkbox('status_project', 1) }}&nbsp;صفحه تعیین پروژه موظفی&nbsp;


            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row">

            <div class="col-md-12">
                <label>چکیده:</label>
                {!! Form::textarea('content_short',null,array(
                    'class'=>'form-control ckeditor',
                    'placeholder'=>'چکیده را وارد کنید . . .')) !!}
            </div>
        </div>
    </div>
*/ ?>
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