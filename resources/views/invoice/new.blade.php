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

    #allStock {
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
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{route('invoice.store')}}" id="formid" method="post">
                    @csrf
                    <div class="mg-b-23">
                        <div class="">

                            <a href="{{route('orders.index')}}" class="btn btn-primary waves-effect waves-light">إلغاء</a>

                            <button class="btn btn-primary waves-effect waves-light" type="submit">حــفـظ</button>

                        </div>
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
                                                            <input type="text" class="form-control" placeholder="">
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
                                                            <select data-placeholder="Choose a Country..." class="chosen-select" tabindex="-1">
                                                                <option value="">Select</option>
                                                                @foreach($currencies as $cur)
                                                                <option value="{{$cur->CURRENCY_ID}}">{{$cur->CURRENCY_NAME}}</option>
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
                                                            <input type="text" id="client_name" name="person_name" class="form-control" placeholder="">
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
                                                            <select data-placeholder="إختر العميل" name="clientPerson" id="clientPerson" class="chosen-select" tabindex="-1">
                                                                <option value="0">Select</option>
                                                                @foreach($persons as $person)
                                                                <option value="{{$person->PERSON_ID}}">{{$person->PERSON_NAME}} / {{$person->PERSON_CODE}}</option>
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
                                            <!-- checked test -->
                                            <div class="row" id="allStock">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" id="stock_name" class="form-control" placeholder="">
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
                                                            <select data-placeholder="إختر المخزن" id="stock_id" name="stock_id" class="chosen-select" tabindex="-1">
                                                                <option value="">Select</option>
                                                                @foreach($stocks as $stock)
                                                                <option value="{{$stock->STOCK_ID}}">{{$stock->STOCK_AR_NAME}} / {{$stock->STOCK_CODE}}</option>

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
                                            <div class="row" id="checkOrder">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                            <select data-placeholder="إختر أمر البيع" id="orderPersons" class="chosen-select" name="orderPersons" tabindex="-1">

                                                            </select>
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
                                                                <input type="text" name="notes" class="form-control" placeholder="">
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
                                                        <input type="text" id="total_items_price" name="total_items_price" readonly class="form-control" placeholder="إجمالي السعر">
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
                                                        <input type="text" id="total_items_vat" readonly class="form-control" placeholder="إجمالي الضريبة">
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
                                                        <input type="text" readonly id="total_items_discount" class="form-control" placeholder="إجمالي الخصم">
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
                                                        <input type="text" id="total_items_finalqty" name="" readonly class="form-control" placeholder="إجمالي الكمية">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>إجمالي الكمية</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="total_items_all" name="LOCAL_NET_INVOICE" readonly class="form-control" placeholder="صافي الفاتورة">
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
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                    <div class="bt-df-checkbox">
                                                        <input class="radio-checked" disabled type="radio" onclick="stocks()" value="option1" id="optionsRadios1" name="optionsRadios">
                                                        <label><b>عام</b></label>
                                                        <input class="" type="radio" value="option2" checked="" onclick="orders()" id="optionsRadios2" name="optionsRadios">
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
                                                        <input type="text" class="form-control" placeholder="">
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
                                                        <input type="date" name="invoice_date" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ الفاتورة</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <select data-placeholder="Choose a Country..." name="pay_type_id" class="chosen-select" tabindex="-1">
                                                            @foreach($paytypes as $type)
                                                            <option value="{{$type->PAY_TYPE_ID}}">{{$type->PAY_TYPE_AR_NAME}}</option>
                                                            @endforeach
                                                        </select> </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>طريقة الدفع</b></label>
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

                                <h3 style="text-align:right">الأصناف</h3>
                                <button id="add" onclick="addRow()" disabled type="button" class="btn btn-primary waves-effect waves-light">إضافة صنف</button>
								<table class="table-striped" id="puchasetable" data-locale="ar-SA" data-pagination="true" data-pagination-pre-text="السابق" data-pagination-next-text="التالي" data-show-export="false" data-minimum-count-columns="2" data-page-list="[10, 25, 50, 100, all]" data-sort-name="index" data-sort-order="desc" data-search="false" style="direction:rtl" data-toggle="table" data-show-columns="false" data-show-pagination-switch="false" data-show-refresh="false" data-key-events="true" data-resizable="true" data-cookie="true" data-toolbar="#toolbar" data-show-toggle="false" data-show-fullscreen="true" data-show-columns-toggle-all="true">
									<thead>
										<tr>
											<th data-field="state" data-checkbox="false"></th>
											<th data-field="index">#</th>
                               
                                            <th>كود البند</th>
                                            <th>إسم البند</th>
                                            <th> UOM</th>
                                            <th>الباتش</th>
                                            <th> رقم الباتش</th>
                                            <th>تاريخ الصلاحية</th>
                                            <th>الكمية الحالية</th>
                                            <!-- <th> قيمه البونص</th> -->
                                            <th> كميه الصنف</th>

                                            <th>سعر الصنف</th>
                                            <th> التكلفة</th>
                                            <th>نسبة الخصم</th>
                                            <th>قيمة الخصم</th>
                                            <th>السعر </th>
                                            <th>نسبة الضريبة</th>
                                            <th> الضريبة</th>
                                            <th>الصافى</th>
                                            <!-- <th>حذف</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="rows">

                                        @include('invoice.allwithStock')
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
        $("#add").prop('disabled', false);
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
        $("#add").prop('disabled', true);
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
        // stock items
        $('select[name="stock_id"]').on('change', function() {
            var person = $(this).val();
            var stockText = $('select[name="stock_id"] option:selected').text();

            $('#stock_name').val(stockText);

        });

        // orders items
        $('select[name="orderPersons"]').on('change', function() {
            var order = $(this).val();
            var index = $('#puchasetable > tbody > tr').length;

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
        index = $('#puchasetable > tbody > tr').length;
        var rowCount = $('#puchasetable > tbody > tr').length;
alert(index);
        order = $('#orderPersons option:selected').val();
        stock = $('#stock_id option:selected').val();
        var rows = [];
        $.ajax({
            type: 'GET',
            data: {
                rowCount: rowCount+1,
                order: order,
                stock: stock


            },
            url: "{{url('addInvoiceRow/fetch')}}",

            success: function(data) {
             
                $('#rows').append(data);
                $('#select' + rowCount).select2();


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
        var trs = $('#puchasetable > tbody').html();
        $('#puchasetable').bootstrapTable('destroy');
        $('#rows').html(trs);
        $('#puchasetable').bootstrapTable();
        console.log(trs);
        console.log(index);
        headCalculations(index);

    }

    function editSelectVal(index) {
        debugger;

        var select_value = $('#select' + index + ' option:selected').val();


        $.ajax({
            type: 'GET',
            data: {

                select_value: select_value

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

        if (bons > 0) {
            $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        }
        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();
        $("#final" + index + "").text((price * qty) - disval);
        $("#finalAll" + index + "").text(parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text()));
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
        if (bons > 0) {
            $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        }

        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();

        $("#final" + index + "").text((price * qty) - disval);
        $("#finalAll" + index + "").text(parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text()));

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
        if (bons > 0) {
            $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        }
        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();

        $("#final" + index + "").text((price * qty) - disval);
        $("#finalAll" + index + "").text(parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text()));

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

        if (bons > 0) {
            $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        }
        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();
        $("#final" + index + "").text((price * qty) - disval);
        $("#finalAll" + index + "").text(parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text()));

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

        if (bons > 0) {
            $("#totalcit" + index + "").text((totBon.toFixed(2) * totalvat).toFixed(2));
        }
        $("#total" + index + "").text(price * qty);
        var cc = disval / (price * qty);

        $("#per" + index).val(cc);
        $("#final" + index + "").text((price * qty) - disval);
        $("#finalAll" + index + "").text(parseFloat($("#final" + index + "").text()) + parseFloat($("#totalcit" + index + "").text()));

        headCalculations(index);
        $("#disval" + index).attr('value', disval);

    }

    // headCalculations(index);
    function headCalculations(index) {
        index = $('#puchasetable > tbody > tr').length;
        var total = 0;
        var discount = 0;
        var final = 0;
        var totalcit = 0;
        var finalAll = 0
        var qty = 0

        $('#puchasetable > tbody  > tr').each(function() {



            total += parseFloat($('#total' + index).text());

            discount += parseFloat($('#disval' + index).val());

            final += parseFloat($('#final' + index).text());
            totalcit += parseFloat($('#totalcit' + index).text());
            finalAll += parseFloat($('#finalAll' + index).text());
            qty += parseFloat($('#qty' + index).val());

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
    totalvat
		$('#totalvat1').val( parseFloat($('#totalvat' + index).text()));
		$('#totalcit1').val( parseFloat($('#totalcit' + index).text()));
    }
</script>
@endsection