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
                <span class="bread-blod"> أوامر المبيعات </span>
            </li>
        </ul>
    </div>
</div>


@endsection

@section('content')
<!-- Static Table Start -->
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
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{route('sales-order.update',$orderObj->id)}}" id="form-id" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mg-b-23">
                        <button data-toggle="modal" data-target="#cancle" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">رجوع</button>

                        <button data-toggle="modal" data-target="#save" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">حـفـــــظ</button>

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

                                        <button class="btn btn-primary waves-effect waves-light" onclick="document.getElementById('form-id').submit();">حفظ</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/save Company-->

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

                                        <a class="btn btn-primary waves-effect waves-light" href="{{route('sales-order.index')}}">رجــــــوع</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/cancle Company-->
                    </div>
                    <input type="hidden" value="{{$branch->id ?? 0}}" name="branch" class="form-control" placeholder="">

                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 style="direction:rtl">تعديل أصناف أمر البيع</h1><br />
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright" style="direction:rtl">
                                <div class="form-group-inner" style="margin-right:10px;">
                                    <div class="row res-rtl" style="display: flex ">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 shadow">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" name="purch_order_no" value="{{$orderObj->purch_order_no}}" readonly class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>رقم أمر البيع</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <?php
                                                        $date = date_create($orderObj->order_date);
                                                        ?>
                                                        <input type="date" id="order_date" value="{{ date_format($date, 'Y-m-d')}}" name="order_date" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ أمر البيع</b></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" readonly class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>حالة أمرالبيع</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" class="form-control" readonly placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>قرار أمرالبيع</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" class="form-control" value="{{$orderObj->notes}}" name="notes" id="notes" placeholder="" style="height:80px;margin-bottom:10px;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>ملاحظات</b></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 shadow">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <?php
                                                        $date = date_create($orderObj->received_date_suggested);
                                                        ?>
                                                        <input type="date" id="order_delev" value="{{ date_format($date, 'Y-m-d')}}" name="received_date_suggested" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ الإستلام</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="decOrder" value="{{$orderObj->order_description}}" name="order_description" class="form-control" placeholder="" style="height:80px;margin-bottom:10px;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>وصف أمر البيع</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="total_items_price" value="{{$orderObj->order_value}}" name="order_value" readonly class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>قيمة أمرالبيع</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="number" id="total_items_discount" value="{{$orderObj->total_disc_value}}" name="total_disc_value" readonly class="form-control" placeholder="">
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
                                                        <input type="number" id="total_items_final" value="{{$orderObj->total_final_cost}}" name="total_final_cost" readonly class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>صافي القيمة</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 shadow">
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" value="{{$branch->ar_name ?? ''}}" readonly class="form-control" placeholder=" ">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>إسم الفرع </b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <input type="text" readonly value="{{$branch->code ?? ''}}" class="form-control" placeholder=" ">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                                                            <div class="input-mask-title">
                                                                <label><b> كود الفرع </b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" readonly value="{{$MarktCode->ar_name ?? ''}}" id="marketMan" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>مسئول التسويق</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <input type="text" value="{{$MarktCode->code ?? ''}}" id="marketCode" readonly class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                                                            <div class="input-mask-title">
                                                                <label><b>كود التسويق</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" readonly value="{{$saleCode->ar_name ?? ''}}" id="saleMan" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>مسئول المبيعات</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <input type="text" id="saleCode" value="{{$saleCode->code ?? ''}}" readonly class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                                                            <div class="input-mask-title">
                                                                <label><b>كود المبيعات</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" id="stock_name" value="{{$stocks[0]->ar_name ?? ''}}" readonly class="form-control" placeholder=" ">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>إسم المخزن</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">

                                                            <div class="input-mark-inner mg-b-22">
                                                                <select id="stock_id" name="stock_id" data-placeholder="Choose a Country..." class="chosen-select">
                                                                    @foreach($stocks as $stock)
                                                                    <option @if ($orderObj->stock_id == $stock->id)
                                                                        selected="selected"
                                                                        @endif value="{{$stock->id}}">{{$stock->ar_name}} / {{$stock->code}}</option>

                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" id="output" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                                                            <div class="input-mask-title">
                                                                <label><b>كود المخزن</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" id="person_name" value="{{$persons[0]->name ?? ''}}" name="person_name" readonly class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>إسم العميل</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <select id="person_id" name="person_id" data-placeholder="Choose a Country..." class="chosen-select">
                                                                    @foreach($persons as $person)
                                                                    <option @if ($orderObj->person_id == $person->id)
                                                                        selected="selected"
                                                                        @endif
                                                                        value="{{$person->id}}">{{$person->name}} / {{$person->code}}</option>
                                                                    @endforeach

                                                                </select> </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                                                            <div class="input-mask-title">
                                                                <label><b>كود العميل</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" readonly class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>سعر التحويل</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <select data-placeholder="Choose a Country..." name="currency_id" class="chosen-select">
                                                                    <option value="">Select</option>
                                                                    @foreach($currencies as $cur)
                                                                    <option @if ($orderObj->currency_id == $cur->id)
                                                                        selected="selected"
                                                                        @endif value="{{$cur->id}}">{{$cur->name}}</option>
                                                                    @endforeach
                                                                </select> </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                                                            <div class="input-mask-title">
                                                                <label><b>كود العملة</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                    </div>
                                </div>
                                <div class="row res-rtl" style="display: flex ">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow">
                                        <h3 style="text-align:right">الأصناف</h3>
                                        <button id="add" type="button" class="btn btn-primary waves-effect waves-light mg-b-15" style="float: left;">إضافة صنف</button>
                                        <input type="text" id="myInput" placeholder="إبحث  الصنف ..">
                                    </div>
                                </div>
                                <div style="overflow-x:auto;">


                                    <table class="table  table-bordered" id="table" style="direction:rtl;">
                                        <thead>
                                            <tr>
                                                <th data-field="index">#</th>
                                                <th>كود البند</th>
                                                <th>UOM</th>
                                                <th>إسم البند</th>
                                                <th>الباتش</th>
                                                <th> رقم الباتش</th>
                                                <th>تاريخ الصلاحية</th>
                                                <th>الكمية الحالية</th>
                                                <th>كمية الصنف</th>
                                                <th>سعر الصنف</th>
                                                <th>الإجمالي</th>
                                                <th>نسبة الخصم</th>
                                                <th>قيمة الخصم</th>
                                                <th>السعر النهائي</th>
                                                <th>ملاحظات</th>
                                                <th>حذف</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rows">
                                            @include('sales-order.ajaxEdit')
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                </form>
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
    $(function() {
        debugger;


        $('#add').on('click', function() {
            var rowCount = 0;

            if ($('#table > tbody  > tr').attr('data-id')) {
                rowCount = $('#table > tbody  > tr:last').attr('data-id');
            }

            order = $('#orderPersons option:selected').val();
            stock = $('#stock_id option:selected').val();
            var rowSS = parseFloat(rowCount) + 1;


            $.ajax({
                type: 'GET',
                async: false,
                data: {
                    rowcount: parseFloat(rowCount) + 1,
                    order: order,
                    stock: stock

                },
                url: "{{url('addRow-saleOrder/fetch')}}",

                success: function(data) {

                    $('#rows').append(data);
                    $("#select" + rowSS).select2();
                    $('#firstTT' + rowSS).focus();
                    console.log(rowSS);
                },

                error: function(request, status, error) {
                    console.log(request.responseText);
                }
            });


        })

        //filter
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#table > tbody > tr").filter(function() {
                var row_num = $(this).attr('data-id');
                $(this).toggle(
                    $('#item_search' + row_num).text().toLowerCase().indexOf(value) > -1 ||
                    $('#batch_search' + row_num).text().toLowerCase().indexOf(value) > -1 ||
                    $('#total' + row_num).text().toLowerCase().indexOf(value) > -1 ||
                    $('#final' + row_num).text().toLowerCase().indexOf(value) > -1 ||
                    $('#upselect' + row_num).val().toLowerCase().indexOf(value) > -1 ||
                    $('#upselectBatch' + row_num).val().toLowerCase().indexOf(value) > -1

                );
            });

        });

    })
    $('select[name="person_id"]').on('change', function() {

        var select_value = $(this).val();

        $.ajax({
            type: 'GET',
            data: {

                select_value: select_value

            },
            url: "{{route('editSelectValPerson.fetch')}}",

            success: function(data) {
                var result = $.parseJSON(data);

                $("#saleCode").val(result[0]);
                $("#saleMan").val(result[1]);
                $("#marketCode").val(result[2]);
                $("#marketMan").val(result[3]);
                $("#person_name").val($('#person_id option:selected').text());

            },
            error: function(request, status, error) {

                $("#saleCode").val('');
                $("#saleMan").val('');
                $("#marketCode").val('');
                $("#marketMan").val('');
                $("#person_name").val($('#person_id option:selected').text());

            }
        });


    });



    $('select[name="stock_id"]').on('change', function() {

        index = $('#table > tbody > tr').length;

        if (index > 1) {

            $('#rows').html('');
        }
        $("#stock_name").val($('#stock_id option:selected').text());


    });
    $('#form-id').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    function addRow(url) {
        var rowCount = 0;

        if ($('#table > tbody > tr').attr('data-id')) {
            rowCount = $('#table > tbody > tr:last').attr('data-id');
        }

        // var rowCount = $('#table > tbody > tr').length;
        var rowSS = parseFloat(rowCount) + 1;
        order = $('#orderPersons option:selected').val();
        stock = $('#stock_id option:selected').val();

        $.ajax({
            type: 'GET',
            async: false,
            data: {
                rowcount: parseFloat(rowCount) + 1,
                order: order,
                stock: stock

            },
            url: "{{url('addRow-saleOrder/fetch')}}",

            success: function(data) {

                $('#rows').append(data);
                $("#select" + rowSS).select2();
                $('#firstTT' + rowSS).focus();
                console.log(rowSS);
            },

            error: function(request, status, error) {
                console.log(request.responseText);
            }
        });
    }

    function enterForRow(e, index) {
        if (e.keyCode == 13) {
            addRow();

        }
    }


    function deleteRow(index) {
        //delete Row

        $('tr[data-id=' + index + ']').remove();

        headCalculations(index);
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
            url: "{{route('editSelectVal.fetch')}}",

            success: function(data) {
                var result = $.parseJSON(data);

                $("#ar_name" + index + "").text(result[0]);
                $("#uom" + index + "").text(result[1]);
                $("#selectBatch" + index + "").html(result[2]);
                $('#selectBatch' + index).select2();
                $("#batchNum" + index + "").text('');
                $("#batchDate" + index + "").text('');
                $("#batchqty" + index + "").text('');
                $("#itemprice" + index + "").attr('value', 0);
                $("#disval" + index + "").attr('value',0);
                headCalculations(index);

            },
            error: function(request, status, error) {

                $("#uom" + index + "").text(' ');
                $("#ar_name" + index + "").text(' ');
                console.log(request.responseText);
            }
        });
        $('#item_search' + index).text(text);

    }


    function editSelectBatch(index) {
        debugger;

        var select_value = $('#selectBatch' + index + ' option:selected').val();

        var text = $('#selectBatch' + index + ' option:selected').text();

        var person = $('#person_id option:selected').val();
        $.ajax({
            type: 'GET',
            data: {

                select_value: select_value,
                person: person

            },
            url: "{{route('editSelectBatch.fetch')}}",

            success: function(data) {
                var result = $.parseJSON(data);
                $("#batchNum" + index + "").text(result[0]);
                $("#batchDate" + index + "").text(result[1]);
                $("#batchqty" + index + "").text(result[2]);

                $("#qty" + index).attr('max', result[2]);
alert(result[3]);
                $("#itemprice" + index + "").attr('value', result[3]);
                $("#disval" + index + "").attr('value', result[4]);

                headCalculations(index);


            },
            error: function(request, status, error) {

                $("#batchNum" + index + "").text('');
                $("#batchDate" + index + "").text('');
                $("#batchqty" + index + "").text('');
                console.log(request.responseText);
            }
        });
        $('#batch_search' + index).text(text);


    }

    function itemPrice(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();

        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();
        $("#final" + index + "").text((price * qty) - disval);
        headCalculations(index);
        $("#itemprice" + index).attr('value', price);
    }

    function disPer(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();

        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();
        $("#final" + index + "").text((price * qty) - disval);
        headCalculations(index);
        $("#per" + index).attr('value', per);
    }

    function disval(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var disval = $("#disval" + index + "").val();

        $("#total" + index + "").text(price * qty);
        var cc = disval / (price * qty);

        $("#per" + index).val(cc);
        $("#final" + index + "").text((price * qty) - disval);
        headCalculations(index);
        $("#disval" + index).attr('value', disval);

    }

    function itemQty(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();

        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();

        $("#final" + index + "").text((price * qty) - disval);
        headCalculations(index);
        $("#qty" + index).attr('value', qty);




    }

    function maxQty(index) {

        var max = $("#qty" + index + "").attr('max');
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();
        if (qty > max) {
            $('#myModal').modal('show');
            // alert("هذه الكميه اكبر من اعلى قيمه مجوده فى المخزن سوف يتم ارجاعك لاعلى كميه موجوده ");
            // alert(qty);

            $("#qty" + index).val(max);
        } else {
            $("#qty" + index).val(qty);
        }



        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();

        $("#final" + index + "").text((price * qty) - disval);

        headCalculations(index);
        $("#qty" + index).attr('value', qty);
    }


    // headCalculations(index);
    function headCalculations(index) {
        index = $('#table > tbody > tr').length;
        var total = 0;
        var discount = 0;
        var final = 0;


        $('#table > tbody > tr').each(function() {
            var row_num = $(this).attr('data-id');
            total += parseFloat($('#total' + row_num).text());
            discount += parseFloat($('#disval' + row_num).val());
            final += parseFloat($('#final' + row_num).text());

            --index;
        })
        console.log(total);
        console.log(discount);
        $('#total_items_price').val(total.toFixed(2));
        $('#total_items_discount').val(discount.toFixed(2));
        $('#total_items_final').val(final.toFixed(2));


    }

    // Delete DB row functions
    function DeleteOrderItem(id, index) {
        debugger;
        $("#del" + index).modal('hide');
        $('.modal-backdrop.fade.in').remove();
        $('.modal-open').css('overflow-y', 'scroll');
        $.ajax({
            type: 'GET',
            url: "{{url('/saleOrder/Remove/Item')}}",
            data: {
                id: id,
                order_id: '{{$orderObj->id ?? 0}}',
            },
            success: function(data) {

                headCalculations(index);
                location.reload(true);
            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        });
        // headCalculations();
    }
</script>
@endsection