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
                        <li class="active"><a href="{{ url('admin/media') }}"><i class="fa fa-angle-right"></i> 媒介列表</a></li>
                        <li><a href="{{ url('admin/media/create') }}"><i class="fa fa-angle-right"></i> 添加媒介</a></li>
                        <li><a href="{{ url('admin/media/assign') }}"><i class="fa fa-angle-right"></i> 媒介分配 </a></li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-xs-9">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">投放媒介</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-hover table-striped table-responsive">
                        <tr>
                            <th>#</th>
                            <th>媒介名称</th>
                            <th>状态</th>
                            <th>备注</th>
                            <th style="width: 160px; text-align: center">操作</th>
                        </tr>

                        @foreach($medias as $media)
                            <tr>
                                <td>{{ $media->id }}</td>
                                <td>{{ $media->name }}</td>
                                <td>
                                    @if($media->status === 1)
                                        <span class="label label-success" style="font-size: 0.9em"> 启用 </span>
                                    @elseif($media->status === 2)
                                        <span class="label label-danger" style="font-size: 0.9em"> 未启用 </span>
                                    @else
                                        ----
                                    @endif
                                </td>
                                <td>{{ $media->remark }}</td>
                                <td style="width: 160px; text-align: center">
                                    @if($media->status === 1)
                                        <form action="{{ url('/admin/media/' . $media->id . '/' . $media->status) }}"
                                              method="post" style="display: inline">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default"><i class="fa fa-lock"></i> 禁用
                                            </button>
                                        </form>
                                    @elseif($media->status === 2)
                                        <form action="{{ url('/admin/media/' . $media->id . '/' . $media->status) }}"
                                              method="post" style="display: inline">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default"><i class="fa fa-unlock"></i>
                                                启用
                                            </button>
                                        </form>
                                        <form action="{{ url('/admin/media/' . $media->id) }}" method="post"
                                              style="display: inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default"><i class="fa fa-trash-o"></i>
                                                删除
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <div class="no-margin pull-right">
                        {{ $medias->links() }}
                    </div>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection