@extends ("layouts.admin.master")
@section('title','انواع عضویت')
@section('part','انواع عضویت')
@section('content')
    <div class="row">
        @include('layouts.admin.blocks.message')
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">لیست انواع عضویت</h3>
                    <div class="box-tools">
                       

                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>
                                <center>
                                    <input id="check-all" style="opacity: 1;position:static;" type="checkbox"/>
                                </center>
                            </th>
                            <th>عنوان</th>
                            <th>هزینه</th>
                            <th>تعداد روز</th>
                            <th>تصویر</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($data as $row)

                            <tr>
                                <td>
                                    <center>
                                        <input style="opacity: 1;position:static;" name="deleteId[]" class="delete-all"
                                               type="checkbox"
                                               value="{{$row['id']}}"/>

                                    </center>
                                </td>
                                <td>{{$row->title}}</td>
                                <td>{{$row->price}}</td>
                                <td>{{$row->time}}</td>


                                <td>
                                    @if(file_exists('assets/uploads/membership-type/medium/'.$row->image))
                                        <img src="{!! asset('assets/uploads/membership-type/medium/'.$row->image) !!}"
                                             class="img-rounded"
                                             style="width: 100px; height: 60px;">
                                    @else
                                        <img src="{!! asset('assets/uploads/notFound.jpg') !!}"
                                             class="img-rounded"
                                             style="width: 100px; height: 60px;">
                                    @endif
                                </td>
                                <td>
                                    <center>
                                        <a href="{{URL::action('Admin\MembershipTypeController@getEdit',$row->id)}}" data-toggle="tooltip"
                                           data-original-title="ویرایش " class="btn btn-warning  btn-xs">
                                            ویرایش
                                            <i class="fa fa-edit"></i> </a>
                                    </center>
                                </td>

                            </tr>

                        @endforeach

                    </table>
                    <center>
                        @if(count($data))
                            {!! $data->appends(Request::except('page'))->render() !!}
                        @endif
                    </center>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

@stop
