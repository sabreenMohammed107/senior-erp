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
                <a href="#"></a> المبيعات<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> فواتير المبيعات</span>
            </li>
        </ul>
    </div>
</div>


@endsection

@section('content')
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="direction: rtl;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align:center">تحذير</h4>
            </div>
            <div class="modal-body">
                <p>هذه الكميه اكبر من اعلى قيمه مجوده فى المخزن سوف يتم ارجاعك لاعلى كميه موجوده .</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
            </div>
        </div>

    </div>
</div>
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="mg-b-23">
                    <button data-toggle="modal" data-target="#cancle" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">رجوع</button>

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

                                    <button class="btn btn-primary waves-effect waves-light" name="action" value="save" onclick="document.getElementById('formid').submit();">حفظ</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/save Company-->
                    <!--confi Company-->
                    <div id="confi" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header header-color-modal bg-color-2">
                                    <h4 class="modal-title" style="text-align:right"> تأكيد الحفظ</h4>
                                    <div class="modal-close-area modal-close-df">
                                        <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>

                                    <h4>هل تريد تأكيد حفظ البيانات ؟ </h4>
                                </div>
                                <div class="modal-footer info-md">
                                    <a data-dismiss="modal" href="#">إلغــاء</a>
                                    <button class="btn btn-primary waves-effect waves-light" name="action" value="confirm" onclick="document.getElementById('formid').submit();">حفظ</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/conf Company-->

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
                </div>
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 style="direction:rtl">فواتير المبيعات</h1><br />
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright" style="direction:rtl">
                            <div class="form-group-inner" style="margin-right:10px;">
                                <div class="row" style="text-align:right !important;direction:rtl !important">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 shadow">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" class="form-control" disabled value="{{$currencyRate->conversion_rate ?? ''}}" id="currency-rate" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>النسبة</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <select data-placeholder="Choose a Country..." disabled id="currency_id" name="currency_id" class="chosen-select" tabindex="-1">
                                                            <option value="">Select</option>
                                                            @foreach($currencies as $cur)
                                                            <option @if ($invObj->currency_id == $cur->id)
                                                                selected="selected"
                                                                @endif value="{{$cur->id}}">{{$cur->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>كود العملة</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{$branch->id ?? 0}}" name="branch" class="form-control" placeholder="">

                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$branch->ar_name ?? ''}}" readonly class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>الإسم</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" value="{{$branch->code ?? ''}}" readonly class="form-control" placeholder="فرع القاهرة ">

                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>كود الفرع</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="client_name" readonly value="{{$invObj->person_name}}" readonly name="person_name" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>الإسم</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <select data-placeholder="إختر العميل" disabled name="clientPerson" id="clientPerson" class="chosen-select" tabindex="-1">
                                                            <option value="0">Select</option>
                                                            @foreach($persons as $person)
                                                            <option @if ($invObj->person_id == $person->id)
                                                                selected="selected"
                                                                @endif value="{{$person->id}}">{{$person->name}} / {{$person->code}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>كود العميل</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="sale_name" value="{{$saleName->ar_name ?? ''}}" readonly name="sale_name" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>المبيعات</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <select data-placeholder="إختر مسئول المبيعات" disabled name="salePerson" id="salePerson" class="chosen-select" tabindex="-1">
                                                            @foreach($saleCodes as $sale)
                                                            <option @if ($invObj->sales_rep_id == $sale->id)
                                                                selected="selected"
                                                                @endif value="{{$sale->id}}">{{$sale->ar_name}} / {{$sale->code}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>مسئول المبيعات</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" readonly id="market_name" value="{{$marketName->ar_name ?? ''}}" name="market_name" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>تسويق</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <select data-placeholder="إختر مسئول التسويق" disabled name="marketPerson" id="marketPerson" class="chosen-select" tabindex="-1">
                                                            <option value="">Select</option>
                                                            @foreach($MarktCodes as $market)
                                                            <option @if ($invObj->marketing_rep_id == $market->id)
                                                                selected="selected"
                                                                @endif value="{{$market->id}}">{{$market->ar_name}} / {{$market->code}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>مسئول التسويق</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- checked test -->
                                        <div class="row" id="allStock" @if(!$invObj->order_id) style="display:block" @else style="display:none" @endif>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="stock_name" readonly value="{{$stockName->ar_name ?? ''}}" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>المخزن</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <select data-placeholder="إختر المخزن" disabled id="stock_id" name="stock_id" class="chosen-select" tabindex="-1">
                                                            <option value="">Select</option>
                                                            @foreach($stocks as $stock)
                                                            <option @if ($invObj->stock_id == $stock->id)
                                                                selected="selected"
                                                                @endif value="{{$stock->id}}">{{$stock->ar_name}} / {{$stock->code}}</option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>كودالمخزن</b></label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- unchecked -->
                                        <div class="row" id="checkOrder" @if($invObj->order_id) style="display:block" @else style="display:none" @endif>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <!-- <select data-placeholder="إختر أمر البيع" id="orderPersons" class="chosen-select" name="orderPersons" tabindex="-1">

                                                            </select> -->

                                                        <input type="text" readonly id="orderPersons" value="{{$orders->purch_order_no ?? '' }} - {{$orders->person_name ?? ''}}" name="orderPersons" class="form-control" placeholder="">

                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>أوامر البيع</b></label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- end -->
                                        <div class="row">
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12"></div>
                                            <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" disabled value="{{$invObj->notes}}" name="notes" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>ملاحظات</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 shadow">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" id="total_items_price" value="{{$invObj->total_items_price}}" name="total_items_price" readonly class="form-control" placeholder="إجمالي السعر">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="input-mask-title">
                                                    <label><b>إجمالي السعر</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" id="total_items_vat" value="{{$invObj->total_vat_value}}" name="total_vat_value" readonly class="form-control" placeholder="إجمالي الضريبة">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="input-mask-title">
                                                    <label><b>إجمالي الضريبة</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" readonly id="total_items_discount" value="{{$invObj->total_disc_value}}" name="total_disc_value" class="form-control" placeholder="إجمالي الخصم">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="input-mask-title">
                                                    <label><b>إجمالي الخصم</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" id="total_items_finalqty" value="{{$invObj->total_bonus_qty}}" name="total_bonus_qty" readonly class="form-control" placeholder="إجمالي الكمية">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="input-mask-title">
                                                    <label><b>إجمالي البونص</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" id="total_items_all" value="{{$invObj->local_net_invoice}}" name="local_net_invoice" readonly class="form-control" placeholder="صافي الفاتورة">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="input-mask-title">
                                                    <label><b>صافي الفاتورة</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 shadow">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <div class="input-mark-inner mg-b-22">
                                                    <select data-placeholder="Choose a Country..." disabled onfocusin="currentV()" name="pay_type_id" id="pay_type_id" class="chosen-select" tabindex="-1">
                                                        @foreach($paytypes as $type)
                                                        <option @if ($invObj->pay_type_id == $type->id)
                                                            selected="selected"
                                                            @endif value="{{$type->id}}">{{$type->ar_name}}</option>
                                                        @endforeach
                                                    </select> </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="input-mask-title">
                                                    <label><b>طريقة الدفع</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                <div class="bt-df-checkbox">
                                                    <input class="radio-checked" disabled @if(!$invObj->order_id) checked @endif type="radio" onclick="stocks()" value="option1" id="optionsRadios1" name="optionsRadios">
                                                    <label><b>عام</b></label>
                                                    <input class="" type="radio" disabled @if($invObj->order_id) checked @endif value="option2" onclick="orders()" id="optionsRadios2" name="optionsRadios">
                                                    <label><b>أمر بيع</b></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <label class="login2 pull-right pull-right-pro">مرجع المبيعات</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" name="invoice_no" value="{{$invObj->invoice_no}}" readonly class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="input-mask-title">
                                                    <label><b>رقم الفاتورة</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <div class="input-mark-inner mg-b-22">
                                                    <?php
                                                    $date = date_create($invObj->invoice_date);
                                                    ?>
                                                    <input type="date" readonly value="{{ date_format($date, 'Y-m-d')}}" name="invoice_date" class="form-control" placeholder="">

                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="input-mask-title">
                                                    <label><b>تاريخ الفاتورة</b></label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>التأكيد</b></label>
                                                    </div>
                                                </div>
                                            </div> -->
                                    </div>
                                </div>

                            </div>
                            <div class="row res-rtl" style="display: flex ">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow">
                                    <h3 style="text-align:right">الأصناف</h3>
                                    <button id="add" type="button" disabled class="btn btn-primary waves-effect waves-light mg-b-15" style="float: left;">إضافة صنف</button>
                                    <input type="text" id="myInput" placeholder="إبحث  الصنف ..">
                                </div>
                            </div>
                            <div style="overflow-x:auto;">
                                <table class="table  table-bordered" id="table" style="direction:rtl;">
                                    <thead>
                                        <tr>

                                            <th data-field="index">#</th>

                                            <th>كود الصنف</th>
                                            <th>إسم الصنف</th>
                                            <th> وحدة القياس</th>
                                            <th>الباتش</th>
                                            <th> رقم الباتش</th>
                                            <th>تاريخ الصلاحية</th>
                                            <th>الكمية الحالية</th>
                                            <th> كميه الصنف</th>
                                            <th> كمية البونص</th>
                                            <th>سعر الصنف</th>
                                            <th> التكلفة</th>
                                            <th>نسبة الخصم</th>
                                            <th>قيمة الخصم</th>
                                            <th>اجمالى بعد الخصم </th>
                                            <th>نسبة الضريبة</th>
                                            <th> الضريبة</th>
                                            <th>الصافى</th>

                                        </tr>
                                    </thead>
                                    <tbody id="rows">
                                        <?php

                                        use App\Models\Stocks_items_total;

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
                                                <input type="number" style="display: none;" value="{{$itemo->id}}" name="item_inv_id{{$counter}}" id="item_order_id{{$counter}}" class="form-control " placeholder="">
                                                <input type="text" id="upselect{{$counter}}" name="upselect{{$counter}}" readonly value="{{$itemo->Item->code ?? ''}}/{{$itemo->Item->ar_name ?? ''}}">
                                                <input type="hidden" id="upitemId{{$counter}}" name="upitemId{{$counter}}" readonly value="{{$itemo->item_id}}">

                                                <span id="item_search{{$counter}}" style="display:none;">{{$itemo->Item->code ?? ''}}/{{$itemo->Item->ar_name ?? ''}}</span>

                                            </td>

                                            <td id="ar_name{{$counter}}" class="ar_name">{{$itemo->item->ar_name ?? ''}}</td>
                                            <td id="uom{{$counter}}" class="uom">{{$itemo->item->uom->ar_name ?? ''}}</td>

                                            <td>
                                                <?php
                                                $data = App\Models\Stocks_items_total::where('item_id', $itemo->item_id)->where('stock_id', $itemo->invoice->stock_id)
                                                    ->where('expired_date', $itemo->expired_date)->where('batch_no', $itemo->batch_no)->first();
                                                $dateBatch = null;
                                                if ($data) {
                                                    $dateBatch = date_create($data->expired_date);
                                                }
                                                ?>
                                                <input type="text" id="upselectBatch{{$counter}}" name="upselectBatch{{$counter}}" readonly value="{{$data->batch_no ?? ''}} /@if($dateBatch){{ date_format($dateBatch, 'Y-m-d')}}@endif /{{$data->item_total_qty ?? ''}}">
                                                <input type="hidden" id="upitemBatch{{$counter}}" name="upitemBatch{{$counter}}" readonly value="{{$data->id}}">

                                                <span id="batch_search{{$counter}}" style="display:none;">{{$data->batch_no ?? ''}} /@if($dateBatch){{ date_format($dateBatch, 'Y-m-d')}}@endif /{{$data->item_total_qty ?? ''}}</span>
                                            </td>
                                            <td id="batchNum{{$counter}}" class="batchNum">{{$itemo->batch_no}} </td>
                                            <?php

                                            $date = date_create($itemo->expired_date);
                                            ?>
                                            <td id="batchDate{{$counter}}" class="batchDate">{{ date_format($date, "d-m-Y")}} </td>
                                            <td id="batchqty{{$counter}}" class="batchqty">{{$data->item_total_qty ?? ''}} </td>


                                            <td>
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="number" readonly style="width: 200px" oninput="itemQty({{$counter}})" value="{{$itemo->item_qty}}" onfocusout="maxQty({{$counter}})" name="upqty{{$counter}}" id="qty{{$counter}}" class="form-control item_quantity" placeholder="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="number" readonly style="width: 200px" oninput="itemBonas({{$counter}})" value="{{$itemo->item_bonus_qty}}" name="upitemBonas{{$counter}}" id="itemBonas{{$counter}}" class="form-control " placeholder="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="number" readonly step="0.01" style="width: 200px" readonly id="itemprice{{$counter}}" value="{{$itemo->item_price}}" name="upitemprice{{$counter}}" oninput="itemPrice({{$counter}})" class="form-control item_price" placeholder="">
                                                </div>
                                            </td>

                                            <td id="total{{$counter}}" class="total_item_price">
                                                {{$itemo->total_line_cost}}
                                            </td>
                                            <td>
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="number" readonly step="0.001" style="width: 200px" value="{{$itemo->item_disc_perc}}" oninput="disPer({{$counter}})" name="upper{{$counter}}" id="per{{$counter}}" class="form-control item_dis" placeholder="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="number" readonly step="0.01" style="width: 200px" onkeypress="enterForRow(event,{{$counter}})" value="{{$itemo->item_disc_value}}" oninput="disval({{$counter}})" name="updisval{{$counter}}" id="disval{{$counter}}" class="form-control item_disval" placeholder="">
                                                </div>
                                            </td>
                                            <td id="final{{$counter}}" class="total_item_final">
                                                {{$itemo->final_line_cost}}
                                            </td>
                                            <td id="totalvat{{$counter}}" class="input-mark-inner mg-b-22 vat_tax_value">
                                                <input type="hidden" value="" name="uptotalvat1{{$counter}}">
                                                {{$itemo->item_vat_perc}}
                                            </td>
                                            <td id="totalcit{{$counter}}" class="input-mark-inner mg-b-22 comm_industr_tax">
                                                <input type="hidden" value="" name="totalcit1{{$counter}}">
                                                {{$itemo->item_vat_value}}


                                            </td>
                                            <td id="finalAll{{$counter}}" class="total_item_final">
                                                {{ $itemo->final_line_cost}}
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
    function stocks() {
        document.getElementById('allStock').style.display = 'block';
        document.getElementById('checkOrder').style.display = 'none';
        $('#rows').html('');
        $('#rows').html('');

        $('#total_items_price').val('');
        $('#total_items_discount').val('');
        $('#total_items_vat').val('');
        $('#total_items_finalqty').val('');
        $('#total_items_all').val('');


        $('#clientPerson').val('').trigger('chosen:updated');
        $('#orderPersons').val('').trigger('chosen:updated');
    }

    function orders() {

        document.getElementById('allStock').style.display = 'none';
        document.getElementById('checkOrder').style.display = 'block';
        $('#rows').html('');

        $('#clientPerson').val('').trigger('chosen:updated');
        $('#orderPersons').val('').trigger('chosen:updated');
        $('#total_items_price').val('');
        $('#total_items_discount').val('');
        $('#total_items_vat').val('');
        $('#total_items_finalqty').val('');
        $('#total_items_all').val('');


    }

    $(document).ready(function() {

        $('#add').on('click', function() {
            var rowCount = 0;

            if ($('#table > tbody  > tr').attr('data-id')) {
                rowCount = $('#table > tbody  > tr:last').attr('data-id');
            }

            order = $('#orderPersons option:selected').val();
            stock = $('#stock_id option:selected').val();
            var pay = $('#pay_type_id option:selected').val();
            var rowSS = parseFloat(rowCount) + 1;


            $.ajax({
                type: 'GET',
                async: false,
                data: {
                    rowcount: parseFloat(rowCount) + 1,
                    order: order,
                    stock: stock

                },
                url: "{{url('addInvoiceRow/fetch')}}",

                success: function(data) {

                    $('#rows').append(data);
                    $("#select" + rowSS).select2();
                    $('#firstTT' + rowSS).focus();
                    if (pay == 3) {
                        bonasDetails(rowSS);
                    }
                    if (pay == 4) {
                        adsDetails(rowSS);
                    }
                    console.log(rowSS);
                },

                error: function(request, status, error) {
                    console.log(request.responseText);
                }
            });


        })
        //client order
        // $('select[name="clientPerson"]').on('change', function() {
        //     var person = $(this).val();
        //     var personText = $('select[name="clientPerson"] option:selected').text();

        //     $.ajax({
        //         url: "{{route('dynamicOrderInvoice.fetch')}}",
        //         method: "get",
        //         data: {
        //             person_id: person,

        //         },
        //         success: function(result) {

        //             $('#client_name').val(personText);
        //             $('#orderPersons').html(result).trigger('chosen:updated');



        //         }
        //     });

        // });

        //client order
        $('select[name="clientPerson"]').on('change', function() {
            var person = $(this).val();
            var personText = $('select[name="clientPerson"] option:selected').text();

            $.ajax({
                url: "{{route('dynamicPersonInvoice.fetch')}}",
                method: "get",
                data: {
                    person_id: person,

                },
                success: function(data) {

                    var result = $.parseJSON(data);

                    $('#client_name').val(personText);

                    $("#sale_name").val(result[1]);

                    $("#market_name").val(result[3]);
                    $('#orderPersons').html(result[5]).trigger('chosen:updated');



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

        $('select[name="orderPersons"]').on('change', function() {
            var order = $(this).val();
            var index = $('#table > tbody > tr').length;
            $.ajax({
                url: "{{route('dynamicOrderItemsInvoice.fetch')}}",
                method: "get",
                data: {
                    order_id: order,

                },
                success: function(result) {

                    $('#rows').html(result);
                    headCalculations(index);

                }
            });

        });

        //filter
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#table > tbody > tr").filter(function() {
                var row_num = $(this).attr('data-id');
                $(this).toggle(
                    $('#item_search' + row_num).text().toLowerCase().indexOf(value) > -1 ||
                    $('#batch_search' + row_num).text().toLowerCase().indexOf(value) > -1


                );
            });

        });


        //paytype






        retval = $('#pay_type_id ').val();
        $('select[name="pay_type_id"]').on('change', function(ev) {
            // var previous = currentV();

            var paytype = $(this).val();

            // var confirmc = confirm(' هذا التعديل سيقوم بمسح الاصناف بالكامل ');

            if (paytype == 1) {

                $("#clientPerson").prop('disabled', 'disabled');
                $('#client_name').val('');

                $("#salePerson").prop('disabled', false);
                $("#marketPerson").prop('disabled', false);
                $('#clientPerson').val('').trigger('chosen:updated');
                $('#salePerson').val('').trigger('chosen:updated');
                $('#marketPerson').val('').trigger('chosen:updated');

            } else {

                $('select[name="clientPerson"]').prop('disabled', false);
                $('#sale_name').val('');
                $('#market_name').val('');
                $("#salePerson").prop('disabled', true);
                $("#marketPerson").prop('disabled', true);
                $('#clientPerson').val('').trigger('chosen:updated');
                $('#salePerson').val('').trigger('chosen:updated');
                $('#marketPerson').val('').trigger('chosen:updated');

            }
            if (paytype == 1) {
                stocks();
                $('#optionsRadios1').prop('checked', true);
                $('#optionsRadios1').prop('disabled', true);
                $('#optionsRadios2').prop('disabled', true);
            } else {
                orders();
                $('#optionsRadios2').prop('checked', true);
                $('#optionsRadios2').prop('disabled', false);
                $('#optionsRadios1').prop('disabled', false);
            }

            if (paytype == 3 || paytype == 4) {

                stocks();
                $('#optionsRadios1').prop('checked', true);
                $('#optionsRadios1').prop('disabled', true);
                $('#optionsRadios2').prop('disabled', true);


            }

            // } else {
            //     $('#pay_type_id').trigger('chosen:updated');

            //     ev.preventDefault();
            //     return false;

            // }


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

        order = $('#orderPersons option:selected').val();
        stock = $('#stock_id option:selected').val();
        var pay = $('#pay_type_id option:selected').val();

        var rowSS = parseFloat(rowCount) + 1;


        $.ajax({
            type: 'GET',
            async: false,
            data: {
                rowcount: parseFloat(rowCount) + 1,
                order: order,
                stock: stock

            },
            url: "{{url('addInvoiceRow/fetch')}}",

            success: function(data) {

                $('#rows').append(data);
                $("#select" + rowSS).select2();
                $('#firstTT' + rowSS).focus();
                if (pay == 3) {
                    bonasDetails(rowSS);
                }
                if (pay == 4) {
                    adsDetails(rowSS);
                }
                console.log(rowSS);
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
    //Start row functions
    function deleteRow(index) {
        $('tr[data-id=' + index + ']').remove();

        headCalculations(index);

    }

    function editSelectVal(index) {
        debugger;

        var select_value = $('#select' + index + ' option:selected').val();
        var select_stock = $('#stock_id option:selected').val();
        order = $('#orderPersons option:selected').val();
        $.ajax({
            type: 'GET',
            data: {

                select_value: select_value,
                select_stock: select_stock,
                order: order

            },
            url: "{{route('editSelectValInvoice.fetch')}}",

            success: function(data) {
                var result = $.parseJSON(data);

                $("#ar_name" + index + "").text(result[0]);
                $("#uom" + index + "").text(result[1]);
                if (result[3] == null) {
                    $("#totalvat" + index + "").text(0);
                    $("#totalvat1" + index + "").val(0);

                } else {
                    $("#totalvat" + index + "").text(result[3]);
                    $("#totalvat1" + index + "").val(result[3]);

                }

                $("#selectBatch" + index + "").html(result[2]);
                $('#selectBatch' + index).select2();


            },
            error: function(request, status, error) {

                $("#uom" + index + "").text(' ');
                $("#ar_name" + index + "").text(' ');
                console.log(request.responseText);
            }
        });


    }
    /**@abstract */
    function editSelectBatch(index) {
        debugger;

        var select_value = $('#selectBatch' + index + ' option:selected').val();

        var person = $('#clientPerson option:selected').val();

        $.ajax({
            type: 'GET',
            data: {

                select_value: select_value,
                person: person

            },
            url: "{{route('editSelectBatchInvoice.fetch')}}",

            success: function(data) {
                var result = $.parseJSON(data);

                $("#batchNum" + index + "").text(result[0]);
                $("#batchDate" + index + "").text(result[1]);
                $("#batchqty" + index + "").text(result[2]);
                $("#itemprice" + index + "").val(result[3]);
                $("#qty" + index).attr('max', result[2]);

                // ("#batchNum1" + index + "").text(result[0]);
                $("#batchDate1" + index + "").text(result[1]);
                $("#batchqty1" + index + "").text(result[2]);
                $("#itemprice1" + index + "").val(result[3]);
                $("#per" + index + "").attr('value', result[4]);


            },
            error: function(request, status, error) {

                $("#batchNum" + index + "").text('');
                $("#batchDate" + index + "").text('');
                $("#batchqty" + index + "").text('');
                console.log(request.responseText);
            }
        });


    }
    //price
    function itemPrice(index) {

        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();
        var bons = $("#itemBonas" + index + "").val();
        var totalvat = $("#totalvat" + index + "").text();
        var ss = $("#qty" + index + "").val() + $("#itemBonas" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var totBon = (price * qty + price * bons) - disval;

        // if (bons > 0) {
        //     $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        // }
        $("#total" + index + "").text((price * qty).toFixed(2));
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount.toFixed(2));
        var disval = $("#disval" + index + "").val();
        $("#final" + index + "").text(((price * qty) - disval).toFixed(2));
        $('#totalcit' + index + "").text((parseFloat(totBon) * parseFloat(totalvat)).toFixed(2));
        $("#finalAll" + index + "").text((parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text())).toFixed(2));

        headCalculations(index);
        $("#itemprice" + index).attr('value', price);
    }
    //qty
    function itemQty(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();
        var bons = $("#itemBonas" + index + "").val();
        var totalvat = $("#totalvat" + index + "").text();
        var ss = $("#qty" + index + "").val() + $("#itemBonas" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var totBon = (price * qty + price * bons) - disval;
        // if (bons > 0) {
        //     $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        // }

        $("#total" + index + "").text((price * qty).toFixed(2));
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount.toFixed(2));
        var disval = $("#disval" + index + "").val();

        $("#final" + index + "").text(((price * qty) - disval).toFixed(2));
        $('#totalcit' + index + "").text((parseFloat(totBon) * parseFloat(totalvat)).toFixed(2));
        $("#finalAll" + index + "").text((parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text())).toFixed(2));

        headCalculations(index);


        $("#qty" + index).attr('value', qty);
    }

    function itemBons(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();

        var bons = $("#itemBonas" + index + "").val();
        var totalvat = $("#totalvat" + index + "").text();
        var ss = $("#qty" + index + "").val() + $("#itemBonas" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var totBon = (price * qty + price * bons) - disval;
        // if (bons > 0) {
        //     $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        // }
        $("#total" + index + "").text((price * qty).toFixed(2));
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount.toFixed(2));
        var disval = $("#disval" + index + "").val();

        $("#final" + index + "").text(((price * qty) - disval).toFixed(2));
        $('#totalcit' + index + "").text((parseFloat(totBon) * parseFloat(totalvat)).toFixed(2));
        $("#finalAll" + index + "").text((parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text())).toFixed(2));

        headCalculations(index);

        $("#itemBonas" + index).attr('value', bons);
    }
    //per
    function disPer(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();
        var bons = $("#itemBonas" + index + "").val();
        var totalvat = $("#totalvat" + index + "").text();
        var ss = $("#qty" + index + "").val() + $("#itemBonas" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var totBon = (price * qty + price * bons) - disval;

        // if (bons > 0) {
        //     $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        // }
        $("#total" + index + "").text((price * qty).toFixed(2));
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount.toFixed(2));
        var disval = $("#disval" + index + "").val();
        $("#final" + index + "").text(((price * qty) - disval).toFixed(2));
        $('#totalcit' + index + "").text((parseFloat(totBon) * parseFloat(totalvat)).toFixed(2));
        $("#finalAll" + index + "").text((parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text())).toFixed(2));

        headCalculations(index);
        $("#per" + index).attr('value', per.toFixed(3));
    }
    //dis val
    function disval(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var bons = $("#itemBonas" + index + "").val();
        var totalvat = $("#totalvat" + index + "").text();
        var ss = $("#qty" + index + "").val() + $("#itemBonas" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var totBon = (price * qty + price * bons) - disval;

        // if (bons > 0) {
        //     $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        // }
        $("#total" + index + "").text((price * qty).toFixed(2));
        var cc = disval / (price * qty);

        $("#per" + index).val(cc.toFixed(3));
        $("#final" + index + "").text(((price * qty) - disval).toFixed(2));
        $('#totalcit' + index + "").text((parseFloat(totBon) * parseFloat(totalvat)).toFixed(2));
        $("#finalAll" + index + "").text((parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text())).toFixed(2));

        headCalculations(index);
        $("#disval" + index).attr('value', disval.toFixed(2));

    }

   // headCalculations(index);
   function headCalculations(index) {
        index = $('#table > tbody > tr').length;
        var total = 0;
        var discount = 0;
        var final = 0;
        var totalcit = 0;
        var finalAll = 0
        var qty = 0


        $('#table > tbody > tr').each(function() {
            var row_num = $(this).attr('data-id');
            total += parseFloat($('#total' + row_num).text());

            discount += parseFloat($('#disval' + row_num).val());

            final += parseFloat($('#final' + row_num).text());
            totalcit += parseFloat($('#totalcit' + row_num).text());
            finalAll += parseFloat($('#finalAll' + row_num).text());
            qty += parseFloat($('#itemBonas' + row_num).val());


            --index;
        })

        $('#total_items_price').val(total.toFixed(2));
        $('#total_items_discount').val(discount.toFixed(2));
        $('#total_items_vat').val(totalcit.toFixed(2));
        $('#total_items_finalqty').val(qty.toFixed(2));
        $('#total_items_all').val(finalAll.toFixed(2));
        //new

    }

    // bonasDetails(index);
    function bonasDetails(rowSS) {

        // $('#itemprice' + rowSS).attr("readonly", true);
        $("#disval" + rowSS).attr("readonly", true);
        $("#per" + rowSS).attr("readonly", true);
        $("#qty" + rowSS).attr("readonly", true);


    }

    // adsDetails(index);
    function adsDetails(rowSS) {

        $('#itemBonas' + rowSS).attr("readonly", true);



    }

    function currentV() {

        var retval;
        retval = $('#pay_type_id ').val();
        return retval;
    }

    function maxQty(index) {

        var max = $("#qty" + index + "").attr('max');
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();
        var bons = $("#itemBonas" + index + "").val();
        var totalvat = $("#totalvat" + index + "").text();
        var ss = $("#qty" + index + "").val() + $("#itemBonas" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var totBon = (price * qty + price * bons) - disval;
        var sum = parseFloat(qty) + parseFloat(bons);
        if (sum > (parseInt(jQuery('#qty' + index).attr('max')))) {
            $('#myModal').modal('show');

            $("#qty" + index).val(0);
            $("#itemBonas" + index).val(0);

        } else {
            $("#qty" + index).val(qty);
            $("#itemBonas" + index).val(bons);

        }




        $("#total" + index + "").text((price * qty).toFixed(2));
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount.toFixed(2));
        var disval = $("#disval" + index + "").val();

        $("#final" + index + "").text(((price * qty) - disval).toFixed(2));
        $('#totalcit' + index + "").text((parseFloat(totBon) * parseFloat(totalvat)).toFixed(2));
        $("#finalAll" + index + "").text((parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text())).toFixed(2));

        headCalculations(index);
        $("#qty" + index).attr('value', qty);
    }

    // Delete DB row functions
    function DeleteInvoiceItem(id, index) {
        debugger;
        $("#del" + index).modal('hide');
        $('.modal-backdrop.fade.in').remove();
        $('.modal-open').css('overflow-y', 'scroll');
        $.ajax({
            type: 'GET',
            url: "{{url('/saleInvoice/Remove/Item')}}",
            data: {
                id: id,
                invoice_id: '{{$invObj->id ?? 0}}',
            },
            success: function(data) {

                headCalculations(index);
                location.reload(true);
            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        });
    }
</script>
@endsection