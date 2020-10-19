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
                <a href="#"></a> المشتريات<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod">الموافقة على أوامر الشراء</span>
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
                        <div class="">

                            <a href="{{route('approve-purch-order.index')}}" class="btn btn-primary waves-effect waves-light">إلغاء</a>
                           

                            <button data-toggle="modal"  @if($orderObj->order_decision_status_id ==101 ||$orderObj->order_decision_status_id ==102) disabled @endif  data-target="#reject{{$orderObj->id}}" title="Trash" class="pd-setting-ed">عدم الموافقة</button>
                            <button data-toggle="modal" @if($orderObj->order_decision_status_id ==101 ||$orderObj->order_decision_status_id ==102) disabled @endif data-target="#accept{{$orderObj->id}}" title="Trash" class="btn btn-primary"> موافقه</button>


                        </div>
                    </div>
                     <!--accept Company-->
		<div id="accept{{$orderObj->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header header-color-modal bg-color-2">
						<h4 class="modal-title" style="text-align:right">  الموافقة على أمر البيع</h4>
						<div class="modal-close-area modal-close-df">
							<a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
						</div>
					</div>
					<div class="modal-body">
						<span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
						<!-- <h2>إسم الفرع</h2> -->
						<h4>هل تريد  الموافقة على أمر البيع؟  </h4>
					</div>
					<div class="modal-footer info-md">
						<a data-dismiss="modal" href="#">إلغــاء</a>
                        <form id="delete" style="display: inline;" action="{{route('approveOrder-purch')}}" method="POST">
													@csrf
                                                    <input type="hidden" value="{{$orderObj->id}}" name="approveOrder" >	

													<button type="submit">نعم</button>
												</form>
					</div>
				</div>
			</div>
		</div>
        <!--/accept Company-->
        
         <!--reject Company-->
		<div id="reject{{$orderObj->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header header-color-modal bg-color-2">
						<h4 class="modal-title" style="text-align:right">عدم الموافقة على أمر البيع</h4>
						<div class="modal-close-area modal-close-df">
							<a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
						</div>
					</div>
					<div class="modal-body">
						<span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
						<!-- <h2>إسم الفرع</h2> -->
						<h4>هل تريد عدم الموافقة على أمر البيع؟  </h4>
					</div>
					<div class="modal-footer info-md">
						<a data-dismiss="modal" href="#">إلغــاء</a>
                        <form id="delete" style="display: inline;" action="{{route('rejectOrder-purch')}}" method="POST">
													@csrf
											<input type="hidden" value="{{$orderObj->id}}" name="rejectOrder" >	
													<button type="submit">نعم</button>
												</form>
					</div>
				</div>
			</div>
		</div>
		<!--/reject Company-->
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 style="direction:rtl"> أصناف أمر الشراء</h1><br />
                            </div>
                        </div>
                        <div class="datatable-dashv1-list custom-datatable-overright" style="direction:rtl">
                            <div class="form-group-inner" style="margin-right:10px;">
										<div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow">
												<div class="row"style="direction:rtl">
													<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
														<div class="bt-df-checkbox">
                                                        <input class="" disabled type="radio" @if($orderObj->order_decision_status_id==101) checked="" @endif value="option2" id="optionsRadios2" name="optionsRadios2">
															<label><b> تمت الموافقة </b></label>
															<input class="radio-checked" disabled type="radio" @if($orderObj->order_decision_status_id==102) checked="" @endif value="option1" id="optionsRadios1" name="optionsRadios2">
                                                            <label><b> تم الرفض </b></label>
                                                            <input class="radio-checked" disabled type="radio" @if($orderObj->order_decision_status_id==100) checked="" @endif value="option1" id="optionsRadios1" name="optionsRadios2">
															<label><b> لم يتم أتخاذ قرار  </b></label>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
														<label class="login2">حالة أمر البيع</label>
													</div>
                                                </div>
                                            </div></div></div>
                                            <hr>
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
                                                        <label><b>رقم أمر الشراء</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <?php
                                                        $date = date_create($orderObj->order_date);
                                                        ?>
                                                        <input type="date" readonly id="order_date" value="{{ date_format($date, 'Y-m-d')}}" name="order_date" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ أمر الشراء</b></label>
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
                                                        <label><b>حالة أمر الشراء</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" readonly class="form-control" readonly placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>قرار أمر الشراء</b></label>
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
                                                        <input type="date" id="order_delev" readonly value="{{ date_format($date, 'Y-m-d')}}" name="received_date_suggested" class="form-control" placeholder="">
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
                                                        <input type="text" id="decOrder" readonly value="{{$orderObj->order_description}}" name="order_description" class="form-control" placeholder="" style="height:80px;margin-bottom:10px;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>وصف أمر الشراء</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="total_items_price"  name="order_value" value="{{$orderObj->order_value}}" readonly class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>قيمة أمر الشراء</b></label>
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
                                                            <input type="text" id="person_name" value="{{$persons[0]->name ?? ''}}" name="person_name" readonly class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>إسم المورد</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <select id="person_id" name="person_id" disabled data-placeholder="Choose a Country..." class="chosen-select">
                                                                    @foreach($persons as $person)
                                                                    <option @if ($orderObj->person_id == $person->id)
                                                                        selected="selected"
                                                                        @endif value="{{$person->id}}">{{$person->name}} / {{$person->code}}</option>
                                                                    @endforeach

                                                                </select> </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                                                            <div class="input-mask-title">
                                                                <label><b>كود المورد</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" id="currency-rate" value="{{$currencies[0]->conversion_rate ?? ''}}" readonly class="form-control" placeholder="">
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
                                                                <select data-placeholder="Choose a Country..." disabled name="currency_id" class="chosen-select">
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
                                            <div class="row">

                                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">

                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" readonly class="form-control" name="notes" value="{{$orderObj->notes}}" id="notes" placeholder="" style="height:80px;margin-bottom:10px;">
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
                                <div class="row res-rtl" style="display: flex ">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow">
                                        <h3 style="text-align:right">الأصناف</h3>
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
                                                <th> حد الطلب</th>

                                                <th>كمية الصنف</th>
                                                <th>سعر الصنف</th>
                                                <th>الإجمالي</th>

                                                <th>ملاحظات</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rows">
                                        </tbody>
                                        @include('approve-purch-order.editAjax')
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

    $(function() {
        debugger;


        $('#add').on('click', function() {
            var rowCount = 0;

            if ($('#table > tbody  > tr').attr('data-id')) {
                rowCount = $('#table > tbody  > tr:last').attr('data-id');
            }

            supplier = $('#person_id option:selected').val();
            var rowSS = parseFloat(rowCount) + 1;


            $.ajax({
                type: 'GET',
                async: false,
                data: {
                    rowcount: parseFloat(rowCount) + 1,
                    supplier: supplier,

                },
                url: "{{url('addRow-purchOrder/fetch')}}",

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

                    $('#total' + row_num).text().toLowerCase().indexOf(value) > -1

                );
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
    })
    $('select[name="person_id"]').on('change', function() {


        $("#person_name").val($('#person_id option:selected').text());

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

        var rowSS = parseFloat(rowCount) + 1;
        supplier = $('#person_id option:selected').val();
        $.ajax({
            type: 'GET',
            async: false,
            data: {
                rowcount: parseFloat(rowCount) + 1,
                supplier: supplier,

            },
            url: "{{url('addRow-purchOrder/fetch')}}",

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

        $.ajax({
            type: 'GET',
            data: {

                select_value: select_value,

            },
            url: "{{route('editSelect-purch-val.fetch')}}",

            success: function(data) {
                var result = $.parseJSON(data);
                $("#ar_name" + index + "").text(result[0]);
                $("#uom" + index + "").text(result[1]);

                $("#itemprice" + index + "").attr('value', result[2]);
                $("#qtyLimit" + index + "").attr('value', result[3]);


                headCalculations(index);

            },
            error: function(request, status, error) {

                $("#uom" + index + "").text(' ');
                $("#ar_name" + index + "").text(' ');
                $("#itemprice" + index + "").attr('value', 0);
                $("#qtyLimit" + index + "").attr('value', 0);

                console.log(request.responseText);
            }
        });
        $('#item_search' + index).text(text);

    }



    function itemPrice(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();




        $("#total" + index + "").text(price * qty);


        headCalculations(index);
        $("#itemprice" + index).attr('value', price);
    }


    function itemQty(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();


        $("#total" + index + "").text(price * qty);



        headCalculations(index);
        $("#qty" + index).attr('value', qty);




    }

    // headCalculations(index);
    function headCalculations(index) {
        index = $('#table > tbody > tr').length;
        var total = 0;



        $('#table > tbody > tr').each(function() {
            var row_num = $(this).attr('data-id');
            total += parseFloat($('#total' + row_num).text());

            --index;
        })
        console.log(total);

        $('#total_items_price').val(total.toFixed(2));



    }

    function maxQty(index) {

        // var max = $("#qtyLimit" + index + "").val();
        // var price = $("#itemprice" + index + "").val();
        // var qty = $("#qty" + index + "").val();
        // var per = $("#per" + index + "").val();
        // if (qty > max) {
        //     $('#myModal').modal('show');


        //     $("#qty" + index).val(max);
        // } else {
        //     $("#qty" + index).val(qty);
        // }



        // $("#total" + index + "").text(price * qty);

        // headCalculations(index);
        // $("#qty" + index).attr('value', qty);
    }
    // Delete DB row functions
    function DeleteOrderItem(id, index) {
        debugger;
        $("#del" + index).modal('hide');
        $('.modal-backdrop.fade.in').remove();
        $('.modal-open').css('overflow-y', 'scroll');
        $.ajax({
            type: 'GET',
            url: "{{url('/purchOrder/Remove/Item')}}",
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

