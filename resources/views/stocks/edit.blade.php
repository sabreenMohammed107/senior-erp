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
        text-align: right;
    }

    .shadow {
        -webkit-box-shadow: 10px 10px 5px -9px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 10px 10px 5px -9px rgba(0, 0, 0, 0.75);
        box-shadow: 10px 10px 5px -9px rgba(0, 0, 0, 0.75);
    }

    .input-mask-title {
        text-align: right !important;
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
                <a href="{{route('stocks.index')}}"></a> المخازن<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> تعديل مخزن </span>
            </li>
        </ul>
    </div>
</div>


@endsection

@section('content')
<!-- Single pro tab review Start-->
<div class="single-pro-review-area mt-t-30 mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mg-b-15">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 style="direction:rtl">بيانات المخزن</h1><br />
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div class="form-group-inner" style="margin-right:10px;">
                                <form action="{{route('stocks.update',$row->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <a class="btn btn-primary waves-effect waves-light mg-b-15" href="{{route('stocks.index')}}">رجــــــوع</a>
                                    <button class="btn btn-primary waves-effect waves-light mg-b-15" type="submit">حـفـــــظ</button>
                                    <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">

                                        <input type="hidden" name="branch_id" value="{{$branch->id}}">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">
                                            <div class="form-group">
                                                <label class="">كود المخزن</label>
                                                <input name="" type="text" value="{{$row->code}}" class="form-control" placeholder="كود المخزن" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label class="">إسم المخزن باللغة العربية</label>
                                                <input name="ar_name" value="{{$row->ar_name}}" type="text" class="form-control" placeholder="إسم المخزن باللغة العربية">
                                            </div>
                                            <div class="form-group">
                                                <label class="">إسم المخزن باللغة الإنجليزية</label>
                                                <input name="en_name" value="{{$row->en_name}}" type="text" class="form-control" placeholder="إسم المخزن باللغة الإنجليزية">
                                            </div>
                                            <div class="form-group">
                                                <div class="chosen-select-single mg-b-20">
                                                    <label><b> أمين المخزن</b> </label>
                                                    <input name="responsible_emp_id" value="{{$row->responsible_emp_id}}" type="number" class="form-control" placeholder=" أمين المخزن">
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                               <label class="">موظف المخزن</label>
                                               <input name="" type="text" class="form-control" placeholder="موظف المخزن">
                                           </div> -->

                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">
                                            <div class="form-group">
                                                <label class="">كود الفرع</label>
                                                <input name="" type="text" value="{{$branch->code}}" readonly class="form-control" placeholder="كود الفرع">
                                            </div>
                                            <div class="form-group">
                                                <label class="">إسم الفرع</label>
                                                <input name="" value="{{$branch->ar_name}}" readonly type="text" class="form-control" placeholder="إسم الفرع">
                                            </div>
                                            <!-- <div class="form-group">
                                               <label class="">أخر تاريخ لرصيد المخزن</label>
                                               <input name="" type="date" class="form-control" placeholder="تاريخ رصيد العميل" style="text-align:right">
                                           </div> -->
                                           <div class="form-group">
											<div class="chosen-select-single mg-b-20">
												<label> <span style="color:red" > * </span>رقم الحساب </label>
												<select data-placeholder="Choose a charts..."  name="gl_item_id" disabled class="chosen-select" >
													@foreach($charts as $type)
													<option  @if ($row->gl_item_id == $type->id)
                                                                        selected="selected"
                                                                        @endif value="{{$type->id}}">{{$type->code}} - {{$type->ar_name}}</option>
													@endforeach
												</select>
											</div>
										</div>
                                           
                                            <div class="form-group">
                                                <label class="">ملاحظات</label>
                                                <textarea name="notes" placeholder="ملاحظات" style="max-height:50px">{{$row->notes}}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="product-payment-inner-st">
                    <ul id="myTabedu1" class="tab-review-design" style="text-align:center;direction:rtl">
                        <li class="active"><a href="#description"><i class="fa fa-angle-double-down edudropnone" aria-hidden="true"></i> تصنيف البنود </a></li>
                        <li><a href="#reviews"><i class="fa fa-angle-double-down edudropnone" aria-hidden="true"></i> نوع العملية </a></li>
                        <li><a href="#INFORMATION"><i class="fa fa-angle-double-down edudropnone" aria-hidden="true"></i> أصناف المخزن </a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content custom-product-edit">
                        <div class="product-tab-list tab-pane fade active in" id="description">
                            <!-- dual list Start -->
                            <div class="dual-list-box-area mg-b-15" style="direction:rtl">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="sparkline10-list">
                                                <div class="sparkline10-graph">
                                                    <div class="basic-login-form-ad">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="dual-list-box-inner">
                                                                    <form id="form" action="{{route('stockCategory')}}" method="GET" class="wizard-big">
                                                                        <input type="hidden" name="stockCat" value="{{$row->id}}">
                                                                        <select class="form-control dual_select" name="categories[]" multiple>
                                                                            @foreach($subCats as $cat)
                                                                            <option value="{{$cat->id}}">{{$cat->code}} - {{$cat->ar_name}}</option>
                                                                            @endforeach

                                                                            @foreach($row->category as $menyCategory)

                                                                            <option value="{{$menyCategory->id}}" selected="selected">{{$menyCategory->code}} - {{$menyCategory->ar_name}}</option>

                                                                            @endforeach
                                                                        </select>
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <div class="payment-adress" style="margin: 15px;">
                                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">تعديل المخزن</button>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- dual list End-->
                        </div>
                        <div class="product-tab-list tab-pane fade" id="reviews">
                            <!-- dual list Start -->
                            <div class="dual-list-box-area mg-b-15" style="direction:rtl">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="sparkline10-list">
                                                <div class="sparkline10-hd">
                                                    <div class="main-sparkline10-hd">
                                                        <h1 style="text-align:right">إختيار المواقع</h1>
                                                    </div>
                                                </div>

                                                <div class="sparkline10-graph">
                                                    <div class="basic-login-form-ad">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="dual-list-box-inner">
                                                                    <form id="form" action="{{route('stockTransaction')}}" method="GET" class="wizard-big">
                                                                        <input type="hidden" name="stockTrans" value="{{$row->id}}">
                                                                        <select class="form-control dual_select" name="types[]" multiple>
                                                                            @foreach($transactionTypes as $type)
                                                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                                                            @endforeach

                                                                            @foreach($row->type as $menyType)

                                                                            <option value="{{$menyType->id}}" selected="selected">{{$menyType->name}}</option>

                                                                            @endforeach
                                                                        </select>
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <div class="payment-adress" style="margin: 15px;">
                                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">تعديل المخزن</button>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- dual list End-->
                        </div>
                        <div class="product-tab-list tab-pane fade" id="INFORMATION">
                            <!-- Start -->
                            <table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" style="direction:rtl">
                                <thead>
                                    <tr>
                                        <th data-field="state"></th>
                                        <th data-field="id">كود البند</th>
                                        <th>إسم البند</th>
                                        <th>الباتش</th>
                                        <th>تاريخ الصلاحية</th>
                                        <th>الكمية الحالية</th>
                                        <th>سعر الصنف</th>
                                        <th>وصف الصنف</th>
                                     
                                        <th>ملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($totals as $index=>$total)
                                    <tr>
                                        <td></td>
                                        <td>{{$index+1}}</td>
                                        <td>{{$total->item->ar_name ?? ''}} </td>
                                        <td>{{$total->batch_no}}</td>
                                        <td><?php

                                            $date = null;
                                            $date = date_create($total->expired_date) ?>
                                            @if($date) {{ date_format($date,"d-m-Y") }}@endif</td>
                                        <td>{{$total->item_total_qty}}</td>
                                        <td> {{ $total->item->average_price * $total->item_total_qty}} </td>

                                        <td> {{$total->item->ar_description}}</td>
                                        <td>{{$total->notes}}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('modal')

@endsection
@section('scripts')
<script src="{{ asset('webassets/js/tab.js')}}"></script>
<script src="{{ asset('webassets/js/duallistbox/jquery.bootstrap-duallistbox.js')}}"></script>
<script src="{{ asset('webassets/js/duallistbox/duallistbox.active.js')}}"></script>
<script>

</script>
@endsection