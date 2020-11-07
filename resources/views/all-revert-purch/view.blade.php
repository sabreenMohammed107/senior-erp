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
                <a href="#"></a> المشتريات<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> مرتجعات فواتير المشتريات</span>
            </li>
        </ul>
    </div>
</div>


@endsection

@section('content')
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <a href="{{route('all-revert-purch.index')}}" class="btn btn-primary waves-effect waves-light mg-b-15">رجــــوع</a>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 style="direction:rtl">بيان حركة المرتجع</h1><br />
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
                                                    <input type="text" value="{{$transObj->code}}" class="form-control" placeholder="2012078" readonly>
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
                                                <div class="input-mark-inner mg-b-22">
                                                        <?php
                                                    $date = date_create($transObj->transaction_date);
                                                    ?>

                                                    <input type="date" name="transaction_date" value="{{ date_format($date, 'Y-m-d')}}" class="form-control" placeholder="">
                                  
                                                </div>
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
                                                    <input type="text" value="{{$transObj->transaction->code ?? ''}} / {{$transObj->transaction->ar_name ?? ''}}" class="form-control" placeholder="أحمد السيد" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b>إسم المسئول</b></label>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" value="{{$transObj->person->code ?? ''}} / {{$transObj->person->name ?? ''}}" class="form-control" placeholder="1200 EGP" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b> كود المخزن</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" value="{{$transObj->notes}}" class="form-control" placeholder="1200 EGP" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <div class="input-mask-title">
                                                    <label><b>إجمالي سعر الأصناف</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <div class="input-mark-inner mg-b-22">
                                                    <textarea class="form-control" placeholder="ملاحظات" readonly>{{$transObj->notes}}</textarea>
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

                            <h3 style="text-align:right">الأصناف المرتجعة</h3>
                            <!--<button class="btn_add_item">إضافة مرتجع</button>-->
                            <table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="false" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" style="direction:rtl;">
                                <thead>

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

                                    </tr>
                                </thead>
                                <tbody id="rows">

                                

                                    @foreach($transItems as $i=> $itemo)
                                    <tr data-id="">
                                        <input type="hidden" name="counter" value="">
                                        <td> </td>
                                        <td>
                                        {{$itemo->Item->code ?? ''}}/{{$itemo->Item->ar_name ?? ''}}
                                        </td>
                                        <td id="ar_name" class="ar_name">{{$itemo->item->ar_name ?? ''}}</td>
                                        <td id="uom" class="uom">{{$itemo->item->uom->ar_name ?? ''}}</td>


                                        <td>
                                            <?php
                                            $data = App\Models\Stocks_items_total::where('item_id', $itemo->item_id)
                                                ->where('expired_date', $itemo->expired_date)->where('batch_no', $itemo->batch_no)->first();
                                            $dateBatch = null;
                                            if ($data) {
                                                $dateBatch = date_create($itemo->expired_date);
                                            }
                                            ?>
                  
                                            {{$itemo->batch_no ?? ''}} /@if($dateBatch){{ date_format($dateBatch, 'Y-m-d')}}@endif /{{$itemo->item_qty ?? ''}}
                                        </td>
                                        <td id="batchNum" class="batchNum">{{$itemo->batch_no}} </td>
                                        <?php

                                        $date = date_create($itemo->expired_date);
                                        ?>
                                        <td id="batchDate" class="batchDate">{{ date_format($date, "d-m-Y")}} </td>
                                        <td>
                                        {{$itemo->item_qty}}
                                        </td>

                                        <td>
                                        {{$itemo->item_price}}
                                           
                                        </td>

                                        <td id="total" class="total_item_price">
                                            {{$itemo->total_line_cost}}
                                        </td>
                                        <td>
                                        {{$itemo->notes}}
                                        
                                        </td>



                                    </tr>


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
@section('modal')

@endsection
@section('scripts')
<script>

</script>
@endsection