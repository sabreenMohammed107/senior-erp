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
                <a href="#"></a> المبيعات <span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod">مرتجعات المبيعات</span>
            </li>
        </ul>
    </div>
</div>


@endsection

@section('content')

<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <!--cancle Company-->
        <div id="cancle" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header header-color-modal bg-color-2">
                        <h4 class="modal-title" style="text-align:right">رجوع البيانات</h4>
                        <div class="modal-close-area modal-close-df">
                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                        </div>
                    </div>
                    <div class="modal-body">
                        <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>

                        <h4>هل تريد الرجوع لصفحه الكل ؟ </h4>
                    </div>
                    <div class="modal-footer info-md">
                        <a data-dismiss="modal" href="#">إلغــاء</a>

                        <a class="btn btn-primary waves-effect waves-light" href="{{route('sale-invoice.index')}}">رجــــــوع</a>

                    </div>
                </div>
            </div>
        </div>
        <!--/cancle Company-->
        <form action="{{route('revert-sale.creation')}}" method="get">
            <input type="hidden" value="{{$row->id}}" id="invoice" name="invoice_row">

            <button data-toggle="modal" data-target="#cancle" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">رجوع</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light mg-b-15">إضافة مرتجع</button>

        </form>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mg-b-15">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 style="direction:rtl">فاتورة المبيعات</h1><br />
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="form-group-inner" style="margin-right:10px;">
                                    <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$row->invoice_no}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>رقم الفاتورة</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <?php
                                                        $date = date_create($row->invoice_date);
                                                        ?>
                                                        <input type="date" value="{{ date_format($date, 'Y-m-d')}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ الفاتورة</b></label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$row->local_net_invoice}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>صافي الفاتورة</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$row->notes}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b> ملاحظات</b></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$row->person_name}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>إسم العميل</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$row->person->code ?? ''}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>كود العميل</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$row->branch->ar_name ?? ''}}" class="form-control" placeholder="" readonly>

                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>كود الفرع</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$row->transaction->code ?? ''}} / {{$row->transaction->ar_name ?? ''}}" class="form-control" placeholder="" readonly>

                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>كود المخزن</b></label>
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

                                                                <th data-field="index">#</th>

                                                                <th>كود البند</th>
                                                                <th>إسم البند</th>
                                                                <th> UOM</th>
                                                                <th>الباتش</th>
                                                                <th> رقم الباتش</th>
                                                                <th>تاريخ الصلاحية</th>
                                                                <th> كميه الصنف</th>
                                                                <th> كمية البونص</th>

                                                                <th>سعر الصنف</th>
                                                                <th> التكلفة</th>
                                                                <th>نسبة الخصم</th>
                                                                <th>قيمة الخصم</th>
                                                                <th>السعر </th>
                                                                <th>نسبة الضريبة</th>
                                                                <th> الضريبة</th>
                                                                <th>الصافى</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody id="rows">



                                                            @foreach($invoiceItems as $i=> $itemo)
                                                            <tr>

                                                                <td>
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="upselect" name="upselect" readonly value="{{$itemo->Item->code ?? ''}}/{{$itemo->Item->ar_name ?? ''}}">

                                                                </td>
                                                                <td id="ar_name" class="ar_name">{{$itemo->item->ar_name ?? ''}}</td>
                                                                <td id="uom" class="uom">{{$itemo->item->uom->ar_name ?? ''}}</td>


                                                                <td>
                                                                    <?php
                                                                    $data = App\Models\Stocks_items_total::where('item_id', $itemo->item_id)
                                                                        ->where('expired_date', $itemo->expired_date)->where('batch_no', $itemo->batch_no)->first();
                                                                    $dateBatch = null;
                                                                    if ($data) {
                                                                        $dateBatch = date_create($itemo->expired_date);
                                                                    }
                                                                    ?>
                                                                    <input type="text" id="upselectBatch" name="upselectBatch" readonly value="{{$itemo->batch_no ?? ''}} /@if($dateBatch){{ date_format($dateBatch, 'Y-m-d')}}@endif /{{$itemo->item_qty ?? ''}}">
                                                                    <input type="hidden" id="upitemBatch" name="upitemBatch" readonly value="{{$data->id ?? 0}}">

                                                                    <span id="batch_search" style="display:none;"></span>
                                                                </td>
                                                                <td id="batchNum" class="batchNum">{{$itemo->batch_no}} </td>
                                                                <?php

                                                                $date = date_create($itemo->expired_date);
                                                                ?>
                                                                <td id="batchDate" class="batchDate">{{ date_format($date, "d-m-Y")}} </td>
                                                                <td>

                                                                    {{$itemo->item_qty}}
                                                                </td>
                                                                <td>

                                                                    {{$itemo->item_bonus_qty}}
                                                                </td>

                                                                <td>
                                                                    {{$itemo->item_price}}
                                                                </td>

                                                                <td id="total" class="total_item_price">
                                                                    {{$itemo->total_line_cost}}
                                                                </td>
                                                                <td>
                                                                    {{$itemo->item_disc_perc}}

                                                                </td>
                                                                <td>
                                                                    {{$itemo->item_disc_value}}

                                                                </td>
                                                                <td id="final" class="total_item_final">
                                                                    {{$itemo->final_line_cost}}
                                                                </td>
                                                                <td id="totalvat" class="input-mark-inner mg-b-22 vat_tax_value">

                                                                    {{$itemo->item_vat_value ?? ''}}
                                                                </td>
                                                                <td id="totalcit" class="input-mark-inner mg-b-22 comm_industr_tax">

                                                                    {{$itemo->final_line_cost *  $itemo->vat_value }}


                                                                </td>
                                                                <td id="finalAll" class="total_item_final">
                                                                    {{ $itemo->final_line_cost}}
                                                                </td>



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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 style="direction:rtl">بيانات المرتجعات السابقة</h1><br />
                        </div>
                    </div>
                    @foreach($masterDetails as $i=> $masterDetails)
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div class="form-group-inner" style="margin-right:10px;">
                                <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" value="{{$masterDetails->master->code}}" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b>كود الحركة</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <?php
                                                    $date = date_create($masterDetails->master->transaction_date);
                                                    ?>

                                                    <input type="date" name="transaction_date" value="{{ date_format($date, 'Y-m-d')}}" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b>تاريخ الحركة</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" value="{{$masterDetails->master->transaction->code ?? ''}} / {{$masterDetails->master->transaction->ar_name ?? ''}}" class="form-control" placeholder="" readonly>

                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b>كود المخزن</b></label>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" value="{{$masterDetails->master->person->code ?? ''}} / {{$masterDetails->master->person_name}}" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b>كود العميل</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" id="total_items_price" name="total_items_price" value="{{$masterDetails->master->total_items_price}}" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b> أجمالى المرتجع</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <textarea class="form-control" placeholder="">{{$masterDetails->master->notes}}</textarea>
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
                            <div class="admin-pro-accordion-wrap shadow-inner responsive-mg-b-30">
                                <div class="panel-group edu-custon-design" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading accordion-head">
                                            <h4 class="panel-title" style="text-align:right !important;">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i+1}}"><i class="fa fa-angle-double-down"></i>
                                                    الأصناف المرتجعة
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse{{$i+1}}" class="panel-collapse panel-ic collapse">
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
                                                            <th> كميه الصنف</th>
                                                            <th> كمية البونص</th>

                                                            <th>سعر الصنف</th>
                                                            <th> التكلفة</th>
                                                            <th>نسبة الخصم</th>
                                                            <th>قيمة الخصم</th>
                                                            <th>السعر </th>
                                                            <th>نسبة الضريبة</th>
                                                            <th> الضريبة</th>
                                                            <th>الصافى</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($masterDetails->details as $index=> $detail)
                                                        <tr>
                                                            <td></td>

                                                            <td>{{$index+1}}</td>
                                                            <td>{{$detail->item->code ?? ''}} / {{$detail->item->ar_name ?? ''}}</td>
                                                            <td>{{$detail->item->ar_name ?? ''}}</td>
                                                            <td>{{$detail->item->uom->ar_name ?? ''}}</td>
                                                            <td>
                                                                <?php
                                                                $data = App\Models\Stocks_items_total::where('item_id', $detail->item_id)->where('stock_id', $detail->transaction->primary_stock_id)
                                                                    ->where('expired_date', $detail->expired_date)->where('batch_no', $detail->batch_no)->first();
                                                                $dateBatch = null;
                                                                if ($data) {
                                                                    $dateBatch = date_create($data->expired_date);
                                                                }
                                                                ?>
                                                                {{$data->batch_no ?? ''}} /@if($dateBatch){{ date_format($dateBatch, 'Y-m-d')}}@endif /{{$data->item_total_qty ?? ''}}
                                                            </td>
                                                            <td>{{$detail->batch_no}} </td>
                                                            <?php

                                                            $date = date_create($detail->expired_date);
                                                            ?>
                                                            <td>{{ date_format($date, "d-m-Y")}} </td>
                                                            <td>

                                                                {{$detail->item_qty}}
                                                            </td>
                                                            <td>

                                                                {{$detail->item_bonus_qty}}
                                                            </td>
                                                            <td>

                                                                {{$detail->item_price}}
                                                            </td>
                                                            <td> {{$detail->total_line_cost}}</td>

                                                            <td>
                                                                {{$detail->item_disc_perc}}

                                                            </td>
                                                            <td>
                                                                {{$detail->item_disc_value}}

                                                            </td>
                                                            <td id="final" class="total_item_final">
                                                                {{$detail->final_line_cost}}
                                                            </td>
                                                            <td id="totalvat" class="input-mark-inner mg-b-22 vat_tax_value">

                                                                {{$detail->item_vat_value ?? ''}}
                                                            </td>
                                                            <td id="totalcit" class="input-mark-inner mg-b-22 comm_industr_tax">

                                                                {{$detail->final_line_cost *  $detail->vat_value }}


                                                            </td>
                                                            <td id="finalAll" class="total_item_final">
                                                                {{ $detail->final_line_cost}}
                                                            </td>

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
                    @endforeach
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