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
    </ol>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">到帐帐户</h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-btn">
                                <a class="btn btn-success" href="{{ url('admin/account/create') }}" title="添加新的帐户"><i
                                            class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-hover table-striped table-responsive">
                        <tr>
                            <th>#</th>
                            <th>帐户名称</th>
                            <th style="text-align: center">帐户类型</th>
                            <th style="text-align: center">状态</th>
                            <th style="width: 50%;">备注</th>
                            <th style="width: 160px; text-align: center">操作</th>
                        </tr>

                        @foreach($accounts as $account)
                            <tr>
                                <td>{{ $account->id }}</td>
                                <td>{{ $account->name }}</td>
                                <td style="text-align: center">
                                    @if($account->type === 1)
                                        公司
                                    @elseif($account->type === 2)
                                        个人
                                    @else
                                        ----
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    @if($account->status === 1)
                                        <span class="label label-success" style="font-size: 0.9em"> 启用 </span>
                                    @elseif($account->status === 2)
                                        <span class="label label-danger" style="font-size: 0.9em"> 未启用 </span>
                                    @else
                                        ----
                                    @endif
                                </td>
                                <td style="width: 50%; ">{{ $account->remark }}</td>
                                <td style="width: 160px; text-align: center">
                                    @if($account->status === 1)
                                        <form action="{{ url('/admin/account/' . $account->id . '/' . $account->status) }}"
                                              method="post" style="display: inline">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default"><i class="fa fa-lock"></i> 禁用
                                            </button>
                                        </form>
                                    @elseif($account->status === 2)
                                        <form action="{{ url('/admin/account/' . $account->id . '/' . $account->status) }}"
                                              method="post" style="display: inline">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default"><i class="fa fa-unlock"></i>
                                                启用
                                            </button>
                                        </form>
                                        <form action="{{ url('/admin/account/' . $account->id) }}" method="post"
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
                        {{ $accounts->links() }}
                    </div>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection