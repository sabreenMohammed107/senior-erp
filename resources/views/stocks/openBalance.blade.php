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



@section('content')
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <form id="formid" action="{{route('store-open-balance')}}" method="POST">
            @csrf
            <a href="{{route('stocks.index')}}" class="btn btn-primary waves-effect waves-light mg-b-15">إلغاء</a>
            <button class="btn btn-primary waves-effect waves-light mg-b-15" @if($confirmed==1) disabled @endif type="submit" name="action" value="save">حفظ</button>
            <button class="btn btn-primary waves-effect waves-light mg-b-15" @if($confirmed==1) disabled @endif type="submit" name="action" value="confirm"> الموافقة</button>

            <input type="hidden" name="primary_stock_id" value="{{$row->id}}">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 style="direction:rtl">الرصيد الإفتتاحي</h1><br />
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="form-group-inner" style="margin-right:10px;">

                                    <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                            <h4 style="text-align:right"> بيانات المخزن <i class="fa fa-home"></i></h4>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" readonly value="{{$row->code}}" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>الكود </b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" readonly value="{{$row->ar_name}}" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>الاسم عربى</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" readonly value="{{$row->en_name}}" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>الاسم بالانجليزى </b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <?php
                                                        $datez = new DateTime();
                                                        ?>

                                                        <input type="date" name="transaction_date" value="{{date_format($datez,"Y-m-d") }}" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ الرصيد الافتتاحى </b></label>
                                                    </div>
                                                </div>
                                            </div>
    
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                            <h4 style="text-align:right"> العمليات <i class="fa fa-calculator"></i></h4>

                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <select id="person_id" name="person_id" data-placeholder="Choose a Country..." class="chosen-select">
                                                            <option value="">Select</option>
                                                            @foreach($persons as $person)
                                                            <option value="{{$person->id}}">{{$person->code}} / {{$person->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b> الشخص</b></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="total_items_price" readonly class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>إجمالي</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <textarea class="form-control" name="transNote" placeholder="">{{$stockTran->notes ?? ''}}</textarea>
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

                                <h3 style="text-align:right">الأصناف</h3>
                                <button id="add" onclick="addRow()" @if($confirmed==1) disabled @endif type="button" class="btn btn-primary waves-effect waves-light">إضافة صنف</button>
                                <table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="false" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" style="direction:rtl;">
                                    <thead>
                                        <tr>
                                            <th data-field="state"></th>
                                            <th>Serial</th>
                                            <th data-field="id">كود البند</th>
                                            <th>إسم البند</th>
                                            <th>UOM</th>
                                            <th data-field="batchDate">تاريخ الصلاحية</th>
                                            <th data-field="batch">الباتش</th>
                                            <th>كمية الصنف</th>
                                            <th>سعر الصنف</th>
                                            <th>إجمالي السعر</th>
                                            <th>ملاحظات</th>
                                            <th>حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rows">
                                        @include('stocks.ajaxEdit')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Static Table End -->
@endsection
@section('scripts')
<script>
    $(function() {
        debugger;
        $('#table').bootstrapTable();
        var focus = $('#table > tbody  > tr').length;

        $('.no-records-found').remove();
    })

    var table = $('#table')

    function addRow() {
        var rowCount = $('#table > tbody > tr').length;
        var rowSS = rowCount + 1;
        var rows = [];
        person_id = $('#person_id option:selected').val();
        $.ajax({
            type: 'GET',
            data: {
                rowcount: rowCount + 1,
                id: '{{$row->id}}',
                person_id: person_id,
            },
            url: "{{url('addRow/fetch')}}",

            success: function(data) {
                rows.push(data);
                var trs = $('#table > tbody').html();
                $('#table').bootstrapTable('destroy');
                $('.no-records-found').remove();
                $('#rows').html(trs);
                console.log(trs);
                $('#rows').append(data);
                $('#table').bootstrapTable();
                $('#select' + rowSS).select2();

            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        });
    }

    //not submit in enter
    $('#formid').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    function enterForRow(e, index) {
        if (e.keyCode == 13) {
            addRow();

        }
    }

    function editSelectVal(index) {
        debugger;

        var select_value = $('#select' + index + ' option:selected').val();

        $.ajax({
            type: 'GET',
            data: {

                select_value: select_value

            },
            url: "{{route('editSelectVal.fetch')}}",

            success: function(data) {
                var result = $.parseJSON(data);

                $("#ar_name" + index + "").text(result[0]);
                $("#uom" + index + "").text(result[1]);


            },
            error: function(request, status, error) {

                $("#uom" + index + "").text(' ');
                $("#ar_name" + index + "").text('');
                console.log(request.responseText);
            }
        });


    }

    function deleteRow(index) {


        $('tr[data-id=' + index + ']').remove();
        // recountRows();
        var trs = $('#table > tbody').html();
        console.log(trs);
        $('#table').bootstrapTable('destroy');
        $('#rows').html(trs);
        $('#table').bootstrapTable();
        headCalculations(index);
    }

    function recountRows() {
        $('.no-records-found').remove();
        index = $('#table > tbody > tr').length;
        var rowCount = 0;
        console.log(index);
        $('#table > tbody  > tr').each(function() {
            rowCount = rowCount + 1;

            $('tr').attr('data-id', rowCount);
            $('td').attr('id', 'fTd' + rowCount);


            console.log($('#table > tbody').html());
            --index;
        })

    }
    // headCalculations(index);
    function headCalculations(index) {
        $('.no-records-found').remove();
        index = $('#table > tbody > tr').length;
        var total = 0;
        console.log(index);
        $('#table > tbody  > tr').each(function() {

            total += parseFloat($('#total' + index).text());


            --index;
        })
        console.log(total);
        $('#total_items_price').val(total.toFixed(2));

    }
    //--------------------
    // headCalculations(index);
    function headCalculationsDel(index) {
        $('.no-records-found').remove();
        index = $('#table > tbody > tr').length;
        var total = 0;
        console.log(index);
        $('#table > tbody  > tr').each(function() {

            total += parseFloat($('.total_item').text());

            --index;
        })
        console.log(total);
        $('#total_items_price').val(total.toFixed(2));

    }
    //--------------------
    //item qty
    function itemQty(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();

        $("#total" + index + "").text(price * qty);

        headCalculations(index);


        $("#qty" + index).attr('value', qty);
    }
    //--------------------
    //item price
    function itemPrice(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        $("#total" + index + "").text(price * qty);
        headCalculations(index);
        $("#itemprice" + index).attr('value', price);
    }
    //--------------------


    //item itemNotes
    function itemNotes(index) {
        var note = $.trim($("#notes" + index + "").val());

        $("#notes" + index).attr('value', note);
    }
    //--------------------


    //item batchItem
    function batchItem(index) {
        var batch = $("#batchNum" + index + "").val();

        $("#batchNum" + index).attr('value', batch);
    }
    //--------------------

    //item batchDate
    function batchDate(index) {
        var batchd = $("#batchDate" + index + "").val();

        $("#batchDate" + index).attr('value', batchd);
    }
    //--------------------
</script>
@endsection