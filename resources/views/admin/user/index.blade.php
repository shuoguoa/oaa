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
        <li class="active">用户管理</li>
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
                        <li><a href="{{ url('admin/user/create') }}"><i class="fa fa-angle-right"></i> 添加用户</a></li>
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
                    <h3 class="box-title">系统用户</h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-hover table-striped table-responsive">
                        <tr>
                            <th>#</th>
                            <th>用户名</th>
                            <th>真实姓名</th>
                            <th>Email</th>
                            <th style="text-align: center;">用户类型</th>
                            <th style="text-align: center;">用户状态</th>
                            <th style="text-align: center;">操作</th>
                        </tr>

                        @foreach($users as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->real_name }}</td>
                                <td>{{ $item->email }}</td>
                                <td style="text-align: center">
                                    @if($item->user_type === 1)
                                        <span>系统管理员</span>
                                    @elseif($item->user_type === 2)
                                        <span>运营</span>
                                    @elseif($item->user_type === 3)
                                        <span>销售</span>
                                    @elseif($item->user_type === 4)
                                        <span>执行</span>
                                    @elseif($item->user_type === 5)
                                        <span>业管</span>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    @if($item->status === 1)
                                        <span class="label label-success" style="font-size: 0.9em"> 启用 </span>
                                    @elseif($item->status === 2)
                                        <span class="label label-danger" style="font-size: 0.9em"> 未启用 </span>
                                    @else
                                        ----
                                    @endif
                                </td>
                                <td style="width: 240px; text-align: center">
                                    {{--<a class="btn btn-default" href=""><i class="fa fa-edit"></i> 修改 </a>--}}
                                    @if($item->status === 1 && $item->name !== 'admin')
                                        <form action="{{ url('/admin/user/' . $item->id . '/' . $item->status) }}"
                                              method="post" style="display: inline">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default"><i class="fa fa-lock"></i>
                                                禁用
                                            </button>
                                        </form>
                                    @elseif($item->status === 2 && $item->name !== 'admin')
                                        <form action="{{ url('/admin/user/' . $item->id . '/' . $item->status) }}"
                                              method="post" style="display: inline">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default"><i
                                                        class="fa fa-unlock"></i>
                                                启用
                                            </button>
                                        </form>
                                        <form action="{{ url('/admin/user/' . $item->id) }}" method="post"
                                              style="display: inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default"><i
                                                        class="fa fa-trash-o"></i>
                                                删除
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <!-- /.table -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer no-padding clearfix">
                    <div class="no-margin pull-right">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection