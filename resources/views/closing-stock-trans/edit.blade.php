@extends('Layout.web')

@section('style')
<!-- x-editor CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('webassets/css/editor/select2.css')}}">
<link rel="stylesheet" href="{{ asset('webassets/css/editor/datetimepicker.css')}}">
<link rel="stylesheet" href="{{ asset('webassets/css/editor/bootstrap-editable.css')}}">
<link rel="stylesheet" href="{{ asset('webassets/css/editor/x-editor-style.css')}}">
<!-- normalize CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('webassets/css/data-table/bootstrap-table.css')}}">
<link rel="stylesheet" href="{{ asset('webassets/css/data-table/bootstrap-editable.css')}}">
<!-- select2 CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('webassets/css/select2/select2.min.css')}}">
<!-- chosen CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('webassets/css/chosen/bootstrap-chosen.css')}}">
<style>
    .pagination-info {
        display: none !important;
    }

    .page-list {
        display: none !important;
    }

    .pagination ul li {
        float: right !important;
    }

    .search input:-ms-input-placeholder {
        color: white !important;
    }

    #table td,
    th {
        text-align: right
    }
</style>
@endsection
@section('crumb')


<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="breadcome-heading">
            <div class="add-product">


            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="#"></a> المخزن <span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod">بيان الإستلامات من مخزن الصادر </span>
            </li>
        </ul>
    </div>
</div>


@endsection

@section('content')

