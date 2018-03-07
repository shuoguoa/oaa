@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
    {{ $page_title }}
@endsection

@section('contentheader_title')
    {{ $page_title }}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> 业务管理</a></li>
        <li class="active">数据统计</li>
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
                        <li class="active"><a href="{{ url('business') }}"><i class="fa fa-angle-right"></i> 业务列表</a>
                        </li>
                        <li><a href="{{ url('business/create') }}"><i class="fa fa-angle-right"></i> 添加业务</a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">数据统计 <span> ---- {{ $businessName }}</span></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-hover table-striped table-responsive table-bordered">
                        <tr>
                            <th>媒介</th>
                            <th>日期</th>
                            <th>展现量</th>
                            <th>点击量</th>
                            <th>单价</th>
                            <th>花销</th>
                            <th>备注</th>
                            <th width="80px">操作</th>
                        </tr>

                        @foreach($stats as $stat)
                            <tr>
                                <td>{{ $stat['mediaName'] }}</td>
                                <td>{{ $stat['date'] }}</td>
                                <td>{{ $stat['show'] }}</td>
                                <td>{{ $stat['click'] }}</td>
                                <td>{{ $stat['price'] }}</td>
                                <td>{{ $stat['cost'] }}</td>
                                <td>{{ $stat['remark'] }}</td>
                                <td>
                                    <button type="button" class="btn btn-default stat_edit"
                                            data-id="{{ $stat['id'] }}"
                                            data-name="{{ $stat['mediaName'] }}">
                                        <i class="fa fa-edit"></i> 修改
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-padding">
                    <div class="no-margin pull-right">

                    </div>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editModalLabel"></h4>
                </div>

                <form id="edit_form" class="form-horizontal" method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="stat_date" class="col-sm-2 control-label">日期</label>

                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                    <input class="form-control" id="stat_date" name="stat_date"
                                           type="input" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="show" class="col-sm-2 control-label">展现量</label>

                            <div class="col-sm-5">
                                <input class="form-control" id="show" name="show" type="input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="click" class="col-sm-2 control-label">点击量</label>

                            <div class="col-sm-5">
                                <input class="form-control" id="click" name="click" type="input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">单价</label>

                            <div class="col-sm-5">
                                <input class="form-control" id="price" name="price" type="input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cost" class="col-sm-2 control-label">花销</label>

                            <div class="col-sm-5">
                                <input class="form-control" id="cost" name="cost" type="input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remark" class="col-sm-2 control-label">备注</label>

                            <div class="col-sm-5">
                                <input class="form-control" id="remark" name="remark" type="input">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-default">重置</button>
                        <button type="submit" class="btn btn-info">确认</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script type="text/javascript">
        $(function () {
            $('.stat_edit').click(function () {
                var task_id = $(this).attr('data-id');
                var mediaName = $(this).attr('data-name');

                $('#editModalLabel').html("媒介：" + mediaName);
                $('#edit_form').attr('action', '/stat/' + task_id);

                $.ajax({
                    url: '/stat/show/' + task_id,
                    type: 'get',
                    success: function (data) {
                        $('#stat_date').val(data.stat_date);
                        $('#show').val(data.show);
                        $('#click').val(data.click);
                        $('#price').val(data.price);
                        $('#cost').val(data.cost);
                        $('#remark').val(data.remark);

                        $('#editModal').modal('show');
                    }
                });
            });
        });
    </script>
@endsection