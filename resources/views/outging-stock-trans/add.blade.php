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
                <a href="#"></a> المخزن <span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod">حركات المخزن</span>
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
                <form action="{{route('outging-stock-trans.store')}}" id="form-id" method="post">
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

                                        <button class="btn btn-primary waves-effect waves-light" name="action" value="save" onclick="document.getElementById('form-id').submit();">حفظ</button>

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
                                        <h4 class="modal-title" style="text-align:right">تأكيد البيانات</h4>
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
                                        <button class="btn btn-primary waves-effect waves-light" name="action" value="confirm" onclick="document.getElementById('form-id').submit();">حفظ</button>

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

                                        <a class="btn btn-primary waves-effect waves-light" href="{{route('outging-stock-trans.index')}}">رجــــــوع</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/cancle Company-->
                        <div class="sparkline13-list">
                            <div class="sparkline13-hd">
                                <div class="main-sparkline13-hd">
                                    <h1 style="direction:rtl">حركات المخزن</h1><br />
                                </div>
                            </div>
                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">
                                    <div class="form-group-inner" style="margin-right:10px;">
                                        <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
                                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 mg-b-22">
                                                <input type="hidden" value="{{$stock->id ?? 0}}" id="stock_id" name="stock_id">
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" value="{{$stock->code ?? ''}} / {{$stock->ar_name ?? ''}}" class="form-control" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>كود المخزن الرئيسي</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <select id="secondary_stock_id" name="secondary_stock_id" data-placeholder="Choose a Country..." class="chosen-select">
                                                                <option value="">Select</option>
                                                                @foreach($secondStocks as $second)
                                                                <option value="{{$second->id}}">{{$second->ar_name}} / {{$second->code}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>كود المخزن الفرعي</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" class="form-control" placeholder="" readonly>
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
                                                            <input type="date" name="transaction_date" class="form-control" placeholder="">
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
                                                            <textarea type="text" name="notes" class="form-control" placeholder=""></textarea>
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
                                                    <th>Serial</th>
                                                    <th data-field="id">كود البند</th>
                                                    <th>إسم البند</th>
                                                    <th>UOM</th>
                                                    <th>الباتش</th>
                                                    <th>كود الباتش</th>
                                                    <th>تاريخ الصلاحية</th>
                                                    <th>الكمية الحالية</th>
                                                    <th>كمية البند</th>
                                                    <th>الكمية المتبقة</th>
                                                    <th>ملاحظات</th>
                                                    <th>حذف</th>
                                                </tr>
                                            </thead>
                                            <tbody id="rows">
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

                    stock = $('#stock_id').val();
                    var rowSS = parseFloat(rowCount) + 1;


                    $.ajax({
                        type: 'GET',
                        async: false,
                        data: {
                            rowcount: parseFloat(rowCount) + 1,
                            stock: stock

                        },
                        url: "{{url('addRow-outging-stock-trans/fetch')}}",

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
                            $('#batch_search' + row_num).text().toLowerCase().indexOf(value) > -1


                        );
                    });

                });

            })


            $('#form-id').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            function addRow(url) {
                var rowCount = 0;

                if ($('#table > tbody  > tr').attr('data-id')) {
                    rowCount = $('#table > tbody  > tr:last').attr('data-id');
                }

                stock = $('#stock_id').val();
                var rowSS = parseFloat(rowCount) + 1;


                $.ajax({
                    type: 'GET',
                    async: false,
                    data: {
                        rowcount: parseFloat(rowCount) + 1,
                        stock: stock

                    },
                    url: "{{url('addRow-outging-stock-trans/fetch')}}",

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


            }


            function editSelectVal(index) {
                debugger;

                var select_value = $('#select' + index + ' option:selected').val();
                var text = $('#select' + index + ' option:selected').text();
                var select_stock = $('#stock_id').val();

                $.ajax({
                    type: 'GET',
                    data: {

                        select_value: select_value,
                        select_stock: select_stock

                    },
                    url: "{{route('editSelectVal-outging-stock-trans.fetch')}}",

                    success: function(data) {
                        var result = $.parseJSON(data);
                        $("#ar_name" + index + "").text(result[0]);
                        $("#uom" + index + "").text(result[1]);
                        $("#selectBatch" + index + "").html(result[2]);
                        $('#selectBatch' + index).select2();
                        $("#batchNum" + index + "").text('');
                        $("#batchDate" + index + "").text('');
                        $("#batchqty" + index + "").text('');



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

                $.ajax({
                    type: 'GET',
                    data: {

                        select_value: select_value,

                    },
                    url: "{{route('editSelectBatch-outging-stock-trans.fetch')}}",

                    success: function(data) {
                        var result = $.parseJSON(data);
                        $("#batchNum" + index + "").text(result[0]);
                        $("#batchDate" + index + "").text(result[1]);
                        $("#batchqty" + index + "").text(result[2]);

                        $("#qty" + index).attr('max', result[2]);


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

            function maxQty(index) {

                var max = $("#qty" + index + "").attr('max');

                var qty = $("#qty" + index + "").val();
                console.log(qty);
                if( jQuery('#qty'+ index).val() > ( parseInt(jQuery('#qty'+ index).attr('max')) ) ){
                // if (qty > max) {
                    $('#myModal').modal('show');

                    $("#qty" + index).val(max);
                    $("#itemRemain" + index).val(0);

                }
                 else {
                    $("#qty" + index).val(qty);
                    $("#itemRemain" + index + "").val(max - qty);

                }




                $("#qty" + index).attr('value', qty);
            }

            function itemQty(index) {
                var max = $("#qty" + index + "").attr('max');
                var qty = $("#qty" + index + "").val();
               
                $("#itemRemain" + index + "").val(max - qty);
                $("#qty" + index).attr('value', qty);




            }
        </script>
        @endsection