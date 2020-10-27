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

    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="#"></a> المخازن<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> تعديل حركة تالف مخزن </span>
            </li>
        </ul>
    </div>
</div>


@endsection

@section('content')
<!-- Single pro tab review Start-->
<div class="single-pro-review-area mt-t-30 mg-b-15">
    <div class="container-fluid">
        <form action="{{route('expired-items.update',$transObj->id)}}" id="formid" method="post">
            @csrf
            @method('PUT')
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

                                <a class="btn btn-primary waves-effect waves-light" href="{{route('expired-items.index')}}">رجــــــوع</a>

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
                                <h1 style="direction:rtl">بيان تالف المخزن</h1><br />
                            </div>
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
                                                        <input type="text" value="{{$transObj->code}}" class="form-control" placeholder="" readonly>
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
                                                        $nowdate = date("d-m-Y");
                                                        $date = date_create($transObj->transaction_date);
                                                        ?>

                                                        <input type="date" readonly id="date" name="transaction_date" value="{{ date_format($date, 'Y-m-d')}}" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ الحركة</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                            <input type="hidden" value="{{$stock->id ?? ''}}" name="stock_id" class="form-control" placeholder="">

                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$stock->code ?? ''}} - {{$stock->ar_name ?? ''}}" class="form-control" placeholder="" readonly>

                                                    </div>
                                                </div>

                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>كود مخزن الوارد</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <textarea class="form-control" name="notes" placeholder="">{{$transObj->notes}}</textarea>
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
                                <button class="btn_add_item isDisabled" type="button" onclick="getExpired()"> توالف بالتاريخ</button>

                                <button id="add" type="button" class="btn_add_item">إضافة صنف</button>
                                <input type="text" id="myInput" placeholder="إبحث  الصنف ..">

                                <table class="table  table-bordered" id="table" style="direction:rtl;">
                                    <thead>
                                        <tr>
                                            <th data-field="state"></th>

                                            <th data-field="id">كود البند</th>
                                            <th>إسم البند</th>
                                            <th>UOM</th>
                                            <th>باتش الصنف</th>
                                            <th>رقم الباتش</th>
                                            <th>تاريخ الصلاحية</th>
                                            <th>كمية البند</th>
                                            <th>ملاحظات</th>
                                            <th>حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rows">

                                        @include('expired-items.editexpiredAjax')
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


            @endsection
            @section('modal')

            @endsection
            @section('scripts')
            <script>
                function getExpired() {
                    var dateExpired = $('#date').val();
                    $.ajax({
                        url: "{{route('dynamicexpired-items.fetch')}}",
                        method: "get",
                        data: {
                            dateExpired: dateExpired,
                            stock: '{{$stock->id ?? 0}}',

                        },
                        success: function(result) {
                            $('#rows').html(result);

                        }
                    });


                }

                $(document).ready(function() {

                    $('#add').on('click', function() {
                        var rowCount = 0;

                        if ($('#table > tbody  > tr').attr('data-id')) {
                            rowCount = $('#table > tbody  > tr:last').attr('data-id');
                        }


                        stock = $('#stock_id option:selected').val();

                        var rowSS = parseFloat(rowCount) + 1;


                        $.ajax({
                            type: 'GET',
                            async: false,
                            data: {
                                rowcount: parseFloat(rowCount) + 1,

                                stock: '{{$stock->id ?? 0}}',

                            },
                            url: "{{url('expired-items-addRow/fetch')}}",

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
                })


                function enterForRow(e, index) {
                    if (e.keyCode == 13) {
                        addRow();

                    }
                }
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


                    stock = $('#stock_id option:selected').val();

                    var rowSS = parseFloat(rowCount) + 1;


                    $.ajax({
                        type: 'GET',
                        async: false,
                        data: {
                            rowcount: parseFloat(rowCount) + 1,

                            stock: '{{$stock->id ?? 0}}',

                        },
                        url: "{{url('expired-items-addRow/fetch')}}",

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
                /**@abstract */
                function editSelectVal(index) {


                    var select_value = $('#select' + index + ' option:selected').val();



                    $.ajax({
                        type: 'GET',
                        data: {

                            select_value: select_value,
                            select_stock: '{{$stock->id ?? 0}}',

                        },
                        url: "{{route('expired-items-editSelectVal.fetch')}}",

                        success: function(data) {
                            var result = $.parseJSON(data);

                            $("#ar_name" + index + "").text(result[0]);
                            $("#uom" + index + "").text(result[1]);
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



                    $.ajax({
                        type: 'GET',
                        data: {

                            select_value: select_value,

                        },
                        url: "{{route('expired-items-editSelectBatch.fetch')}}",

                        success: function(data) {
                            var result = $.parseJSON(data);

                            $("#batchNum" + index + "").text(result[0]);
                            $("#batchDate" + index + "").text(result[1]);
                            $("#qty" + index + "").val(result[2]);

                        },
                        error: function(request, status, error) {

                            $("#batchNum" + index + "").text('');
                            $("#batchDate" + index + "").text('');
                            $("#qty" + index + "").val('');
                            console.log(request.responseText);
                        }
                    });


                }
                // list inside table
                function deleteRow(index) {
                    //delete Row

                    $('#table > tbody > tr[data-id=' + index + ']').remove();


                }
                // Delete DB row functions
                function DeleteItem(id, index) {
                    debugger;
                    $("#del" + index).modal('hide');
                    $('.modal-backdrop.fade.in').remove();
                    $('.modal-open').css('overflow-y', 'scroll');
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/expired-items/Remove/Item')}}",
                        data: {
                            id: id,
                            trans_id: '{{$transObj->id ?? 0}}',
                        },
                        success: function(data) {


                            location.reload(true);
                        },
                        error: function(request, status, error) {

                            console.log(request.responseText);
                        }
                    });
                }
            </script>
            @endsection