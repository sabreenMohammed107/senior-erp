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
                <form action="{{route('purch-invoice.store')}}" id="formid" method="post">
                    @csrf
                    <div class="mg-b-23">
                        <button data-toggle="modal" data-target="#cancle" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">رجوع</button>
                        <button data-toggle="modal" data-target="#confi" type="button" class="btn btn-primary waves-effect waves-light mg-b-15"> تأكيد</button>

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
                                                                <input type="text" class="form-control" placeholder="" readonly>
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
                                                                <input type="text" name="invoice_serial" class="form-control" placeholder="">
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
                                                                <input type="date" name="invoice_date" class="form-control" placeholder="">
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
                                                                <select data-placeholder="Choose a Country..." class="chosen-select">
                                                                    @foreach($currencies as $cur)
                                                                    <option value="{{$cur->id}}">{{$cur->name}} /{{$cur->conversion_rate}}</option>
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
                                                                <select data-placeholder="Choose a Country..." id="person_id" name="person_id" class="chosen-select">
                                                                    @foreach($persons as $person)
                                                                    <option value="{{$person->id}}">{{$person->name}} / {{$person->code}}</option>
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
                                                                <input class="radio-checked" type="radio" onclick="stock()" value="option1" id="optionsRadios1" name="optionsRadios1">
                                                                <label><b> عام </b></label>
                                                                <input class="" type="radio" value="option2" checked="" onclick="orders()" id="optionsRadios2" name="optionsRadios1">
                                                                <label><b> أمر مشتريات </b></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                            <div class="input-mask-title">
                                                                <label><b>مرجع المشتريات</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="stock">
                                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <select data-placeholder="إختر المخزن" id="stock_id" name="stock_id" class="chosen-select" tabindex="-1">
                                                                    <option value="">Select</option>
                                                                    @foreach($stocks as $stock)
                                                                    <option value="{{$stock->id}}">{{$stock->ar_name}} / {{$stock->code}}</option>

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
                                                    <div class="row" id="order">
                                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <select data-placeholder="إختر المخزن" id="transaction_id" name="transaction_id" class="chosen-select" tabindex="-1">
                                                                    <option value="">Select</option>
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
                                                                <textarea class="form-control" name="notes" placeholder=""></textarea>
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
                                                                <input type="text" id="total_items_price" name="total_items_price" class="form-control" placeholder="" readonly>
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
                                                                <input type="text" id="total_total" name="loca_total" class="form-control" placeholder="" readonly>
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
                                                                <input type="text" id="total_items_all" name="local_net_invoice" class="form-control" placeholder="" readonly>
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
                                                    <button class="btn_add_item">إضافة بند</button>
                                                    <table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-toolbar="#toolbar" style="direction:rtl;">
                                                        <thead>
                                                            <tr>
                                                                <th data-field="state"></th>
                                                                <th>البند المضاف</th>
                                                                <th>قيمة البند المضتف</th>
                                                                <th>حذف</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @include('purch-invoice.local')

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
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
                                                        <th>إسم البند</th>
                                                        <th> UOM</th>
                                                        <th>الباتش</th>
                                                        <th> رقم الباتش</th>
                                                        <th>تاريخ الصلاحية</th>
                                                        <th> كميه الصنف</th>
                                                        <th>سعر الصنف</th>
                                                        <th> التكلفة</th>
                                                        <th>ملاحظات</th>
                                                        <th>حذف</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="rows">

                                                    @include('purch-invoice.allwithStock')
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </form>
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
        //paytype






        


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
        var trs = $('#table > tbody').html();
        $('#table').bootstrapTable('destroy');
        $('#rows').html(trs);
        $('#table').bootstrapTable();
        console.log(trs);
        console.log(index);
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
                $("#totalvat" + index + "").text(result[3]);
                $("#totalvat1" + index + "").text(result[3]);

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

                ("#batchNum1" + index + "").text(result[0]);
                $("#batchDate1" + index + "").text(result[1]);
                $("#batchqty1" + index + "").text(result[2]);
                $("#itemprice1" + index + "").val(result[3]);


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
        var bons = $("#bonas" + index + "").val();
        var totalvat = $("#totalvat" + index + "").text();
        var ss = $("#qty" + index + "").val() + $("#bonas" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var totBon = (price * qty + price * bons) - disval;

        // if (bons > 0) {
        //     $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        // }
        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();
        $("#final" + index + "").text((price * qty) - disval);
        $("#finalAll" + index + "").text(parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text()));
        $('#totalcit' + index + "").text(parseFloat($("#final" + index + "").text()) * parseFloat($("#totalvat" + index + "").text()));

        headCalculations(index);
        $("#itemprice" + index).attr('value', price);
    }
    //qty
    function itemQty(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();
        var bons = $("#bonas" + index + "").val();
        var totalvat = $("#totalvat" + index + "").text();
        var ss = $("#qty" + index + "").val() + $("#bonas" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var totBon = (price * qty + price * bons) - disval;
        // if (bons > 0) {
        //     $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        // }

        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();

        $("#final" + index + "").text((price * qty) - disval);
        $("#finalAll" + index + "").text(parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text()));
        $('#totalcit' + index + "").text(parseFloat($("#final" + index + "").text()) * parseFloat($("#totalvat" + index + "").text()));

        headCalculations(index);


        $("#qty" + index).attr('value', qty);
    }

    function itemBons(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();

        var bons = $("#bonas" + index + "").val();
        var totalvat = $("#totalvat" + index + "").text();
        var ss = $("#qty" + index + "").val() + $("#bonas" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var totBon = (price * qty + price * bons) - disval;
        // if (bons > 0) {
        //     $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        // }
        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();

        $("#final" + index + "").text((price * qty) - disval);
        $("#finalAll" + index + "").text(parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text()));
        $('#totalcit' + index + "").text(parseFloat($("#final" + index + "").text()) * parseFloat($("#totalvat" + index + "").text()));

        headCalculations(index);

        $("#bonas" + index).attr('value', bons);
    }
    //per
    function disPer(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();
        var bons = $("#bonas" + index + "").val();
        var totalvat = $("#totalvat" + index + "").text();
        var ss = $("#qty" + index + "").val() + $("#bonas" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var totBon = (price * qty + price * bons) - disval;

        // if (bons > 0) {
        //     $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        // }
        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();
        $("#final" + index + "").text((price * qty) - disval);
        $("#finalAll" + index + "").text(parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text()));
        $('#totalcit' + index + "").text(parseFloat($("#final" + index + "").text()) * parseFloat($("#totalvat" + index + "").text()));

        headCalculations(index);
        $("#per" + index).attr('value', per);
    }
    //dis val
    function disval(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var bons = $("#bonas" + index + "").val();
        var totalvat = $("#totalvat" + index + "").text();
        var ss = $("#qty" + index + "").val() + $("#bonas" + index + "").val();
        var disval = $("#disval" + index + "").val();
        var totBon = (price * qty + price * bons) - disval;

        // if (bons > 0) {
        //     $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        // }
        $("#total" + index + "").text(price * qty);
        var cc = disval / (price * qty);

        $("#per" + index).val(cc);
        $("#final" + index + "").text((price * qty) - disval);
        $("#finalAll" + index + "").text(parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text()));
        $('#totalcit' + index + "").text(parseFloat($("#final" + index + "").text()) * parseFloat($("#totalvat" + index + "").text()));
        headCalculations(index);
        $("#disval" + index).attr('value', disval);

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

        $('#table > tbody  > tr').each(function() {



            total += parseFloat($('#total' + index).text());

            discount += parseFloat($('#disval' + index).val());

            final += parseFloat($('#final' + index).text());
            totalcit += parseFloat($('#totalcit' + index).text());
            finalAll += parseFloat($('#finalAll' + index).text());
            qty += parseFloat($('#itemBonas' + index).val());

            --index;
            console.log(total);
            console.log(discount);


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

        $('#itemprice' + rowSS).attr("readonly", true);
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
        // alert(retval);
        return retval;
    }

    function maxQty(index) {
        var max = $("#qty" + index + "").attr('max');
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var bonas = $("#itemBonas" + index + "").val();
        var per = $("#per" + index + "").val();
        var sum = parseFloat(qty) + parseFloat(bonas);

        if (sum > max) {

            $('#myModal').modal('show');
            // alert("هذه الكميه اكبر من اعلى قيمه مجوده فى المخزن سوف يتم ارجاعك لاعلى كميه موجوده ");
            // alert(qty);

            $("#qty" + index).val(1);
            $("#itemBonas" + index).val(1);
        } else {
            $("#qty" + index).val(qty);
            $("#itemBonas" + index).val(bonas);
        }



        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();

        $("#final" + index + "").text((price * qty) - disval);

        headCalculations(index);
        $("#qty" + index).attr('value', qty);
    }
</script>
@endsection