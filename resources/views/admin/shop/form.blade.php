<div class="box-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>شناسه مالک:</label>
                <input value="{{@$data->user->id}}" type="text" disabled="disabled" class="form-control">
            </div>
            <div class="col-md-6">
                <label>نام و نام خانوادگی مالک :</label>
                <input value="{{@$data->user->name}}" type="text" disabled="disabled" class="form-control">

            </div>

        </div>
    </div>

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
            </div>
            <div class="col-md-2">
                @if(isset($data))
                   @if(file_exists('assets/uploads/shop/medium/'.$data->image))
						<img src="{!! asset('assets/uploads/shop/medium/'.$data->image) !!}" 
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
            <div class="col-md-12">
                <label>آدرس:</label>
                {!! Form::text('address',null,array(
                    'class'=>'form-control',
                    'placeholder'=>'آدرس را وارد کنید . . .')) !!}
            </div>
            <div class="col-md-12">
                <label>انتخاب دسته یندی  </label>
                {!! Form::select('category_id',$category,null,array(
                    'class'=>'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <div id="map" style="width: 100%;height: 200px"></div>
                {!! Form::hidden('lat',null,array('id'=>'lat')) !!}
                {!! Form::hidden('lng',null,array('id'=>'lng')) !!}
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
<script              src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmT6KGxA4SlYEfOsZiRjqV85qZTZEsVDc">
</script>
<script>
    /**
     * Google Api
     * ==========================================
     */
    var map;
    var marker;
    var infowindow;
    var markers=[];
    var lineSymbol;
    var line = null;
    var interval= null ;

    var lat;
    var lng

    lat = $('#lat').val();
    lng = $('#lng').val();
    $(document).ready(function(e) {

        initMap();
    });

    function initMap() {

        marker = '';

        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 35.6835359, lng: 51.3912069},
            zoom: 11,
            gestureHandling: 'greedy'
        });


        if(lat!=''){
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                map: map,
                draggable: false
            });
        }

        infowindow = new google.maps.InfoWindow;


        google.maps.event.addListener(map, 'click', function(event) {
        if (marker) {
            marker.setPosition(event.latLng)
        } else {
            marker = new google.maps.Marker({
                position: event.latLng,
                map: map,
                draggable: false
            });
        }
        $('input[name=lat]').val(marker.getPosition().lat());
        $('input[name=lng]').val(marker.getPosition().lng());
        });





    }
    </script>