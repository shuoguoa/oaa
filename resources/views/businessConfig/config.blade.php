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
                        <li class="active">
                            <a href="{{ url('business/config') }}">
                                <i class="fa fa-angle-right"></i> 待配置的业务
                                <small class="label pull-right bg-green" style="margin-top: 3px;">{{ $count }}</small>
                            </a>
                        </li>
                        <li>
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
                    <h3 class="box-title">配置 {{ " ---- " . $business->name }}
                    </h3>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" action="{{ url('business/config/store') }}" method="post">
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

                        {{ csrf_field() }}
                        <input type="hidden" name="business_id" value="{{ $business->id }}">
                        <input type="hidden" name="_mode" value="1">

                        <!-- 选择媒介 -->
                        <div class="form-group{{ $errors->has("media_id") ? ' has-error' : '' }} ">
                            <label for="media_id" class="col-sm-2 control-label">选择媒介</label>

                            <div class="col-sm-5">
                                @foreach($medias as $media)
                                    <label class="checkbox-inline" style="margin: 0 10px 0 0">
                                        <input type="checkbox" name="media_id[]" class="chooseMedia"
                                               value="{{ $media->id }}"
                                               data-id="{{ $media->id }}"
                                               data-name="{{ $media->name }}"> {{ $media->name }}
                                    </label>
                                @endforeach
                            </div>

                            <div class="col-sm-5">
                                @if ($errors->has('media_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('media_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr/>

                        <table class="table table-bordered">
                            <tbody id="businessConfig">

                            </tbody>
                        </table>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <div class="col-sm-offset-2">
                            <button type="reset" class="btn btn-default">重置</button>
                            <button type="submit" class="btn btn-info">确认</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript">
        $(function() {
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


        });
    </script>
@endsection