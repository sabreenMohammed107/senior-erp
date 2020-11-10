@extends('Layout.web')



@section('crumb')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="#"></a> الأصناف<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> أسعار الأصناف </span>
            </li>
        </ul>
    </div>
</div>

@endsection
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
        text-align: right;
    }
</style>
@endsection
@section('content')
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">

        <button data-toggle="modal" data-target="#cancle" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">رجوع</button>




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

                        <a class="btn btn-primary waves-effect waves-light" href="{{route('item-price.index')}}">رجــــــوع</a>

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
                            <h1 style="direction:rtl">أسعار الاصناف</h1>
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div class="form-group-inner" style="margin-right:10px;">
                                <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 shadow mg-b-15" style="direction:rtl">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                <select data-placeholder="Choose a Country..." disabled name="item_id" class="chosen-select" tabindex="-1">
                                                    <option value="">Select</option>
                                                    @foreach($items as $obj)
                                                    <option @if($row->id==$obj->id) selected @endif value="{{$obj->id}}">{{$obj->code}} - {{$obj->ar_name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <div class="input-mask-title">
                                                    <label><b>كود الصنف</b></label>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 shadow mg-b-15">


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
                                    float: right;
                                    /* Full-width */
                                    font-size: 16px;
                                    /* Increase font-size */
                                    padding: 12px 20px 12px 40px;
                                    /* Add some padding */
                                    border: 1px solid #ddd;
                                    /* Add a grey border */
                                    margin-bottom: 12px;
                                    /* Add some space below the input */
                                    text-align: right;
                                }
                            </style>
     <div class="row res-rtl" style="display: flex ">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow">
                              <h3 style="text-align:right">اضافة</h3>
                                <input type="text" id="myInput" placeholder="إبحث  الصنف ..">
                                        </div>
                              </div>
                                <div style="overflow-x:auto;">
                            <table class="table table-bordered" id="table" style="direction:rtl;">
                                <thead>
                                    <tr>

                                        <th data-field="id">كــود</th>
                                        <th>نوع الصنف</th>


                                        <th>إسم تصنيف العميل</th>

                                        <th>إسم العميل</th>
                                        <th>سعر الصنف</th>
                                        <th>الاختيارات</th>
                                    </tr>
                                </thead>
                                <tbody id="rows">


                                    <?php

                                    $counter = 1;

                                    ?>
                                    <?php
                                    $counterrrr = 1;
                                    ?>

                                    @foreach($priceItems as $i=> $itemo)

                                    <tr data-id="{{$counter}}">
                                        <td>{{$counter}}</td>

                                        <td>
                                            <input type="number" style="display: none;" value="{{$itemo->id}}" name="item_price_id{{$counter}}" id="item_price_id{{$counter}}" class="form-control " placeholder="">

                                            <input type="number" style="display: none;" value="{{$counter}}" name="counterStore" id="counter" class="form-control" placeholder="">

                                            <div class="bt-df-checkbox">
                                                <input type="hidden" name="" class="inv_type" value="new">
                                                <input class="cat" disabled onclick="radioSelect({{$counter}})" @if($itemo->item_pricing_type_id == 101) checked @endif type="radio" value="no" id="catRadio{{$counter}}" name="optionsRadios{{$counter}}">
                                                <label><b>  تصنيف عميل  </b></label>
                                                <input class="radio-checked cat" disabled onclick="radioSelect({{$counter}})" @if($itemo->item_pricing_type_id == 100) checked @endif type="radio" value="yes" id="clientRadio{{$counter}}" name="optionsRadios{{$counter}}">
                                                <label><b>  إسم عميل </b></label>
                                            </div>
                                        </td>

                                        <td><select id="selectCat{{$counter}}" name="selectCatup{{$counter}}" disabled class="form-control" placeholder="أختر المنتج">
                                                <option value=""> {{$itemo->category->ar_name ?? ''}} - {{$itemo->category->code ?? ''}} </option>
                                                @foreach ($cats as $cat)
                                                <option value="{{$cat->id}}">{{$cat->ar_name}} - {{$cat->code}}</option>
                                                @endforeach
                                            </select>

                                            <span id="item_cat{{$counter}}" style="display:none;">{{$itemo->category->ar_name ?? ''}} - {{$itemo->category->code ?? ''}}</span>
                                        </td>
                                        <td><select id="selectClient{{$counter}}" name="selectClientup{{$counter}}" disabled style="display: none" class="form-control chosen-select" placeholder="أختر المنتج">
                                                <option value="">{{$itemo->client->name ?? ''}} - {{$itemo->client->code ?? ''}}</option>
                                                @foreach ($clients as $client)
                                                <option value="{{$client->id}}">{{$client->name}} - {{$client->code}}</option>
                                                @endforeach
                                            </select>
                                            <span id="item_client{{$counter}}" style="display:none;">{{$itemo->client->name ?? ''}} - {{$itemo->client->code ?? ''}}</span>

                                        </td>
                                        <td>
                                            <div class="input-mark-inner mg-b-22">
                                                <input type="number" step=".01" onkeypress="enterForRow(event,{{$counter}})" id="itemprice{{$counter}}" name="item_priceup{{$counter}}" oninput="itemPrice({{$counter}})" value="{{$itemo->item_price}}" class="form-control item_price" placeholder="">
                                            </div>
                                            <span style="display:none;" id="total_item_price{{$counter}}" class="total_item_price" placeholder="">{{$itemo->item_price}}</span>

                                        </td>
                                        <td>
                                          
                                        </td>
                                    </tr>

                                    <?php
                                    ++$counter;

                                    if ($counter > count($priceItems)) {
                                    ?>
                                        @break
                                    <?php }
                                    $counterrrr++;
                                    ?>

                                    @endforeach
                                    <input type="number" style="display: none;" value="{{$counterrrr}}" name="qqq" class="form-control item_quantity" placeholder=""> </tbody>
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


            $.ajax({
                type: 'GET',
                async: false,
                data: {
                    rowcount: parseFloat(rowCount) + 1,


                },
                url: "{{url('addRowPrice/fetch')}}",

                success: function(data) {

                    $('#rows').append(data);
                    $("#selectCat" + rowSS).select2();
                    // $('#table #catRadio' + rowSS).focus();
                    $('#firstTT' + rowSS).focus();
                    console.log(rowSS);
                },

                error: function(request, status, error) {
                    console.log(request.responseText);
                }
            });
            debugger;

        })

        //filter
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#table > tbody > tr").filter(function() {
                var row_num = $(this).attr('data-id');
                $(this).toggle(
                    $('#item_cat' + row_num).text().toLowerCase().indexOf(value) > -1 ||
                    $('#item_client' + row_num).text().toLowerCase().indexOf(value) > -1 ||
                    $('#total_item_price' + row_num).text().toLowerCase().indexOf(value) > -1



                );
            });

        });

    })

    //adding row
    function addRow() {
        var rowCount = 0;

        if ($('#table > tbody  > tr').attr('data-id')) {
            rowCount = $('#table > tbody  > tr:last').attr('data-id');
        }

        // var rowCount = $('#table > tbody > tr').length;
        var rowSS = parseFloat(rowCount) + 1;


        $.ajax({
            type: 'GET',
            async: false,
            data: {
                rowcount: parseFloat(rowCount) + 1,


            },
            url: "{{url('addRowPrice/fetch')}}",

            success: function(data) {

                $('#rows').append(data);
                $("#selectCat" + rowSS).select2();
                $('#firstTT' + rowSS).focus();            },

            error: function(request, status, error) {
                console.log(request.responseText);
            }
        });
        debugger;

    }

    //not submit in enter
    $('#form-id').on('keyup keypress', function(e) {
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

    function radioSelect(index) {
        debugger;
        // alert(checked);
        var cat = $("#selectCat" + index);
        var client = $("#selectClient" + index);

        if ($('input[type=radio][name=optionsRadios' + index + ']:checked').val() == 'no') {
            $(cat).css('display', 'inline-block').attr('disabled', false);
            $(client).css('display', 'none').attr('disabled', 'disabled');

            $(cat).addClass("chosen-select");
            $(cat).trigger("chosen:updated");
            $(cat).select2();
        } else {
            $(cat).css('display', 'none').attr('disabled', 'disabled');
            $(client).css('display', 'inline-block').attr('disabled', false);
            $(client).addClass("chosen-select");
            $(client).trigger("chosen:updated");
            $(client).select2();
        }
        $("input[type=radio][name=optionsRadios" + index + "]:checked").siblings().attr('checked', false);
        $("input[type=radio][name=optionsRadios" + index + "]:checked").attr('checked', 'checked');
    }

    //delete Row
    function deleteRow(index) {


        $('tr[data-id=' + index + ']').remove();


    }

    //item price
    function itemPrice(index) {
        var price = $("#itemprice" + index + "").val();

        $("#itemprice" + index).attr('value', price);
    }
    //--------------------
    // Delete DB row functions
    function DeletePriceItem(id, index) {
        debugger;
        $("#del" + index).modal('hide');
        $('.modal-backdrop.fade.in').remove();
        $('.modal-open').css('overflow-y', 'scroll');
        $.ajax({
            type: 'GET',
            url: "{{url('/itemPrice/Remove/Item')}}",
            data: {
                id: id,

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