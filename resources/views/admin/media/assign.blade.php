@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
    {{ $page_title }}
@endsection

@section('contentheader_title')
    {{ $page_title }}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 系统管理</a></li>
        <li class="active">媒介管理</li>
    </ol>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Labels</h3>

                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="{{ url('admin/media') }}"><i class="fa fa-angle-right"></i> 媒介列表</a></li>
                        <li><a href="{{ url('admin/media/create') }}"><i class="fa fa-angle-right"></i> 添加媒介</a></li>
                        <li class="active"><a href="{{ url('admin/media/assign') }}"><i class="fa fa-angle-right"></i>
                                媒介分配 </a></li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">媒介分配</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="box box-solid">
                                {{--<div class="box-header">
                                    <p class="text-center">
                                        <strong>已分配的媒介</strong>
                                    </p>
                                </div>--}}

                                <div class="box-body no-padding">
                                    <table class="table table-bordered table-hover table-striped table-responsive">
                                        <tr>
                                            <th>执行用户</th>
                                            <th>投放媒介</th>
                                            <th style="width: 80px; text-align: center">操作</th>
                                        </tr>

                                        @foreach($media_users as $mediaUser)
                                            <tr>
                                                <td>{{ $mediaUser['user_name'] }}</td>
                                                <td>{{ $mediaUser['media_name'] }}</td>

                                                <td style="width: 80px; text-align: center">
                                                    <form action="{{ url('/admin/media/delUser') }}" method="post"
                                                          style="display: inline">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="media_id" value="{{ $mediaUser['media_id'] }}"/>
                                                        <input type="hidden" name="user_id" value="{{ $mediaUser['user_id'] }}"/>
                                                        <button type="submit" class="btn btn-default"><i class="fa fa-trash-o"></i>
                                                            删除
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="box box-default box-solid">
                                <!-- form start -->
                                <form role="form" action="{{ url('/admin/media/doAssign') }}" method="post">
                                    <div class="box-body">
                                        {{ csrf_field() }}

                                        <div class="form-group{{ $errors->has("user_id") ? ' has-error' : '' }}">
                                            <label for="user_id">执行用户</label>

                                            <select class="form-control" id="user_id" name="user_id">
                                                @foreach($users as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('user_id'))
                                                <p class="help-block">
                                                    <strong>{{ $errors->first('user_id') }}</strong>
                                                </p>
                                            @endif
                                        </div>

                                        <div class="form-group{{ $errors->has("name") ? ' has-error' : '' }}">
                                            <label for="media_id">投放媒介</label>
                                            @foreach($medias as $media)
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="media_id[]" value="{{ $media->id }}"> {{ $media->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            @if ($errors->has('media_id'))
                                                <p class="help-block">
                                                    <strong>{{ $errors->first('media_id') }}</strong>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">确认</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->
            </div>
        </div>
    </div>
@endsection