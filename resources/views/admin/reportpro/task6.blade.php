@foreach($data as $row)
    <div class="form-group">
        <div class="row">
            <div class="col-md-10">{{$row}}</div>

            <div class="col-md-2">
                <span class="label label-success margin-right-sm" >{{$row->count}}</span>
            </div>
        </div>
    </div>
@endforeach