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

    .fixed-table-container .no-records-found {
        display: none;
    }

    #table td,
    th {
        text-align: right
    }

    #stock {
        display: none;
    }
</style>
@endsection
@section('crumb')


<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="breadcome-heading">

        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="#"></a> المشتريات<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> فواتير المشتريات</span>
            </li>
        </ul>
    </div>
</div>


@endsection

@section('content')

<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="mg-b-23">
                    <button data-toggle="modal" data-target="#cancle" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">رجوع</button>



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

                                    <a class="btn btn-primary waves-effect waves-light" href="{{route('purch-invoice.index')}}">رجــــــوع</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/cancle Company-->
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline13-list">
                            <div class="sparkline13-hd">
                                <div class="main-sparkline13-hd">
                                    <h1 style="direction:rtl">فواتير المشتريات</h1><br />
                                </div>
                            </div>
                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">
                                    <div class="form-group-inner" style="margin-right:10px;">
                                        <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22 mg-b-15">
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="hidden" value="{{$branch->id ?? 0}}" name="branch" class="form-control" placeholder="">

                                                            <input type="text" value="{{$branch->code ?? ''}}" class="form-control" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <div class="input-mask-title">
                                                            <label><b>كود الفرع</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" value="{{$branch->ar_name ?? ''}}" class="form-control" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <div class="input-mask-title">
                                                            <label><b>إسم الفرع</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" value="{{$invObj->invoice_no}}" class="form-control" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>كود الفاتورة</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" name="invoice_serial" value="{{$invObj->invoice_serial}}" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>رقم الوثيقة</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <?php
                                                            $date = date_create($invObj->invoice_date);
                                                            ?>

                                                            <input type="date" name="invoice_date" value="{{ date_format($date, 'Y-m-d')}}" class="form-control" placeholder="">
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
                                                            <select data-placeholder="Choose a Country..." disabled id="currency_id" class="chosen-select">
                                                                @foreach($currencies as $cur)
                                                                <option @if ($invObj->currency_id == $cur->id)
                                                                    selected="selected"
                                                                    @endif value="{{$cur->id}}">{{$cur->name}} /{{$cur->conversion_rate}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>كود/سعر تغيير العملة</b></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <select data-placeholder="Choose a Country..." disabled id="person_id" name="person_id" class="chosen-select">
                                                                @foreach($persons as $person)
                                                                <option @if ($invObj->person_id == $person->id)
                                                                    selected="selected"
                                                                    @endif value="{{$person->id}}">{{$person->name}} / {{$person->code}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>كود /أسم الشخص</b></label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="bt-df-checkbox" style="direction:rtl">
                                                            <input class="radio-checked" disabled @if($invObj->purch_invoice_reference == 1) checked="" @endif type="radio" onclick="stock()" value="option1" id="optionsRadios1" name="optionsRadios1">
                                                            <label><b> عام </b></label>
                                                            <input class="" type="radio" disabled value="option2" @if($invObj->purch_invoice_reference == 0) checked="" @endif onclick="orders()" id="optionsRadios2" name="optionsRadios1">
                                                            <label><b> أمر مشتريات </b></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>مرجع المشتريات</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" @if($invObj->purch_invoice_reference == 0) style="display:none" @endif id="stock">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <select data-placeholder="إختر المخزن" disabled id="stock_id" name="stock_id" class="chosen-select" tabindex="-1">
                                                                <option value="">Select</option>
                                                                @foreach($stocks as $stock)
                                                                <option @if ($invObj->stock_id == $stock->id)
                                                                    selected="selected"
                                                                    @endif value="{{$stock->id}}">{{$stock->ar_name}} / {{$stock->code}}</option>

                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>كود / اسم المخزن</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="order" @if($invObj->purch_invoice_reference == 1) style="display:none" @endif>
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <select data-placeholder="إختر المخزن" id="transaction_id" disabled name="transaction_id" class="chosen-select" tabindex="-1">
                                                                <option value="">@if($invObj->stk_transaction_id)
                                                                    {{date_format(date_create( $invObj->transaction->transaction_date),"Y-m-d")}}/{{$invObj->transaction->code}}
                                                                    @else
                                                                    select
                                                                    @endif</option>
                                                                @foreach($stocks_transactions as $trans)
                                                                <?php
                                                                $date = null;
                                                                $date = date_create($trans->transaction_date) ?>
                                                                <option value="{{$trans->id}}">{{date_format($date,"Y-m-d") }} / {{$trans->code}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>كود أمر الشراء</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <textarea class="form-control" name="notes" placeholder="">{{$invObj->notes}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>ملاحظات</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" id="total_items_price" name="total_items_price" value="{{$invObj->total_items_price}}" class="form-control" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>إجمالي سعر الصنف</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" id="local_total" name="local_total" value="{{$invObj->total_invoice_additive}}" class="form-control" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>الفاتورة المحلية</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" id="total_items_all" name="local_net_invoice" value="{{$invObj->local_net_invoice}}" class="form-control" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>إجمالي الفاتورة</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22 shadow">
                                                <h4 style="text-align:right">الإضافات</h4>
                                                <button id="addLocal" disabled onclick="addLocalRow()" type="button" class="btn_add_item">إضافة بند</button>
                                                <table class="table  table-bordered" id="local_table" data-toggle="table" data-pagination="true" data-toolbar="#toolbar" style="direction:rtl;">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="index">#</th>
                                                            <th>البند المضاف</th>
                                                            <th>قيمة البند المضتف</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="rows_local">
                                                        <?php

                                                        use App\Models\Stocks_items_total;

                                                        $localCountt = 1;

                                                        ?>
                                                        <?php
                                                        $counterrrr = 1;
                                                        ?>

                                                        @foreach($localsItems as $itemo)
                                                        <tr data-id="{{$localCountt}}">
                                                            <input type="hidden" name="localCountt" value="{{$localCountt}}">
                                                            <td> <input style="width: 30px;" type="number" readonly id="first_id{{$localCountt}}" value="{{$localCountt}}"></td>
                                                            <td>

                                                                <select data-placeholder="Choose a Country..." disabled id="select_add{{$localCountt}}" name="select_add{{$localCountt}}" class="form-control" style="width: 130px">
                                                                    @foreach ($locals as $Item)
                                                                    <option @if ($itemo->additive_item_id == $Item->id)
                                                                        selected="selected"
                                                                        @endif
                                                                        value="{{$Item->id}}">{{$Item->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>

                                                                <div class="input-mark-inner">
                                                                    <input type="text" class="form-control" readonly value="{{$itemo->additive_item_value}}" oninput="localStyle({{$localCountt}})" id="localVal{{$localCountt}}" name="localVal{{$localCountt}}" placeholder="200" style="width: 130px">
                                                                </div>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        ++$localCountt;
                                                        $counterrrr++;
                                                        if (is_countable($localsItems)) {
                                                            if ($localCountt > count($localsItems)) {


                                                        ?>

                                                                @break
                                                        <?php
                                                            }
                                                        }

                                                        ?>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row res-rtl" style="display: flex ">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow">
                                            <h3 style="text-align:right">الأصناف</h3>
                                            <button id="add" disabled type="button" class="btn btn-primary waves-effect waves-light mg-b-15" style="float: left;">إضافة صنف</button>
                                            <input type="text" id="myInput" placeholder="إبحث  الصنف ..">
                                        </div>
                                    </div>
                                    <div style="overflow-x:auto;">
                                        <table class="table  table-bordered" id="table" style="direction:rtl;">
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
                                                    <th>سعر الصنف</th>
                                                    <th> التكلفة</th>
                                                    <th>ملاحظات</th>

                                                </tr>
                                            </thead>
                                            <tbody id="rows">

                                                <?php


                                                $counter = 1;

                                                ?>
                                                <?php
                                                $counterrrr = 1;
                                                ?>

                                                @foreach($invItems as $i=> $itemo)
                                                <tr data-id="{{$counter}}">
                                                    <input type="hidden" name="counter" value="{{$counter}}">
                                                    <td> <input style="width: 30px;" type="number" readonly id="firstTT{{$counter}}" value="{{$counter}}"></td>
                                                    <td>
                                                        <input type="number" style="display: none;" value="{{$itemo->id}}" name="item_order_id{{$counter}}" id="item_order_id{{$counter}}" class="form-control " placeholder="">
                                                        <input type="text" id="upselect{{$counter}}" name="upselect{{$counter}}" readonly value="{{$itemo->Item->code ?? ''}}/{{$itemo->Item->ar_name ?? ''}}">
                                                        <input type="hidden" id="upitemId{{$counter}}" name="upitemId{{$counter}}" readonly value="{{$itemo->item_id}}">

                                                        <span id="item_search{{$counter}}" style="display:none;"></span>

                                                    </td>
                                                    <td id="ar_name{{$counter}}" class="ar_name">{{$itemo->item->ar_name ?? ''}}</td>
                                                    <td id="uom{{$counter}}" class="uom">{{$itemo->item->uom->ar_name ?? ''}}</td>


                                                    <td>
                                                        <?php
                                                        $data = App\Models\Stocks_items_total::where('item_id', $itemo->item_id)
                                                            ->where('expired_date', $itemo->expired_date)->where('batch_no', $itemo->batch_no)->first();
                                                        $dateBatch = null;
                                                        if ($data) {
                                                            $dateBatch = date_create($itemo->expired_date);
                                                        }
                                                        ?>
                                                        <input type="text" id="upselectBatch{{$counter}}" name="upselectBatch{{$counter}}" readonly value="{{$itemo->batch_no ?? ''}} /@if($dateBatch){{ date_format($dateBatch, 'Y-m-d')}}@endif /{{$itemo->item_qty ?? ''}}">
                                                        <input type="hidden" id="upitemBatch{{$counter}}" name="upitemBatch{{$counter}}" readonly value="{{$data->id ?? 0}}">

                                                        <span id="batch_search{{$counter}}" style="display:none;"></span>
                                                    </td>
                                                    <td id="batchNum{{$counter}}" class="batchNum">{{$itemo->batch_no}} </td>
                                                    <?php

                                                    $date = date_create($itemo->expired_date);
                                                    ?>
                                                    <td id="batchDate{{$counter}}" class="batchDate">{{ date_format($date, "d-m-Y")}} </td>
                                                    <td>
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="number" style="width: 200px" readonly oninput="itemQty({{$counter}})" value="{{$itemo->item_qty}}" name="upqty{{$counter}}" id="qty{{$counter}}" class="form-control item_quantity" placeholder="">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="number" step="0.01" readonly style="width: 200px" id="itemprice{{$counter}}" value="{{$itemo->item_price}}" name="upitemprice{{$counter}}" oninput="itemPrice({{$counter}})" class="form-control item_price" placeholder="">
                                                        </div>
                                                    </td>

                                                    <td id="total{{$counter}}" class="total_item_price">
                                                        {{$itemo->total_line_cost}}
                                                    </td>
                                                    <td>
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" readonly style="width: 200px" onkeypress="enterForRow(event,{{$counter}})" name="updetNote{{$counter}}" value="{{$itemo->notes}}" class="form-control detNote" placeholder="ملاحظات">
                                                        </div>
                                                    </td>



                                                </tr>

                                                <?php
                                                ++$counter;
                                                $counterrrr++;
                                                if (is_countable($invItems)) {
                                                    if ($counter > count($invItems)) {


                                                ?>

                                                        @break
                                                <?php
                                                    }
                                                }

                                                ?>
                                                @endforeach
                                                <input type="number" style="display: none;" value="{{$counterrrr}}" name="qqq" class="form-control item_quantity" placeholder="">


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
        <!-- Static Table End -->

        @endsection
        @section('modal')

        @endsection
        @section('scripts')
        <script>
            //radio
            function stock() {
                document.getElementById('stock').style.display = 'block';
                document.getElementById('order').style.display = 'none';
                $('#rows').html('');


                $('#clientPerson').val('').trigger('chosen:updated');
                $('#orderPersons').val('').trigger('chosen:updated');
            }

            function orders() {

                document.getElementById('stock').style.display = 'none';
                document.getElementById('order').style.display = 'block';
                $('#rows').html('');



            }

            $(document).ready(function() {

                $('#add').on('click', function() {

                    var rowCount = 0;

                    if ($('#table > tbody  > tr').attr('data-id')) {
                        rowCount = $('#table > tbody  > tr:last').attr('data-id');
                    }

                    person = $('#person_id option:selected').val();
                    stock = $('#stock_id option:selected').val();
                    var rowSS = parseFloat(rowCount) + 1;


                    $.ajax({
                        type: 'GET',
                        async: false,
                        data: {
                            rowcount: parseFloat(rowCount) + 1,
                            person: person,
                            stock: stock

                        },
                        url: "{{url('addInvoice-purchRow/fetch')}}",

                        success: function(data) {
                            $('#rows').append(data);
                            $("#select" + rowSS).select2();
                            $('#firstTT' + rowSS).focus();

                        },

                        error: function(request, status, error) {
                            console.log(request.responseText);
                        }
                    });


                })
                //client order
                $('select[name="clientPerson"]').on('change', function() {
                    var person = $(this).val();
                    var personText = $('select[name="clientPerson"] option:selected').text();

                    $.ajax({
                        url: "{{route('dynamicOrderInvoice.fetch')}}",
                        method: "get",
                        data: {
                            person_id: person,

                        },
                        success: function(result) {

                            $('#client_name').val(personText);
                            $('#orderPersons').html(result).trigger('chosen:updated');



                        }
                    });

                });
                //currency
                $('select[name="currency_id"]').on('change', function() {
                    var currency = $(this).val();

                    $.ajax({
                        url: "{{route('dynamicCurrencyRate.fetch')}}",
                        method: "get",
                        data: {
                            currency: currency,

                        },
                        success: function(result) {

                            $('#currency-rate').val(result);



                        }
                    });

                });
                // stock items
                $('select[name="stock_id"]').on('change', function() {
                    var person = $(this).val();
                    var stockText = $('select[name="stock_id"] option:selected').text();

                    $('#stock_name').val(stockText);

                });
                // sale person
                $('select[name="salePerson"]').on('change', function() {
                    var person = $(this).val();
                    var salePerson = $('select[name="salePerson"] option:selected').text();

                    $('#sale_name').val(salePerson);

                });
                // market Person
                $('select[name="marketPerson"]').on('change', function() {
                    var person = $(this).val();
                    var marketPerson = $('select[name="marketPerson"] option:selected').text();

                    $('#market_name').val(marketPerson);

                });

                // orders items

                $('select[name="transaction_id"]').on('change', function() {
                    var transaction = $(this).val();
                    var index = $('#table > tbody > tr').length;

                    $.ajax({
                        url: "{{route('dynamic-transactionItems-Invoice.fetch')}}",
                        method: "get",
                        data: {
                            transaction_id: transaction,

                        },
                        success: function(result) {

                            $('#rows').html(result);
                            headCalculations(index);

                        }
                    });

                });









            });

            //not submit in enter
            $('#formid').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
            // add row
            function addRow() {

                var rowCount = 0;

                if ($('#table > tbody  > tr').attr('data-id')) {
                    rowCount = $('#table > tbody  > tr:last').attr('data-id');
                }

                person = $('#person_id option:selected').val();
                stock = $('#stock_id option:selected').val();
                var rowSS = parseFloat(rowCount) + 1;


                $.ajax({
                    type: 'GET',
                    async: false,
                    data: {
                        rowcount: parseFloat(rowCount) + 1,
                        person: person,
                        stock: stock

                    },
                    url: "{{url('addInvoice-purchRow/fetch')}}",

                    success: function(data) {
                        $('#rows').append(data);
                        $("#select" + rowSS).select2();
                        $('#firstTT' + rowSS).focus();

                    },

                    error: function(request, status, error) {
                        console.log(request.responseText);
                    }
                });


            }

            // add row
            function addLocalRow() {

                var rowCountt = 0;
                rowsx = $('#local_table > tbody > tr:last').attr('data-id');

                if (rowsx) {

                    rowCountt = $('#local_table > tbody > tr:last').attr('data-id');

                }


                var rowSS = parseFloat(rowCountt) + 1;

                $.ajax({
                    type: 'GET',
                    async: false,
                    data: {
                        rowcount: parseFloat(rowCountt) + 1,


                    },
                    url: "{{url('addInvoice-purchRow-local/fetch')}}",

                    success: function(data) {

                        $('#rows_local').append(data);
                        $("#select_add" + rowSS).select2();
                        $('#first_add' + rowSS).focus();

                    },

                    error: function(request, status, error) {
                        console.log(request.responseText);
                    }
                });


            }
            // enter row
            function enterForRow(e, index) {
                if (e.keyCode == 13) {
                    addRow();

                }
            }

            // list inside table
            function deleteRow(index) {
                //delete Row

                $('#table > tbody > tr[data-id=' + index + ']').remove();


            }

            // list inside table
            function deleteLocalRow(index) {
                //delete Row

                $('#local_table > tbody > tr[data-id=' + index + ']').remove();


            }

            function editSelectVal(index) {
                debugger;

                var select_value = $('#select' + index + ' option:selected').val();
                var text = $('#select' + index + ' option:selected').text();
                var select_stock = $('#stock_id option:selected').val();

                $.ajax({
                    type: 'GET',
                    data: {

                        select_value: select_value,
                        select_stock: select_stock

                    },
                    url: "{{route('editSelectVal-purch-invoice.fetch')}}",

                    success: function(data) {
                        var result = $.parseJSON(data);
                        $("#ar_name" + index + "").text(result[0]);
                        $("#uom" + index + "").text(result[1]);

                    },
                    error: function(request, status, error) {

                        $("#uom" + index + "").text(' ');
                        $("#ar_name" + index + "").text(' ');
                        console.log(request.responseText);
                    }
                });
                $('#item_search' + index).text(text);

            }

            //price
            function itemPrice(index) {

                var price = $("#itemprice" + index + "").val();
                var qty = $("#qty" + index + "").val();

                $("#total" + index + "").text(price * qty);
                localCalculations(index);
                headCalculations(index);
                $("#itemprice" + index).attr('value', price);
            }
            //qty 
            function itemQty(index) {
                var price = $("#itemprice" + index + "").val();
                var qty = $("#qty" + index + "").val();

                $("#total" + index + "").text(price * qty);
                localCalculations(index);
                headCalculations(index);


                $("#qty" + index).attr('value', qty);
            }

            //price
            function localStyle(index) {
                var local = 0;
                local = parseFloat($('#localVal' + index).val());
                localCalculations(index);

                $("#localVal" + index).attr('value', local);


            }




            // headCalculations(index);
            function headCalculations(index) {
                index = $('#table > tbody > tr').length;
                var total = 0;
                var local = $('#local_total').val();

                $('#table > tbody  > tr').each(function() {



                    total += parseFloat($('#total' + index).text());


                })

                $('#total_items_price').val(total.toFixed(2));
                var item_pr = total + parseFloat(local);
                $('#total_items_all').val(item_pr.toFixed(2));

            }

            // localCalculations(index);
            function localCalculations(index) {

                index = $('#local_table > tbody > tr').length;
                var totalLocal = 0;

                $('#local_table > tbody  > tr').each(function() {


                    if ($('#localVal' + index).val()) {
                        totalLocal += parseFloat($('#localVal' + index).val());
                    }

                    --index;
                    console.log(totalLocal);

                })

                $('#local_total').val(totalLocal.toFixed(2));
                headCalculations(index);
            }
        </script>
        @endsection