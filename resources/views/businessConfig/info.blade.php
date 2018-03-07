@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
    {{ $page_title }}
@endsection

@section('contentheader_title')
    {{ $page_title }}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> 业务配置</a></li>
        <li class="active">业务配置</li>
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
                        <li>
                            <a href="{{ url('business/config') }}">
                                <i class="fa fa-angle-right"></i> 待配置的业务
                                <small class="label pull-right bg-green" style="margin-top: 3px;">{{ $count }}</small>
                            </a>
                        </li>
                        <li class="active">
                            <a href="{{ url('business/configured') }}">
                                <i class="fa fa-angle-right"></i> 已配置的业务
                                <small class="label pull-right bg-green" style="margin-top: 3px;">{{ $num }}</small>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('business/config/list') }}">
                                <i class="fa fa-angle-right"></i> 全部业务
                                <small class="label pull-right bg-green" style="margin-top: 3px;">{{ $all }}</small>
                            </a>
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
                    <h3 class="box-title">配置信息 {{ " ---- " . $business->name }}
                    </h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body no-padding">
                    <table class="table table-hover table-striped table-responsive table-bordered">
                        <tr>
                            <th>#</th>
                            <th>名称</th>
                            <th>付款方式</th>
                            <th>付款金额</th>
                            <th>素材</th>
                            <th>结算方式</th>
                            <th>结算单价</th>
                        </tr>

                        <tr>
                            <td>{{ $business->id }}</td>
                            <td>{{ $business->name }}</td>
                            <td>
                                @if($business->payment_mode === 1)
                                    预付款
                                @elseif($business->payment_mode === 2)
                                    后付款
                                @endif
                            </td>
                            <td>{{ $business->account_amount }}</td>
                            <td>
                                @if($business->material)
                                    <a href="{{ $business->material }}" data-fancybox>查看素材</a>
                                @else
                                    --无素材--
                                @endif
                            </td>
                            <td>
                                @if($business->mode === "1")
                                    CPM
                                @elseif($business->mode === "2")
                                    CPC
                                @elseif($business->mode === "3")
                                    CPA
                                @elseif($business->mode === "4")
                                    CPS
                                @endif
                            </td>
                            <td>
                                &yen;{{ $business->price }}
                            </td>
                        </tr>
                    </table>

                    <hr/>

                    <!-- 增加配置 -->
                    <button class="btn btn-success" id="addConfig" data-id="{{ $business->id }}"
                            style="margin: -12px 0 10px 10px;"><i class="fa fa-plus"></i> 增加配置
                    </button>

                    <table class="table table-hover table-striped table-responsive table-bordered">
                        <tr>
                            <th>媒介名称</th>
                            <th>开始日期</th>
                            <th>线束日期</th>
                            <th>需求量</th>
                            <th>投放方案</th>
                            <th>开始执行时间</th>
                            <th>结束执行时间</th>
                            <th>执行状态</th>
                            <th width="162px">操作</th>
                        </tr>

                        @foreach($tasks as $task)
                            <tr>
                                <td> {{ $task->media->name }} </td>
                                <td> {{ substr($task->start_time, 0, 10) }} </td>
                                <td> {{ substr($task->end_time, 0, 10) }} </td>
                                <td> {{ $task->throws }} </td>
                                <td>
                                    <a href="javascript:void(0)" data-id="{{ $task->id }}" class="task_plan">查看投放方案</a>
                                </td>
                                <td>{{ $task->exec_at ? $task->exec_at : "" }}</td>
                                <td>{{ $task->exec_end_at ? $task->exec_end_at : "" }}</td>
                                <td>
                                    @if($task->status == 1)
                                        <span class="label label-info" style="font-size: 0.9em;">未开始</span>
                                    @elseif($task->status == 2)
                                        <span class="label label-success" style="font-size: 0.9em;">执行中</span>
                                    @elseif($task->status == 3)
                                        <span class="label label-danger" style="font-size: 0.9em;">已停止</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-default edit_plan" data-id="{{ $task->id }}">
                                        <i class="fa fa-edit"></i> 修改
                                    </button>
                                    @if($task->status == 1 || $task->status == 2)
                                        <form action="{{ url('task/stop/' . $task->id) }}" method="post"
                                              style="display: inline">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> 停止
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
                        {{ $tasks->links() }}
                    </div>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>

    <!-- Modal[投放方案] -->
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

    <!-- Modal[修改配置] -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editModalLabel"></h4>
                </div>
                <form id="edit_form" class="form-horizontal" method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <input type="hidden" id="business_id" name="business_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="start_time" class="col-sm-2 control-label">开始日期</label>

                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                    <input class="form-control start_time" id="start_time" name="start_time"
                                           type="input">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="end_time" class="col-sm-2 control-label">结束日期</label>

                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                    <input class="form-control end_time" id="end_time" name="end_time" type="input">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="throws" class="col-sm-2 control-label">投放量</label>

                            <div class="col-sm-5">
                                <input class="form-control" id="throws" name="throws" type="input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="plan" class="col-sm-2 control-label">投放方案</label>

                            <div class="col-sm-10">
                                <textarea class="form-control" id="plan" name="plan" rows="10"></textarea>
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

    <!-- Modal -->
    <div class="modal fade" id="addConfigModal" tabindex="-1" role="dialog" aria-labelledby="addConfigModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addConfigModalLabel">增加配置</h4>
                </div>
                <form class="form-horizontal" action="{{ url('business/config/store') }}" method="post">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" id="config_business_id" name="business_id">
                        <input type="hidden" name="_mode" value="2">

                        <!-- 选择媒介 -->
                        <div class="form-group{{ $errors->has("media_id") ? ' has-error' : '' }} ">
                            <label for="media_id" class="col-sm-2 control-label">选择媒介</label>

                            <div class="col-sm-5" id="chooseMedia">
                                {{--<label class="checkbox-inline" style="margin: 0 10px 0 0">
                                    <input type="checkbox" name="media_id[]" class="chooseMedia"
                                           value="{{ $media->id }}"
                                           data-id="{{ $media->id }}"
                                           data-name="{{ $media->name }}"> {{ $media->name }}
                                </label>--}}
                            </div>
                        </div>

                        <hr/>

                        <table class="table table-bordered">
                            <tbody id="businessConfig">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="reset" class="btn btn-default">重置</button>
                        <button type="submit" class="btn btn-primary">确认</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script type="text/javascript">
        $(function () {
            // 任务投放方案
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

            // 修改配置
            $('.edit_plan').click(function () {
                task_id = $(this).attr('data-id');
                $.ajax({
                    type: 'get',
                    url: '/task/show/' + task_id,
                    success: function (data) {
                        $('#editModalLabel').html(data.task.business.name + ' -- ' + data.task.media.name + ' -- 任务修改');

                        $('#edit_form').attr('action', '/task/' + task_id);

                        $('#business_id').val(data.task.business.id);
                        $('#start_time').val(data.task.start_time.slice(0, 10));
                        $('#end_time').val(data.task.end_time.slice(0, 10));
                        $('#throws').val(data.task.throws);
                        $('#plan').html(data.task.plan);

                        $('#start_time').datepicker({
                            format: "yyyy-mm-dd",
                            todayBtn: "linked",
                            // clearBtn: true,
                            language: "zh-CN",
                            todayHighlight: true
                        });

                        $('#end_time').datepicker({
                            format: "yyyy-mm-dd",
                            todayBtn: "linked",
                            // clearBtn: true,
                            language: "zh-CN",
                            todayHighlight: true
                        });

                        $('#editModal').modal('show');
                    }
                });
            });

            // 添加配置
            $('#addConfig').click(function () {
                business_id = $(this).attr('data-id');

                $.ajax({
                    url: '/task/add/' + business_id,
                    type: 'get',
                    success: function (data) {
                        $('#config_business_id').val(business_id);
                        $('#chooseMedia').html('');
                        $('#businessConfig').html('');

                        checkboxHtml = '';
                        $.each(data, function(i, n) {
                            checkboxHtml += '<label class="checkbox-inline" style="margin: 0 10px 0 0">\n' +
                                '                                    <input type="checkbox" name="media_id[]" class="chooseMedia"\n' +
                                '                                           value="' + n.id + '"\n' +
                                '                                           data-id="' + n.id + '"\n' +
                                '                                           data-name="' + n.name + '"> ' + n.name + '\n' +
                                '                                </label>';
                        });

                        $('#chooseMedia').append(checkboxHtml);

                        $(".chooseMedia").each(function(i) {
                            var j = 0;
                            $(this).click(function(){
                                var name = $(this).attr('data-name');
                                var id   = $(this).attr('data-id');
                                if (j == 0) {
                                    $(this).attr("checked", true);

                                    var html = '<tr id="media_' + id + '">\n';
                                    html += '<td class="col-sm-2" style="text-align: center; vertical-align: middle;">' + name + '</td>\n';
                                    html += '<td class="col-sm-10">\n';

                                    html += '<div class="form-group">\n';
                                    html += '<label for="start_time_' + id + '" class="col-sm-2 control-label">开始日期</label>\n';
                                    html += '<div class="col-sm-5">\n';
                                    html += '<div class="input-group">\n';
                                    html += '<span class="input-group-addon"><i class="fa fa-calendar"></i> </span>\n';
                                    html += '<input class="form-control start_time" id="start_time_' + id + '" name="start_time_' + id + '" placeholder="开始日期" type="input">\n';
                                    html += '</div>\n';
                                    html += '</div>\n';
                                    html += '</div>\n';

                                    html += '<div class="form-group">\n';
                                    html += '<label for="end_time_' + id + '" class="col-sm-2 control-label">结束日期</label>\n';
                                    html += '<div class="col-sm-5">\n';
                                    html += '<div class="input-group">\n';
                                    html += '<span class="input-group-addon"><i class="fa fa-calendar"></i> </span>\n';
                                    html += '<input class="form-control end_time" id="end_time_' + id + '" name="end_time_' + id + '" placeholder="结束日期" type="input">\n';
                                    html += '</div>\n';
                                    html += '</div>\n';
                                    html += '</div>\n';

                                    html += '<div class="form-group">\n';
                                    html += '<label for="throws_' + id + '" class="col-sm-2 control-label">需求量</label>\n';
                                    html += '<div class="col-sm-5">\n';
                                    html += '<input class="form-control" id="throws_' + id + '" name="throws_' + id + '" placeholder="需求的投放量" type="input">\n';
                                    html += '</div>\n';
                                    html += '</div>\n';

                                    html += '<div class="form-group">\n';
                                    html += '<label for="plan_' + id + '" class="col-sm-2 control-label">投放方案</label>\n';
                                    html += '<div class="col-sm-10">\n';
                                    html += '<textarea class="form-control" id="plan_' + id + '" name="plan_' + id + '" placeholder="投放方案" rows="10"></textarea>\n';
                                    html += '</div>\n';
                                    html += '</div>\n';

                                    html += '</td>\n';
                                    html += '</tr>\n';

                                    $('#businessConfig').append(html);

                                    $('#start_time_' + id).datepicker({
                                        format: "yyyy-mm-dd",
                                        todayBtn: "linked",
                                        // clearBtn: true,
                                        language: "zh-CN",
                                        todayHighlight: true
                                    });

                                    $('#end_time_' + id).datepicker({
                                        format: "yyyy-mm-dd",
                                        todayBtn: "linked",
                                        // clearBtn: true,
                                        language: "zh-CN",
                                        todayHighlight: true
                                    });

                                    j = 1;
                                } else {
                                    $(this).attr("checked", false);

                                    $("#media_" + id).remove();

                                    j = 0;
                                }
                            });
                        });
                    }
                });
                $('#addConfigModal').modal('show');
            });
        });
    </script>
@endsection