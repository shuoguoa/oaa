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
        <li class="active">待执行的任务</li>
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
                                <small class="label pull-right bg-green" style="margin-top: 3px;">{{ $executing }}</small>
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
                    <h3 class="box-title">待执行的任务</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-hover table-striped table-responsive table-bordered">
                        <tr>
                            <td>#</td>
                            <td>名称</td>
                            <td>素材</td>
                            <td>开始时间</td>
                            <td>结束时间</td>
                            <td>需求量</td>
                            <td>投放方案</td>
                            <td width="80px">操作</td>
                        </tr>

                        @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->business->name }}</td>
                                <td>
                                    <a href="{{ $task->business->material }}" data-fancybox>查看素材</a>
                                    <button class="copy-link"
                                            data-clipboard-text="{{ $task->business->material }}" title="复制链接">复制链接</button>
                                </td>
                                <td>{{ substr($task->start_time, 0, 10) }}</td>
                                <td>{{ substr($task->end_time, 0, 10) }}</td>
                                <td>{{ $task->throws }}</td>
                                <td>
                                    <a href="javascript:void(0)" data-id="{{ $task->id }}" class="task_plan">查看投放方案</a>
                                </td>
                                <td>
                                    <form action="{{ url('task/exec/' . $task->id) }}" method="post" style="display: inline">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-play"></i> 执行</button>
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
    <div class="modal fade" id="planModal" tabindex="-1" role="dialog" aria-labelledby="planModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="planModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>投放方案</th>
                        </tr>
                        <tr>
                            <td><pre id="planContent"></pre></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script type="text/javascript">
        var client = new ZeroClipboard(document.getElementsByClassName("copy-link"));

        client.on( "ready", function( readyEvent ) {

            client.on( "aftercopy", function( ) {
                alert("链接已复制！");
            } );
        } );

        // 投放方案
        $(function() {
            $('.task_plan').click(function () {
                task_id = $(this).attr('data-id');
                $.ajax({
                    type: 'get',
                    url: '/task/show/' + task_id,
                    success: function (data) {
                        // console.log(data);
                        $('#planModalLabel').html(data.task.business.name + ' -- ' + data.task.media.name + ' -- 投放方案');

                        $('#planContent').html(data.task.plan);

                        $('#planModal').modal('show');
                    }
                });
            });
        });
    </script>
@endsection