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
        <li class="active">修改业务</li>
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
                        <li><a href="{{ url('business') }}"><i class="fa fa-angle-right"></i> 业务列表</a></li>
                        <li><a href="{{ url('business/create') }}"><i class="fa fa-angle-right"></i> 添加业务</a></li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-9">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title" id="editLabel"></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form id="editForm" class="form-horizontal" method="post" action="{{ url('business/' . $id) }}">
                    <div class="modal-body">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="business_id" value="{{ $id }}">

                        <div class="form-group{{ $errors->has("name") ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">名称</label>

                            <div class="col-sm-10">
                                <input class="form-control" id="edit_name" name="name" placeholder="业务名称" type="input">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has("salesman") ? ' has-error' : '' }}">
                            <label for="salesman" class="col-sm-2 control-label">销售</label>

                            <div class="col-sm-10">
                                <select class="form-control" id="edit_salesman" name="salesman">
                                    @foreach($salesman as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('salesman'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('salesman') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has("payment_mode") ? ' has-error' : '' }}">
                            <label for="payment_mode" class="col-sm-2 control-label">付款方式</label>

                            <div class="col-sm-10">
                                <div class="radio" style="display: inline; margin-right: 30px;">
                                    <label style="margin-top: 8px;">
                                        <input name="payment_mode" id="payment_mode1" value="1"
                                               type="radio" style="margin-top: 8px">
                                        预付款</label>
                                </div>
                                <div class="radio" style="display: inline">
                                    <label style="margin-top: 8px;">
                                        <input name="payment_mode" id="payment_mode2" value="2" type="radio"
                                               style="margin-top: 8px;">
                                        后付款</label>
                                </div>
                                @if ($errors->has('payment_mode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('payment_mode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group pay_after{{ $errors->has("account_id") ? ' has-error' : '' }}">
                            <label for="account_id" class="col-sm-2 control-label">到帐帐户</label>

                            <div class="col-sm-10">
                                <select class="form-control" id="edit_account_id" name="account_id">
                                    <option value="0">请选择...</option>
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('account_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('account_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group pay_after{{ $errors->has("account_amount") ? ' has-error' : '' }}">
                            <label for="account_amount" class="col-sm-2 control-label">付款金额</label>

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cny"></i> </span>
                                    <input class="form-control" id="edit_account_amount" name="account_amount"
                                           placeholder="付款金额"
                                           type="input">
                                    <span class="input-group-addon">元</span>
                                </div>
                                @if ($errors->has('account_amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('account_amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group pay_after{{ $errors->has("account_time") ? ' has-error' : '' }}">
                            <label for="account_time" class="col-sm-2 control-label">付款日期</label>

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                    <input class="form-control" id="edit_account_time" name="account_time" placeholder="付款日期"
                                           type="input"
                                           value="{{ old('account_time') }}">
                                </div>
                                @if ($errors->has('account_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('account_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has("material") ? ' has-error' : '' }}">
                            <label for="material" class="col-sm-2 control-label">素材</label>

                            <div class="col-sm-10">
                                <input class="form-control" id="edit_material" name="material" placeholder="素材URL"
                                       type="input">
                                @if ($errors->has('material'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('material') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has("mode") ? ' has-error' : '' }}">
                            <label for="mode" class="col-sm-2 control-label">结算方式</label>

                            <div class="col-sm-10">
                                <div class="radio" style="display: inline; margin-right: 15px;">
                                    <label style="margin-top: 8px;">
                                        <input name="mode" id="mode1" value="1" checked=""
                                               type="radio" style="margin-top: 8px">
                                        CPM</label>
                                </div>
                                <div class="radio" style="display: inline; margin-right: 15px;">
                                    <label style="margin-top: 8px;">
                                        <input name="mode" id="mode2" value="2" type="radio"
                                               style="margin-top: 8px;">
                                        CPC</label>
                                </div>
                                <div class="radio" style="display: inline; margin-right: 15px;">
                                    <label style="margin-top: 8px;">
                                        <input name="mode" id="mode3" value="3" type="radio"
                                               style="margin-top: 8px;">
                                        CPA</label>
                                </div>
                                <div class="radio" style="display: inline">
                                    <label style="margin-top: 8px;">
                                        <input name="mode" id="mode4" value="4" type="radio"
                                               style="margin-top: 8px;">
                                        CPS</label>
                                </div>
                                @if ($errors->has('mode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group has_price{{ $errors->has("price") ? ' has-error' : '' }}">
                            <label for="price" class="col-sm-2 control-label">结算单价</label>

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cny"></i> </span>
                                    <input class="form-control" id="edit_price" name="price" placeholder="结算单价"
                                           type="input"
                                           value="{{ old('price') }}">
                                    <span class="input-group-addon">元</span>
                                </div>
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('remark') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="remark">备注</label>

                            <div class="col-sm-10">
                                <textarea id="edit_remark" class="form-control" name="remark" rows="5"></textarea>
                            </div>
                            @if ($errors->has('remark'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('remark') }}</strong>
                                </span>
                            @endif
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
        $(function() {
            // 日期选择
            $('#edit_account_time').datepicker({
                format: "yyyy-mm-dd",
                todayBtn: "linked",
                // clearBtn: true,
                language: "zh-CN",
                todayHighlight: true
            });

            var payment_mode = $("input[name='payment_mode'][checked]").val();

            if(payment_mode == 2) {
                $(".pay_after").hide();
            }

            $('input[name="payment_mode"]').change(function() {
                $('.pay_after').toggle();
            });

            business_id = $("#business_id").val();
            // $('#editForm').attr('action', 'business/' + business_id);

            // 结算方式
            $('input[name="mode"]').change(function() {
                var settlement = $(this).val();
                if (settlement == 4) {
                    $('.has_price').hide();
                } else {
                    $('.has_price').show();
                }
            });

            $.ajax({
                type: 'get',
                url: '/business/show/'+ business_id,
                success: function(data) {
                    $('#editLabel').html('业务修改 ---- ' + data.name);
                    if (data.payment_mode == 2) {
                        $('.pay_after').hide();
                        $('#edit_account_id option[value="0"]').attr("selected", true);
                        $('#edit_account_amount').val('');
                        $('#edit_account_time').val('');
                    } else {
                        $('.pay_after').show();
                        $('#edit_account_id option[value="' + data.account_id + '"]').attr("selected", true);
                        $('#edit_account_amount').val(data.account_amount);
                        $('#edit_account_time').val(data.account_time);
                    }

                    if (data.mode == 4) {
                        $('.has_price').hide();
                        $('#edit_price').val('');
                    } else {
                        $('.has_price').show();
                        $('#edit_price').val(data.price);
                    }

                    $('#edit_name').val(data.name);
                    $('#edit_salesman option[value="' + data.salesman + '"]').attr("selected", true);
                    $("input[name='payment_mode'][value=" + data.payment_mode + "]").attr("checked", true);
                    $('#edit_material').val(data.material);

                    $('#edit_remark').html(data.remark);

                    $('input[name="mode"][value="' + data.mode + '"]').attr("checked", true);
                    $('#editModal').modal('show');
                }
            });
        });
    </script>
@endsection