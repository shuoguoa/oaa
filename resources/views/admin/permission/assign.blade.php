@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
    {{ $page_title }}
@endsection

@section('contentheader_title')
    {{ $page_title }}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 权限管理 </a></li>
        <li class="active">权限</li>
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
                        <li><a href="{{ url('admin/permission') }}"><i class="fa fa-angle-right"></i> 权限列表</a></li>
                        <li><a href="{{ url('admin/permission/create') }}"><i class="fa fa-angle-right"></i> 添加权限</a>
                        </li>
                        <li class="active"><a href="{{ url('admin/permission/assign') }}"><i
                                        class="fa fa-angle-right"></i> 权限分配</a></li>
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
                    <h3 class="box-title">权限分配</h3>
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
                                            <th>角色</th>
                                            <th>权限</th>
                                            <th style="width: 80px; text-align: center">操作</th>
                                        </tr>

                                        @foreach($permission_roles as $permissionRole)
                                            <tr>
                                                <td>{{ $permissionRole['role_display_name'] }}</td>
                                                <td>{{ $permissionRole['permission_display_name'] }}</td>

                                                <td style="width: 80px; text-align: center">
                                                    <form action="{{ url('/admin/permission/removal') }}" method="post"
                                                          style="display: inline">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="role_id"
                                                               value="{{ $permissionRole['role_id'] }}"/>
                                                        <input type="hidden" name="permission_id"
                                                               value="{{ $permissionRole['permission_id'] }}"/>
                                                        <button type="submit" class="btn btn-default"><i
                                                                    class="fa fa-trash-o"></i>
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
                                        {{--{{ $media_users->links() }}--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="box box-default box-solid">
                                <!-- form start -->
                                <form role="form" action="{{ url('/admin/permission/doAssign') }}" method="post">
                                    <div class="box-body">
                                        {{ csrf_field() }}

                                        <div class="form-group{{ $errors->has("role_id") ? ' has-error' : '' }}">
                                            <label for="role_id">角色</label>

                                            <select class="form-control" id="role_id" name="role_id">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('role_id'))
                                                <p class="help-block">
                                                    <strong>{{ $errors->first('role_id') }}</strong>
                                                </p>
                                            @endif
                                        </div>

                                        <div class="form-group{{ $errors->has("permission_id") ? ' has-error' : '' }}">
                                            <label for="permission_id">权限</label>
                                            @foreach($permissions as $permission)
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="permission_id[]"
                                                               value="{{ $permission->id }}"> {{ $permission->display_name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            @if ($errors->has('permission_id'))
                                                <p class="help-block">
                                                    <strong>{{ $errors->first('permission_id') }}</strong>
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