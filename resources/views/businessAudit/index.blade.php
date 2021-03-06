@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
    {{ $page_title }}
@endsection

@section('contentheader_title')
    {{ $page_title }}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> 业务审核</a></li>
        <li class="active">待审核的业务</li>
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
                            <a href="{{ url('business/audit') }}">
                                <i class="fa fa-angle-right"></i> 待审核的业务
                                <small class="label pull-right bg-green" style="margin-top: 3px;">{{ $count }}</small>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('business/list') }}">
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
                    <h3 class="box-title">待审核的业务</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-hover table-striped table-responsive table-bordered">
                        <tr>
                            <th>#</th>
                            <th width="200px">名称</th>
                            <th>创建者</th>
                            <th>销售</th>
                            <th>付款方式</th>
                            <th>素材</th>
                            <th>结算方式</th>
                            <th>结算单价</th>
                            <th>业务状态</th>
                            <th style="width: 240px; text-align: center">操作</th>
                        </tr>

                        @foreach($auditing as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->createdBy->real_name }}</td>
                                <td>{{ $item->getSalesman->real_name }}</td>
                                <td>
                                    @if($item->payment_mode === 1)
                                        预付款
                                    @elseif($item->payment_mode === 2)
                                        后付款
                                    @endif
                                </td>
                                <td>
                                    @if($item->material)
                                        <a href="{{ $item->material }}" data-fancybox>查看素材</a>
                                    @else
                                        --无素材--
                                    @endif
                                </td>
                                <td>
                                    @if($item->mode === "1")
                                        CPM
                                    @elseif($item->mode === "2")
                                        CPC
                                    @elseif($item->mode === "3")
                                        CPA
                                    @elseif($item->mode === "4")
                                        CPS
                                    @endif
                                </td>
                                <td>
                                    &yen;{{ $item->price }}
                                </td>
                                <td>
                                    @if($item->status == 1)
                                        <span class="label label-info" style="font-size: 0.9em;">待审核</span>
                                    @elseif($item->status == 3)
                                        <span class="label label-danger" style="font-size: 0.9em;">审核未通过</span>
                                    @else
                                        <span class="label label-success" style="font-size: 0.9em;">审核通过</span>
                                    @endif
                                </td>
                                <td style="width: 240px; text-align: center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-default business_detail"
                                            data-id="{{ $item->id }}">
                                        <i class="fa fa-list"></i> 详情
                                    </button>

                                    <a href="{{ url('business/pass/' . $item->id) }}" type="button" class="btn btn-default">
                                        <i class="fa fa-check"></i> 通过
                                    </a>

                                    <button type="button" class="btn btn-default audit_failed"
                                            data-id="{{ $item->id }}">
                                        <i class="fa fa-close"></i> 驳回
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-padding">
                    <div class="no-margin pull-right">
                        {{ $auditing->links() }}
                    </div>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="detailModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>业务名称</td>
                            <td id="business_name"></td>
                        </tr>
                        <tr>
                            <td>创建者</td>
                            <td id="created_by"></td>
                        </tr>
                        <tr>
                            <td>销售</td>
                            <td id="business_salesman">/td>
                        </tr>
                        <tr>
                            <td>付款方式</td>
                            <td id="business_payment_mode"></td>
                        </tr>
                        <tr>
                            <td>到帐帐户</td>
                            <td id="business_account"></td>
                        </tr>
                        <tr>
                            <td>付款金额</td>
                            <td id="business_account_amount"></td>
                        </tr>
                        <tr>
                            <td>付款日期</td>
                            <td id="business_account_time"></td>
                        </tr>
                        <tr>
                            <td>结算方式</td>
                            <td id="business_mode"></td>
                        </tr>
                        <tr>
                            <td>结算单价</td>
                            <td id="business_price"></td>
                        </tr>
                        <tr>
                            <td>素材</td>
                            <td id="business_material"></td>
                        </tr>
                        <tr>
                            <td>状态</td>
                            <td id="business_status"></td>
                        </tr>
                        <tr>
                            <td>备注</td>
                            <td><pre id="business_remark"></pre></td>
                        </tr>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">确定</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="auditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="ModalLabel">审核不通过原因</h4>
                </div>
                <!-- form start -->
                <form class="form-horizontal" action="{{ url('business/failed') }}" method="post">
                    <div class="modal-body">
                        {{ csrf_field() }}

                        <input type="hidden" id="business_id" name="business_id">
                        <div class="form-group{{ $errors->has("audit_msg") ? ' has-error' : '' }}">
                            <label for="audit_msg" class="col-sm-2 control-label">不通过原因</label>

                            <div class="col-sm-10">
                                <textarea class="form-control" id="audit_msg" name="audit_msg" placeholder="审核不通过的原因" rows="3"></textarea>
                                @if ($errors->has('audit_msg'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('audit_msg') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="modal-footer">
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
        // 业务详情
        $('.business_detail').click(function() {
            business_id = $(this).attr('data-id');
            $.ajax({
                type: 'get',
                url: '/business/show/'+ business_id,
                success: function(data) {
                    $('#detailModalLabel').html('业务详情 ---- ' + data.name);

                    var status = data.status;
                    var status_html = '';
                    if(status == 1) {
                        status_html = '待审核';
                    } else if(status == 3) {
                        status_html = '审核未通过[<span style="color:red;">' + data.audit_msg + '</span>]';
                    } else {
                        status_html = '审核通过';
                    }

                    mode_t = '';
                    if(data.mode == 1) {
                        mode_t = 'CPM';
                    } else if(data.mode == 2) {
                        mode_t = 'CPC';
                    } else if(data.mode == 3) {
                        mode_t = 'CPA';
                    } else if (data.mode == 4) {
                        mode_t = 'CPS'
                    }

                    material_t = '';
                    if (data.material) {
                        material_t = '<a href="' + data.material + '" data-fancybox>查看素材</a>';
                    } else {
                        material_t = '--无素材--';
                    }

                    $('#business_name').html(data.name);
                    $('#created_by').html(data.created_by.real_name);
                    $('#business_salesman').html(data.get_salesman.real_name);
                    $('#business_payment_mode').html(data.payment_mode == 1 ? "预付款" : "后付款");
                    $('#business_account').html(data.account ? data.account.name : "----");
                    $('#business_account_amount').html(data.account_amount ? '&yen;' + data.account_amount : "----");
                    $('#business_account_time').html(data.account_time ? data.account_time : '----');
                    $('#business_mode').html(mode_t);
                    $('#business_price').html('&yen;' + data.price);
                    $('#business_material').html(material_t);
                    $('#business_status').html(status_html);
                    $('#business_remark').html(data.remark);

                    $('#detailModal').modal('show');
                }
            });
        });

        // 业务审核
        $('.audit_failed').click(function() {
            business_id = $(this).attr('data-id');
            $('#business_id').val(business_id);
            $('#auditModal').modal('show');
        });
    </script>
@endsection