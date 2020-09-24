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
            <input type="hidden" name="transUpdate" value="{{$stockTran->id ?? 0}}" >
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
                                                        <input type="text" id="total_items_price" name="total_items_price" value="{{$stockTran->total_items_price ?? 0}}" readonly class="form-control" placeholder="">
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
                                <style>
                                    #myInput {
                                        background-image: url('/css/searchicon.png');
                                        /* Add a search icon to input */
                                        background-position: 10px 12px;
                                        /* Position the search icon */
                                        background-repeat: no-repeat;
                                        /* Do not repeat the icon image */
                                        width: 30%;
                                        /* Full-width */
                                        font-size: 16px;
                                        /* Increase font-size */
                                        padding: 12px 20px 12px 40px;
                                        /* Add some padding */
                                        border: 1px solid #ddd;
                                        /* Add a grey border */
                                        margin-bottom: 12px;
                                        /* Add some space below the input */
                                    }
                                </style>

                                <h3 style="text-align:right">الأصناف</h3>
                                <button id="add" @if($confirmed==1) disabled @endif type="button" class="btn btn-primary waves-effect waves-light mg-b-15">إضافة صنف</button>

                                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..">

                                <table class="table" id="table" style="direction:rtl;">
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
     

        $('#add').on('click', function() {
            var rowCount = 0;

            if ($('#table > tbody  > tr').attr('data-id')) {
                rowCount = $('#table > tbody  > tr:last').attr('data-id');
            }

            // var rowCount = $('#table > tbody > tr').length;
            var rowSS = parseFloat(rowCount) + 1;

            person_id = $('#person_id option:selected').val();
            $.ajax({
                type: 'GET',
                async: false,
                data: {
                    rowcount: parseFloat(rowCount) + 1,
                    id: '{{$row->id}}',
                    person_id: person_id,

                },
                url: "{{url('addRow/fetch')}}",

                success: function(data) {

                    $('#rows').append(data);

                    $('#select' + rowSS).select2();
                    $('#firstTT' + rowSS).focus();
                },

                error: function(request, status, error) {
                    console.log(request.responseText);
                }
            });
            debugger;

        })

    })

//adding row
    function addRow() {
        var rowCount = 0;

        if ($('#table > tbody  > tr').attr('data-id')) {
            rowCount = $('#table > tbody  > tr:last').attr('data-id');
        }

        // var rowCount = $('#table > tbody > tr').length;
        var rowSS = parseFloat(rowCount) + 1;

        person_id = $('#person_id option:selected').val();
        $.ajax({
            type: 'GET',
            async: false,
            data: {
                rowcount: parseFloat(rowCount) + 1,
                id: '{{$row->id}}',
                person_id: person_id,

            },
            url: "{{url('addRow/fetch')}}",

            success: function(data) {

                $('#rows').append(data);

                $('#select' + rowSS).select2();
                $('#firstTT' + rowSS).focus();
            },

            error: function(request, status, error) {
                console.log(request.responseText);
            }
        });
        debugger;

    }

    //not submit in enter
    $('#formid').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
//add row on enter
    function enterForRow(e, index) {
        if (e.keyCode == 13) {
            addRow();

        }
    }
//select item
    function editSelectVal(index) {
        debugger;

        var select_value = $('#select' + index + ' option:selected').val();
        var text = $('#select' + index + ' option:selected').text();

        $.ajax({
            type: 'GET',
            data: {

                select_value: select_value

            },
            url: "{{route('editSelectVal.fetch')}}",

            success: function(data) {
                var result = $.parseJSON(data);

                $("#ar_name" + index + "").text(result[0] + ' - ' +result[1]);
                $("#uom" + index + "").text(result[2]);

                $('#select' + index + ' option:selected').val(select_value).trigger('chosen:updated');;
                $('#select' + index + ' option:selected').text(text).trigger('chosen:updated');;

            },
            error: function(request, status, error) {

                $("#uom" + index + "").text(' ');
                $("#ar_name" + index + "").text('');
                console.log(request.responseText);
            }
        });


    }
//delete Row
    function deleteRow(index) {


        $('tr[data-id=' + index + ']').remove();
       
        headCalculations(index);

    }

 
    // headCalculations(index);
    function headCalculations(index) {
        $('.no-records-found').remove();
        index = $('#table > tbody > tr').length;
        var total = 0;
        console.log(index);
        $('#table > tbody  > tr').each(function() {
            var row_num = $(this).attr('data-id');
            total += parseFloat($('#total' + row_num).text());


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


// custom search
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }



     // Delete DB row functions
     function DeleteStockItem(id, index) {
        debugger;
        $("#del" + index).modal('hide');
        $('.modal-backdrop.fade.in').remove();
        $('.modal-open').css('overflow-y', 'scroll');
        $.ajax({
            type: 'GET',
            url: "{{url('/stock/Remove/Item')}}",
            data: {
                id: id,
                trans_id: '{{$stockTran->id ?? 0}}',
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