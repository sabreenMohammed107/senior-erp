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
                <a href="#"></a> فواتير المبيعات <span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod">مرتجع فواتير المبيعات</span>
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
                <p>هذه الكميه اكبر من اعلى قيمه مجوده فى الفاتورة سوف يتم ارجاعك لاعلى كميه موجوده .</p>
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
        <form action="{{route('revert-sale.store')}}" id="form-id" method="post">
            @csrf
            <div class="mg-b-23">
                <button data-toggle="modal" data-target="#cancle" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">رجوع</button>
                <button data-toggle="modal" data-target="#save" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">حـفـــــظ</button>
            </div>
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

                            <a class="btn btn-primary waves-effect waves-light" href="{{route('revert-sale.show',$invoiceRow->id)}}">رجــــــوع</a>

                        </div>
                    </div>
                </div>
            </div>
            <!--/cancle Company-->

            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 style="direction:rtl">بيانات الفاتورة</h1><br />
                            </div>
                        </div>
                        <input type="hidden" value="{{$invoiceRow->id}}" id="invoice_id" name="invoice_id">
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="form-group-inner" style="margin-right:10px;">
                                    <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$invoiceRow->invoice_no ?? ''}}" class="form-control" placeholder="" readonly>
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
                                                        $date = date_create($invoiceRow->invoice_date);
                                                        ?>

                                                        <input type="date" readonly name="invoice_date" value="{{ date_format($date, 'Y-m-d')}}" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ الاستلام</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$invoiceRow->person_name ?? ''}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b> اسم المسئول</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$invoiceRow->local_net_invoice}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>صافى الفاتورة</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$invoiceRow->branch->ar_name ?? ''}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>اسم الفرع</b></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="{{$invoiceRow->person->code ?? ''}}" class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>كود المسئول</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="sparkline13-hd">
                                            <div class="main-sparkline13-hd">
                                                <h1 style="direction:rtl">بيان حركة المرتجع</h1><br />
                                            </div>
                                        </div>
                                        <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
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
                                                            <input type="date" name="revertDate" class="form-control" placeholder="">
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
                                                            <select data-placeholder="Choose a Country..." name="revertStock" class="chosen-select">
                                                                <option value="">Select</option>
                                                                @foreach($stocks as $stock)
                                                                <option value="{{$stock->id}}">{{$stock->ar_name}} / {{$stock->code}}</option>

                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>كود المخزن</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="total_items_finalqty" name="total_bonus_qty" readonly class="form-control" placeholder="إجمالي الكمية">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>إجمالي البونص</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="total_items_all"  name="local_net_invoice" readonly class="form-control" placeholder="صافي الفاتورة">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>صافي الفاتورة</b></label>
                                                    </div>
                                                </div>
                                            </div>

                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <select data-placeholder="Choose a Country..." name="revertPerson" class="chosen-select">
                                                                <option value="">Select</option>
                                                                @foreach($persons as $person)
                                                                <option value="{{$person->id}}">{{$person->name}} / {{$person->code}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                        <div class="input-mask-title">
                                                            <label><b>كود /إسم المسئول</b></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" name="revertNotes" class="form-control" placeholder="">
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
                                                        <input type="text" id="total_items_price" name="total_items_price" readonly class="form-control" placeholder="إجمالي السعر">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>إجمالي السعر</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="total_items_vat" name="total_vat_value" readonly class="form-control" placeholder="إجمالي الضريبة">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>إجمالي الضريبة</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" readonly id="total_items_discount" name="total_disc_value" class="form-control" placeholder="إجمالي الخصم">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>إجمالي الخصم</b></label>
                                                    </div>
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
                                                <th>إسم البند</th>
                                                <th> UOM</th>
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
                                                <th>السعر </th>
                                                <th>نسبة الضريبة</th>
                                                <th> الضريبة</th>
                                                <th>الصافى</th>
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

        </form>
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


                var invoice_id = $('#invoice_id').val();
                var rowSS = parseFloat(rowCount) + 1;


                $.ajax({
                    type: 'GET',
                    async: false,
                    data: {
                        rowcount: parseFloat(rowCount) + 1,

                        invoice_id: invoice_id

                    },
                    url: "{{url('addRow-revert-sale/fetch')}}",

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
                        $('#item_search' + row_num).text().toLowerCase().indexOf(value) > -1


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

            if ($('#table > tbody > tr').attr('data-id')) {
                rowCount = $('#table > tbody > tr:last').attr('data-id');
            }

            // var rowCount = $('#table > tbody > tr').length;
            var rowSS = parseFloat(rowCount) + 1;
            invoice_id = $('#invoice_id').val();

            $.ajax({
                type: 'GET',
                async: false,
                data: {
                    rowcount: parseFloat(rowCount) + 1,
                    invoice_id: invoice_id

                },
                url: "{{url('addRow-revert-sale/fetch')}}",

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
            var invoice_id = $('#invoice_id').val();

            $.ajax({
                type: 'GET',
                data: {

                    select_value: select_value,
                    invoice_id: invoice_id

                },
                url: "{{route('editSelectVal-revert-sale.fetch')}}",

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

            var item = $('#select' + index + ' option:selected').val();
            var invoice_id = $('#invoice_id').val();
            $.ajax({
                type: 'GET',
                data: {

                    select_value: select_value,
                    item: item,
                    invoice_id: invoice_id,

                },
                url: "{{route('editSelectBatch-revert-sale.fetch')}}",

                success: function(data) {
                   
                    var result = $.parseJSON(data);
                    var itemInvoice =result[4]; // get data from object
                 
                    $("#batchNum" + index + "").text(result[0]);
                    $("#batchDate" + index + "").text(result[1]);
                    $("#batchqty" + index + "").text(result[2]);
                    $("#qty" + index).attr('max', result[2]);
                    // get data  totalvat
                   
                    $("#qty" + index).attr('value',result[2]);
                    $("#itemprice" + index + "").attr('value',JSON.stringify(itemInvoice.item_price));
                    $("#itemBonas" + index).attr('value',JSON.stringify(itemInvoice.item_bonus_qty));
                    $("#total" + index + "").text(JSON.stringify(itemInvoice.total_line_cost));
                    $("#disval" + index).attr('value', JSON.stringify(itemInvoice.item_disc_value));
                    $("#per" + index).attr('value', JSON.stringify(itemInvoice.item_disc_perc));
                    $("#final" + index + "").text(JSON.stringify(itemInvoice.total_line_cost) - JSON.stringify(itemInvoice.item_disc_value));
                    $("#totalvat" + index).text(JSON.parse(JSON.stringify(itemInvoice.item_vat_value).replace(/null/g, 0)));
                    $("#totalcit" + index).text(JSON.parse(JSON.stringify(itemInvoice.item_vat_perc).replace(/null/g, 0)));
                    $("#finalAll" + index).text(JSON.stringify(itemInvoice.final_line_cost));
                   
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
        $('#totalcit' + index + "").text(parseFloat($("#final" + index + "").text()) * parseFloat($("#totalvat" + index + "").text()) );

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
        $('#totalcit' + index + "").text(parseFloat($("#final" + index + "").text()) * parseFloat($("#totalvat" + index + "").text()) );

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
        $('#totalcit' + index + "").text(parseFloat($("#final" + index + "").text()) * parseFloat($("#totalvat" + index + "").text()) );

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
        $('#totalcit' + index + "").text(parseFloat($("#final" + index + "").text()) * parseFloat($("#totalvat" + index + "").text()) );

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
        $('#totalcit' + index + "").text(parseFloat($("#final" + index + "").text()) * parseFloat($("#totalvat" + index + "").text()) );
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
    </script>

    @endsection