<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
     

            <button type="button" class="btn btn-primary waves-effect waves-light mg-b-15" data-toggle="modal" data-target="#bk">رجــــوع</button>

      

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mg-b-15">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h4 style="direction:rtl" class="mg-b-15">بيان إجمالي الإستلامات من مخزن الصادر </h4>
                            <h1 style="direction:rtl">بيانات الصادر</h1><br />
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="form-group-inner" style="margin-right:10px;">
                                    <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mg-b-22">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$row->code}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="input-mask-title">
                                                        <label><b>رقم الصادر</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mg-b-22">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <?php
                                                        $date = date_create($row->transaction_date);
                                                        ?>

                                                        <input type="date" name="transaction_date" value="{{ date_format($date, 'Y-m-d')}}" class="form-control" placeholder="">

                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ الصادر</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mg-b-22">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$row->transaction->ar_name ?? ''}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="input-mask-title">
                                                        <label><b>مخزن الصادر</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mg-b-22">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$row->secondry->ar_name ?? ''}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="input-mask-title">
                                                        <label><b>مخزن الوارد</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="admin-pro-accordion-wrap shadow-inner responsive-mg-b-30">
                                    <div class="panel-group edu-custon-design" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading accordion-head">
                                                <h4 class="panel-title" style="text-align:right !important;">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse0">
                                                        <i class="fa fa-angle-double-down"></i>
                                                        الأصناف الصادرة
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse0" class="panel-collapse panel-ic collapse">
                                                <div class="panel-body admin-panel-content animated bounce">
                                                    <table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="false" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" style="direction:rtl;">
                                                        <thead>
                                                            <tr>
                                                                <th data-field="state"></th>
                                                                <th>Serial</th>
                                                                <th data-field="id">كود البند</th>
                                                                <th>إسم البند</th>
                                                                <th>UOM</th>
                                                                <th>الباتش</th>
                                                                <th>كود الباتش</th>
                                                                <th>تاريخ الصلاحية</th>
                                                                <th>إجمالي الكميات الصادرة</th>
                                                                <th>إجمالي الكميات المستلمة</th>
                                                                <th>إجمالي الكميات المتبقية</th>
                                                                <th>ملاحظات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($transItems as $index=> $transItem)
                                                            <tr>
                                                                <td></td>

                                                                <td>{{$index+1}}</td>
                                                                <td>{{$transItem->item->code ?? ''}} / {{$transItem->item->ar_name ?? ''}}</td>
                                                                <td>{{$transItem->item->ar_name ?? ''}}</td>
                                                                <td>{{$transItem->item->uom->ar_name ?? ''}}</td>
                                                                <td>
                                                                    <?php
                                                                    $data = App\Models\Stocks_items_total::where('item_id', $transItem->item_id)->where('stock_id', $transItem->transaction->primary_stock_id)
                                                                        ->where('expired_date', $transItem->expired_date)->where('batch_no', $transItem->batch_no)->first();
                                                                    $dateBatch = null;
                                                                    if ($data) {
                                                                        $dateBatch = date_create($data->expired_date);
                                                                    }
                                                                    ?>
                                                                    {{$data->batch_no ?? ''}} /@if($dateBatch){{ date_format($dateBatch, 'Y-m-d')}}@endif /{{$data->item_total_qty ?? ''}}
                                                                </td>
                                                                <td>{{$transItem->batch_no}} </td>
                                                                <?php

                                                                $date = date_create($transItem->expired_date);
                                                                ?>
                                                                <td>{{ date_format($date, "d-m-Y")}} </td>
                                                                <td>{{$transItem->item_qty}}</td>
                                                                <td>
                                                                    <?php
                                                                    $reserved = 0;
                                                                    $transSelect = App\Models\Stocks_transaction::where('parent_tranaction_id', $transItem->transaction_id)->pluck('id')->toArray();
                                                                    if ($transSelect) {
                                                                        $reserved = App\Models\Stock_transaction_item::where('item_id', $transItem->item_id)
                                                                            ->where('expired_date', $transItem->expired_date)->where('batch_no', $transItem->batch_no)->whereIn('transaction_id', $transSelect)->sum('item_qty');
                                                                    }
                                                                    $remain = $transItem->item_qty - $reserved;
                                                                    ?>
                                                                    {{$reserved}}
                                                                </td>
                                                                <td>{{$remain}}</td>
                                                                <td>{{$transItem->notes}}</td>
                                                            </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 style="direction:rtl">بيانات الإغلاق</h1><br />
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                        <form action="{{route('closing-stock-trans.store')}}" id="form-id" method="post">
                    @csrf
                    <div class="mg-b-23">
                        <button data-toggle="modal" data-target="#save" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">تــأكيد الإغلاق</button>
                    </div>
                        <!--save Company-->
                        <div id="save" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header header-color-modal bg-color-2">
                                        <h4 class="modal-title" style="text-align:right">حفظ البيانات</h4>
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>

                                        <h4>هل تريد حفظ البيانات ؟ </h4>
                                    </div>
                                    <div class="modal-footer info-md">
                                        <a data-dismiss="modal" href="#">إلغــاء</a>

                                        <button class="btn btn-primary waves-effect waves-light" name="action" value="save" onclick="document.getElementById('form-id').submit();">حفظ</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/save Company-->
                        <input type="hidden" value="{{$row->id}}" name="parent_tranaction_id" >
                        <input type="hidden"  name="secondary_stock_id" value="{{$row->secondary_stock_id}}" >
                        <input type="hidden" name="stock_id" value="{{$row->primary_stock_id}}" >

                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="form-group-inner" style="margin-right:10px;">
                                    <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>رقم الإغلاق</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="date" name="closeDate" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ الإغلاق</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <textarea type="text" name="closeNote" class="form-control" placeholder=""></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>ملاحظات</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 style="text-align:right">بيان الأصناف التي لم تستلم</h3>
                                <table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="false" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" style="direction:rtl;">
                                    <thead>
                                        <tr>
                                            <th data-field="state"></th>
                                            <th>Serial</th>
                                            <th data-field="id">كود البند</th>
                                            <th>إسم البند</th>
                                            <th>UOM</th>
                                            <th>الباتش</th>
                                            <th>كود الباتش</th>
                                            <th>تاريخ الصلاحية</th>
                                            <th>الكمية المتبقية</th>
                                            <th>ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody> <?php


                                            $counter = 1;

                                            ?>
                                        <?php
                                        $counterrrr = 1;
                                        ?>

                                        @foreach($remaining as $index=> $remains)
                                        <tr>
                                            <input type="hidden" name="counter" value="{{$counter}}">
                                            <input type="hidden" name="transItem{{$counter}}" value="{{$transItem->id}}">
                                            <td></td>

                                            <td>{{$index+1}}</td>
                                            <td>{{$remains->item->code ?? ''}} / {{$remains->item->ar_name ?? ''}}</td>
                                            <td>{{$remains->item->ar_name ?? ''}}</td>
                                            <td>{{$remains->item->uom->ar_name ?? ''}}</td>
                                            <td>
                                                <?php
                                                $data = App\Models\Stocks_items_total::where('item_id', $remains->item_id)->where('stock_id', $remains->transaction->primary_stock_id)
                                                    ->where('expired_date', $remains->expired_date)->where('batch_no', $remains->batch_no)->first();
                                                $dateBatch = null;
                                                if ($data) {
                                                    $dateBatch = date_create($data->expired_date);
                                                }
                                                ?>
                                                {{$data->batch_no ?? ''}} /@if($dateBatch){{ date_format($dateBatch, 'Y-m-d')}}@endif /{{$data->item_total_qty ?? ''}}
                                            </td>
                                            <td>{{$remains->batch_no}} </td>
                                            <?php

                                            $date = date_create($remains->expired_date);
                                            ?>
                                            <td>{{ date_format($date, "d-m-Y")}} </td>

                                            <td>

                                                <?php
                                                $reserved = 0;
                                                $transSelect = App\Models\Stocks_transaction::where('parent_tranaction_id', $remains->transaction_id)->pluck('id')->toArray();
                                                if ($transSelect) {
                                                    $reserved = App\Models\Stock_transaction_item::where('item_id', $remains->item_id)
                                                        ->where('expired_date', $remains->expired_date)->where('batch_no', $remains->batch_no)->whereIn('transaction_id', $transSelect)->sum('item_qty');
                                                }
                                                $remain = $remains->item_qty - $reserved;
                                                ?>
                                                {{$remain}} </td>
                                                <input type="hidden" value="{{$remain}}" name="remain{{$counter}}" >

                                            <td>{{$remains->notes}}</td>
                                        </tr>
                                        <?php
                                        ++$counter;

                                        if ($counter > count($remaining)) {
                                        ?>
                                            @break
                                        <?php }
                                        $counterrrr++;
                                        ?>
                                        @endforeach
                                     

                                    </tbody>
                                </table>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Static Table End -->
@endsection
@section('modal')

@endsection
@section('scripts')
<script>
</script>
@endsection