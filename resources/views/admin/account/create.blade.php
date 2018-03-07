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
        <li class="active">帐户管理</li>
        <li class="active">添加帐户</li>
    </ol>
@endsection

@section('main-content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">添加帐户</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{ url('/admin/account/store') }}" method="post">
            <div class="box-body">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has("name") ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-2 control-label">名称</label>

                    <div class="col-sm-5">
                        <input class="form-control" id="name" name="name" placeholder="帐户名称" type="input"
                               value="{{ old('name') }}" required>
                    </div>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                    <label for="type" class="col-sm-2 control-label">帐户类型</label>

                    <div class="col-sm-5">
                        <select id="type" name="type" class="form-control">
                            <option value="1" selected>公司</option>
                            <option value="2">个人</option>
                        </select>
                    </div>
                    @if ($errors->has('type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    <label for="status" class="col-sm-2 control-label">帐户状态</label>

                    <div class="col-sm-5">
                        <select id="status" name="status" class="form-control">
                            <option value="1" selected>启用</option>
                            <option value="2">不启用</option>
                        </select>
                    </div>
                    @if ($errors->has('status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('status') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('remark') ? ' has-error' : '' }}">
                    <label class="col-sm-2 control-label" for="remark">备注</label>

                    <div class="col-sm-5">
                        <textarea id="remark" class="form-control" name="remark" rows="3" required>{{ old('remark') }}</textarea>
                    </div>
                    @if ($errors->has('remark'))
                        <span class="help-block">
                            <strong>{{ $errors->first('remark') }}</strong>
                        </span>
                    @endif
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-sm-offset-2">
                    <button type="reset" class="btn btn-default">重置</button>
                    <button type="submit" class="btn btn-info">确认</button>
                </div>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection