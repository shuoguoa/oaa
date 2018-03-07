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
        <li class="active">添加用户</li>
    </ol>
@endsection

@section('main-content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">添加用户</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{ url('/admin/user/store') }}" method="post">
            <div class="box-body">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has("name") ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-2 control-label">用户名</label>

                    <div class="col-sm-5">
                        <input class="form-control" id="name" name="name" placeholder="用户名" type="input"
                               value="{{ old('name') }}" required>
                    </div>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has("email") ? ' has-error' : '' }}">
                    <label for="email" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-5">
                        <input class="form-control" id="email" name="email" placeholder="Email" type="email"
                               value="{{ old('email') }}" required>
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has("real_name") ? ' has-error' : '' }}">
                    <label for="real_name" class="col-sm-2 control-label">真实姓名</label>

                    <div class="col-sm-5">
                        <input class="form-control" id="real_name" name="real_name" placeholder="真实姓名" type="input"
                               value="{{ old('real_name') }}" required>
                    </div>
                    @if ($errors->has('real_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('real_name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has("password") ? ' has-error' : '' }}">
                    <label for="password" class="col-sm-2 control-label">初始密码</label>

                    <div class="col-sm-5">
                        <input class="form-control" id="password" name="password" placeholder="初始密码" type="password"
                               value="{{ old('password') }}" required>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('user_type') ? ' has-error' : '' }}">
                    <label for="user_type" class="col-sm-2 control-label">用户类型</label>

                    <div class="col-sm-5">
                        <select id="user_type" name="user_type" class="form-control">
                            <option value="" style="display: none">请选择...</option>
                            <option value="1"{{ old('user_type') == 1 ? 'selected="selected"' : "" }}>管理员</option>
                            <option value="2"{{ old('user_type') == 2 ? 'selected="selected"' : "" }}>运营</option>
                            <option value="5"{{ old('user_type') == 5 ? 'selected="selected"' : "" }}>业管</option>
                            <option value="4"{{ old('user_type') == 4 ? 'selected="selected"' : "" }}>执行</option>
                            <option value="3"{{ old('user_type') == 3 ? 'selected="selected"' : "" }}>销售</option>
                        </select>
                    </div>
                    @if ($errors->has('user_type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_type') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    <label for="status" class="col-sm-2 control-label">用户状态</label>

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
                        <textarea id="remark" class="form-control" name="remark" rows="3">{{ old('remark') }}</textarea>
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