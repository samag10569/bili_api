@extends ("layouts.admin.master")
@section('title','آمارگیر پیشرفته')
@section('part','آمارگیر پیشرفته')
@section('content')
    <div class="row">
        @include('layouts.admin.blocks.message')
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">آمارگیر پیشرفته</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <div class="panel-body">
                        @php
                            $count=0;
                        @endphp
                        @foreach($data as $row)
                            @php
                                $count+=$row->count;
                            @endphp
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-10">{{$row->name.' '.$row->family}}</div>

                                    <div class="col-md-2">
                                        <span class="label label-success margin-right-sm" >{{$row->count}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10">مجموع بازخورد نمایش داده شده</div>

                                <div class="col-md-2">
                                    <span class="label label-warning margin-right-sm" >{{$count}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            </d
        </div>
@endsection