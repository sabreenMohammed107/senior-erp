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
                <a href="#"></a> المخزن <span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod">بيان الإستلامات من مخزن الصادر </span>
            </li>
        </ul>
    </div>
</div>


@endsection

@section('content')

<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
    <form action="{{route('incoming-stock-trans.store')}}" id="form-id" method="post">
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

                                        <a class="btn btn-primary waves-effect waves-light" href="{{route('incoming-stock-trans.edit',$stockRow->id)}}">رجــــــوع</a>

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
                            <h1 style="direction:rtl">بيانات الإستلام</h1><br />
                        </div>
                    </div>
                    <input type="hidden" value="{{$stockRow->id}}" name="parent_tranaction_id" >
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div class="form-group-inner" style="margin-right:10px;">
                            <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" value="{{$stockRow->code ?? ''}}" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b>رقم الصادر</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <?php
                                                    $date = date_create($stockRow->transaction_date);
                                                    ?>

                                                    <input type="date" readonly name="transaction_date" value="{{ date_format($date, 'Y-m-d')}}" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b>تاريخ الاستلام</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                        <div class="row">
                                            <input type="hidden"  name="secondary_stock_id" value="{{$stockRow->primary_stock_id}}" >
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" value="{{$stockRow->transaction->ar_name ?? ''}}" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b>مخزن الصادر</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <input type="hidden" name="stock_id" value="{{$stockRow->secondary_stock_id}}" >

                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" value="{{$stockRow->secondry->ar_name ?? ''}}" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b>مخزن الوارد</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b-22"></div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b>رقم الاستلام</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="date" name="rcvDate" class="form-control" placeholder="">
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
                                                    <textarea class="form-control" name="rcvNote" placeholder=""></textarea>
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
                                            <th>الكميات الواردة</th>
                                            <th>الكميات المستلمة</th>
                                            <th>ملاحظات</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php


                                        $counter = 1;

                                        ?>
                                        <?php
                                        $counterrrr = 1;
                                        ?>
                                        @foreach($transItems as $index=> $transItem)
                                        <tr>
                                            <input type="hidden" name="counter" value="{{$counter}}">
                                            <input type="hidden" name="transItem{{$counter}}" value="{{$transItem->id}}">
                                            <td>{{$index+1}}</td>
                                            <td>{{$transItem->item->code ?? ''}} / {{$transItem->item->ar_name ?? ''}}</td>
                                            <td>{{$transItem->item->ar_name ?? ''}}</td>
                                            <td>{{$transItem->item->uom->ar_name ?? ''}}</td>
                                            <td>
                                                <?php
                                                $data = App\Models\Stocks_items_total::where('item_id', $transItem->item_id)->where('stock_id', $transItem->transaction->primary_stock_id)
                                                    ->where('expired_date', $transItem->expired_date)->where('batch_no', $transItem->batch_no)->first();
                                                $dateBatch = null;
                                                if ($data) {
                                                    $dateBatch = date_create($data->expired_date);
                                                }
                                                ?>
                                                 <input type="hidden" name="batchData{{$counter}}" value="{{$data->id}}">
                                                {{$data->batch_no ?? ''}} /@if($dateBatch){{ date_format($dateBatch, 'Y-m-d')}}@endif /{{$data->item_total_qty ?? ''}}
                                            </td>
                                            <td>{{$transItem->batch_no}} </td>
                                            <?php

                                            $date = date_create($transItem->expired_date);
                                            ?>
                                            <td>{{ date_format($date, "d-m-Y")}} </td>
                                            <td>
                                                <?php
                                                $reserved = 0;
                                                $transSelect = App\Models\Stocks_transaction::where('parent_tranaction_id', $transItem->transaction_id)->pluck('id')->toArray();
                                                if ($transSelect) {
                                                    $reserved = App\Models\Stock_transaction_item::where('item_id', $transItem->item_id)
                                                        ->where('expired_date', $transItem->expired_date)->where('batch_no', $transItem->batch_no)->whereIn('transaction_id', $transSelect)->sum('item_qty');
                                                }
                                                $remain = $transItem->item_qty - $reserved;
                                                ?>
                                                {{$remain}}
                                            </td>
                                            <td>
                                                <div class="input-mark-inner">
                                                    <input type="text" name="transItemQty{{$counter}}" class="form-control" placeholder="" style="width: 200px">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-mark-inner">
                                                    <input type="text" name="transItemNotes{{$counter}}" class="form-control" placeholder="" style="width: 200px">
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        ++$counter;

                                        if ($counter > count($transItems)) {
                                        ?>
                                            @break
                                        <?php }
                                        $counterrrr++;
                                        ?>
                                        @endforeach
                                    </tbody>
                                </table>
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
    </script>
    @endsection