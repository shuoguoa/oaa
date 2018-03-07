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
        <li class="active">添加业务</li>
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
                        <li class="active"><a href="{{ url('business/create') }}"><i class="fa fa-angle-right"></i> 添加业务</a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-9">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">添加业务</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ url('business/store') }}" method="post">
                    <div class="box-body">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has("name") ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">名称</label>

                            <div class="col-sm-5">
                                <input class="form-control" id="name" name="name" placeholder="业务名称" type="input"
                                       value="{{ old('name') }}">
                            </div>
                            <div class="col-sm-5">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has("salesman") ? ' has-error' : '' }}">
                            <label for="salesman" class="col-sm-2 control-label">销售</label>

                            <div class="col-sm-5">
                                <select class="form-control" id="salesman" name="salesman">
                                    @foreach($salesman as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-5">
                                @if ($errors->has('salesman'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('salesman') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has("payment_mode") ? ' has-error' : '' }}">
                            <label for="payment_mode" class="col-sm-2 control-label">付款方式</label>

                            <div class="col-sm-5">
                                <div class="radio" style="display: inline; margin-right: 30px;">
                                    <label style="margin-top: 8px;">
                                        <input name="payment_mode" id="payment_mode1" value="1" checked=""
                                               type="radio" style="margin-top: 8px">
                                        预付款</label>
                                </div>
                                <div class="radio" style="display: inline">
                                    <label style="margin-top: 8px;">
                                        <input name="payment_mode" id="payment_mode2" value="2" type="radio"
                                               style="margin-top: 8px;">
                                        后付款</label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                @if ($errors->has('payment_mode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('payment_mode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group pay_after{{ $errors->has("account_id") ? ' has-error' : '' }}">
                            <label for="account_id" class="col-sm-2 control-label">到帐帐户</label>

                            <div class="col-sm-5">
                                <select class="form-control" id="account_id" name="account_id">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-5">
                                @if ($errors->has('account_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('account_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group pay_after{{ $errors->has("account_amount") ? ' has-error' : '' }}">
                            <label for="account_amount" class="col-sm-2 control-label">付款金额</label>

                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cny"></i> </span>
                                    <input class="form-control" id="account_amount" name="account_amount"
                                           placeholder="付款金额"
                                           type="input"
                                           value="{{ old('account_amount') }}">
                                    <span class="input-group-addon">元</span>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                @if ($errors->has('account_amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('account_amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group pay_after{{ $errors->has("account_time") ? ' has-error' : '' }}">
                            <label for="account_time" class="col-sm-2 control-label">付款日期</label>

                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                    <input class="form-control" id="account_time" name="account_time" placeholder="付款日期"
                                           type="input"
                                           value="{{ old('account_time') }}">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                @if ($errors->has('account_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('account_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has("material") ? ' has-error' : '' }}">
                            <label for="material" class="col-sm-2 control-label">素材</label>

                            <div class="col-sm-5">
                                <input class="form-control" id="material" name="material" placeholder="素材URL"
                                       type="input"
                                       value="{{ old('material') }}">
                            </div>
                            <div class="col-sm-5">
                                @if ($errors->has('material'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('material') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has("mode") ? ' has-error' : '' }}">
                            <label for="mode" class="col-sm-2 control-label">结算方式</label>

                            <div class="col-sm-5">
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
                            </div>
                            <div class="col-sm-5">
                                @if ($errors->has('mode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group has_price{{ $errors->has("price") ? ' has-error' : '' }}">
                            <label for="price" class="col-sm-2 control-label">结算单价</label>

                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cny"></i> </span>
                                    <input class="form-control" id="price" name="price" placeholder="结算单价"
                                           type="input"
                                           value="{{ old('price') }}">
                                    <span class="input-group-addon">元</span>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('remark') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="remark">备注</label>

                            <div class="col-sm-5">
                                <textarea id="remark" class="form-control" name="remark" rows="5"></textarea>
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
        </div>
    </div>
@endsection

@section('page-scripts')
    <script type="text/javascript">
        $(function() {
            //
            $(function() {
                $('#account_time').datepicker({
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    // clearBtn: true,
                    language: "zh-CN",
                    todayHighlight: true
                });
            });

            var payment_mode = $("input[name='payment_mode'][checked]").val();

            if(payment_mode == 2) {
                $(".pay_after").hide();
            }

            $('input[name="payment_mode"]').change(function() {
                $('.pay_after').toggle();
            });

            // 结算方式
            $('input[name="mode"]').change(function() {
                var settlement = $(this).val();
                if (settlement == 4) {
                    $('.has_price').hide();
                } else {
                    $('.has_price').show();
                }
            });

        });
    </script>
@endsection