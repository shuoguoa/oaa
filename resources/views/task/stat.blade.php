@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
    {{ $page_title }}
@endsection

@section('contentheader_title')
    {{ $page_title }}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> 任务管理</a></li>
        <li class="active">统计数据</li>
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
                        <li class="active">
                            <a href="{{ url('task') }}">
                                <i class="fa fa-angle-right"></i> 待执行的任务
                                <small class="label pull-right bg-green" style="margin-top: 3px;">{{ $count }}</small>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('task/executing') }}">
                                <i class="fa fa-angle-right"></i> 执行中的任务
                                <small class="label pull-right bg-green"
                                       style="margin-top: 3px;">{{ $executing }}</small>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('task/revised') }}">
                                <i class="fa fa-angle-right"></i> 修改后的任务
                                <small class="label pull-right bg-green" style="margin-top: 3px;">{{ $revised }}</small>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('task/needstop') }}">
                                <i class="fa fa-angle-right"></i> 需停止的任务
                                <small class="label pull-right bg-green" style="margin-top: 3px;">{{ $revised }}</small>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>

            <a href="{{ url('task/stat') }}" class="btn btn-primary btn-block margin-bottom">统计数据</a>
            <!-- /.box -->
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">执行中的任务
                        <small>执行中的任务，请及时上报统计数据；如果投放量已满足，请及时停止</small>
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-hover table-striped table-responsive table-bordered">
                        <tr>
                            <td>#</td>
                            <td>名称</td>
                            {{--<td>素材</td>--}}
                            <td>开始时间</td>
                            <td>结束时间</td>
                            <td>需求量</td>
                            <td>开始执行时间</td>
                            <td>停止执行时间</td>
                            <td>最近上报日期</td>
                            <td>已投放量</td>
                            {{--<td>投放方案</td>--}}
                            <td width="200px">操作</td>
                        </tr>

                        @foreach($tasks as $task)
                            <tr>
                                <td class="getTaskId" data-id="{{ $task->id }}">{{ $task->id }}</td>
                                <td>{{ $task->business->name }}</td>
                                {{--<td>
                                    <p><a href="{{ $task->business->material }}" data-fancybox>查看素材</a></p>
                                    <p><a class="copy-link" href="javascript:void(0)"
                                          data-clipboard-text="{{ $task->business->material }}" title="复制链接">复制链接</a>
                                    </p>
                                </td>--}}
                                <td>{{ substr($task->start_time, 0, 10) }}</td>
                                <td>{{ substr($task->end_time, 0, 10) }}</td>
                                <td>{{ $task->throws }}</td>
                                <td>{{ $task->exec_at }}</td>
                                <td>{{ $task->exec_end_at }}</td>
                                <td id="last_stat_date_{{ $task->id }}"></td>
                                <td id="show_{{ $task->id }}"></td>
                                {{--<td>
                                    <a href="javascript:void(0)" data-id="{{ $task->id }}" class="task_plan">查看投放方案</a>
                                </td>--}}
                                <td>
                                    <button class="btn btn-primary task-stat" data-name="{{ $task->business->name }}"
                                            data-id="{{ $task->id }}"><i class="fa fa-table"></i> 数据上报
                                    </button>
                                    <form action="{{ url('task/stop_task/' . $task->id) }}" method="post" style="display: inline">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> 停止</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-padding">
                    <div class="no-margin pull-right">
                        {{ $tasks->links() }}
                    </div>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="statModal" tabindex="-1" role="dialog" aria-labelledby="statModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="statModalLabel"></h4>
                </div>
                <form method="post" action="{{ url('stat/store') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="task_id" id="task_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="statPrice">单价</label>
                                <div class="col-sm-5">
                                    <input class="form-control" id="statPrice" name="price" type="input" required>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered" style="margin-top: 15px">
                            <tbody id="setStatTable">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">确定</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script type="text/javascript">
        var client = new ZeroClipboard(document.getElementsByClassName("copy-link"));

        client.on("ready", function (readyEvent) {

            client.on("aftercopy", function () {
                alert("链接已复制！");
            });
        });

        // 数据上报
        $(function () {
            $('.task-stat').click(function () {
                task_id = $(this).attr('data-id');
                task_name = $(this).attr('data-name');
                $('#task_id').val(task_id);
                $.ajax({
                    url: '/task/set_stat/' + task_id,
                    type: 'get',
                    success: function (data) {
                        $('#setStatTable').html('');
                        $('#statModalLabel').html(task_name + '<small>统计数据上报</small>');
                        $('#statPrice').val(data.price);

                        html = '<tr>';
                        html += '<th>日期</th>';
                        html += '<th><label class="control-label">投放量</label></th>';
                        html += '<th><label class="control-label">点击</label></th>';
                        html += '<th><label class="control-label">花销</label></th>';
                        html += '<th><label class="control-label">备注</label></th>';
                        html += '</tr>';

                        $.each(data.stat, function (i, n) {
                            html += '<tr>';
                            html += '<td>' + n.date + '<input name="stat_date[]" value="' + n.date + '" type="hidden"></td>'
                            html += '<td><div><input class="form-control" name="show[]" value="' + (n.show ? n.show : 0) + '"></div></td>';
                            html += '<td><div><input class="form-control" name="click[]" value="' + (n.click ? n.click : 0) + '"></div></td>';
                            html += '<td><div><input class="form-control" name="cost[]" value="' + (n.cost ? n.cost : 0) + '"></div></td>';
                            html += '<td><div><input class="form-control" name="remark[]" value="' + (n.remark ? n.remark : "") + '"></div></td>';
                            html += '</tr>';
                        });

                        $('#setStatTable').append(html);
                        $('#statModal').modal('show');
                    }
                });
            });
        });

        // 最近上报时间及已投放量
        var task_ids = new Array();
        $(".getTaskId").each(function () {
            task_id = $(this).attr('data-id');
            task_ids.push(task_id);
        });

        $.ajax({
            url: '/stat/get_stats',
            type: 'post',
            data: "task_ids=" + task_ids.join(','),
            success: function (data) {
                // console.log(data)
                $.each(data, function (i, n) {
                    task_id = n.stat_id;

                    $('#last_stat_date_' + task_id).html(n.last_stat_date);
                    $('#show_' + task_id).html(n.sum_shows);
                });
            }
        });
    </script>
@endsection