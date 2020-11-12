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
                <a href="#"></a> المبيعات<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod">الموافقة على أوامر المبيعات</span>
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

                            <a href="{{route('approve-sales-order.index')}}" class="btn btn-primary waves-effect waves-light">إلغاء</a>
                           

                            <button data-toggle="modal"  @if($orderObj->order_decision_status_id ==101 ||$orderObj->order_decision_status_id ==102) disabled @endif  data-target="#reject{{$orderObj->id}}" title="Trash" class="btn btn-primary waves-effect waves-light">عدم الموافقة</button>
                            <button data-toggle="modal" @if($orderObj->order_decision_status_id ==101 ||$orderObj->order_decision_status_id ==102) disabled @endif data-target="#accept{{$orderObj->id}}" title="Trash" class="btn btn-primary waves-effect waves-light"> موافقه</button>


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
                        <form id="delete" style="display: inline;" action="{{route('approveOrder')}}" method="POST">
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
                        <form id="delete" style="display: inline;" action="{{route('rejectOrder')}}" method="POST">
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
                                <h1 style="direction:rtl"> أصناف أمر البيع</h1><br />
                            </div>
                        </div>
                        <div class="sparkline13-graph">
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
                            
                                    <div class="row" style="text-align:right !important;direction:rtl !important">
                                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 shadow">
                                            <div class="row">

                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" value="{{$branch->ar_name ?? ''}}" readonly class="form-control" placeholder="فرع القاهرة ">
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
                                                                <input type="text" readonly value="{{$branch->code ?? ''}}" class="form-control" placeholder="36-452 ">
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
                                                            <input type="text" readonly value="{{$MarktCode->ar_name ?? ''}}" id="marketMan" class="form-control" placeholder="محمد عادل">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>مسئول التسويق</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <input type="text" value="" id="marketCode" value="{{$MarktCode->code ?? ''}}" readonly class="form-control" placeholder="204">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                                                            <div class="input-mask-title">
                                                                <label><b>كود التسويق</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" readonly value="{{$saleCode->ar_name ?? ''}}" id="saleMan" class="form-control" placeholder="أحمد علي">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>مسئول المبيعات</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <input type="text" value="{{$saleCode->code ?? ''}}" id="saleCode" readonly class="form-control" placeholder="105">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                                                            <div class="input-mask-title">
                                                                <label><b>كود المبيعات</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" id="stock_name" value="{{$orderObj->stock->ar_name ?? ''}}" readonly class="form-control" placeholder="مخزن القاهرة">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>إسم المخزن</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <select id="stock_id" disabled name="stock_id" data-placeholder="Choose a Country..." class="chosen-select" tabindex="-1">
                                                                    @foreach($stocks as $stock)
                                                                    <option @if ($orderObj->stock_id == $stock->id)
                                                                        selected="selected"
                                                                        @endif
                                                                        value="{{$stock->id}}">{{$stock->ar_name}} / {{$stock->code}}</option>

                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" id="output" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                                                            <div class="input-mask-title">
                                                                <label><b>كود المخزن</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
                                                        <div class="input-mark-inner mg-b-22">
                                                            <input type="text" id="person_name" value="{{$orderObj->person->name ?? ''}}" name="person_name" readonly class="form-control" placeholder="شركة سمارت تك">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
                                                        <div class="input-mask-title">
                                                            <label><b>إسم العميل</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <select id="person_id" disabled name="person_id" data-placeholder="Choose a Country..." class="chosen-select" tabindex="-1">
                                                                    @foreach($persons as $person)
                                                                    <option @if ($orderObj->person_id == $person->id)
                                                                        selected="selected"
                                                                        @endif
                                                                        value="{{$person->id}}">{{$person->name}} / {{$person->code}}</option>
                                                                    @endforeach

                                                                </select> </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                                                            <div class="input-mask-title">
                                                                <label><b>كود العميل</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                   
                                                    
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                                                            <div class="input-mark-inner mg-b-22">
                                                                <select disabled data-placeholder="Choose a currency..." class="chosen-select" tabindex="-1">
                                                                    @foreach($currencies as $cur)
                                                                    <option @if ($orderObj->currency_id == $cur->id)
                                                                        selected="selected"
                                                                        @endif
                                                                        value="{{$cur->id}}">{{$cur->name}}</option>
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


                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 shadow">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">

                                                        <?php
                                                        $date = date_create($orderObj->received_date_suggested);
                                                        ?>
                                                        <input type="date" disabled id="order_delev" value="{{ date_format($date, 'Y-m-d')}}" name="order_delev" class="form-control" \>
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
                                                        <input type="text" id="decOrder" disabled value="{{$orderObj->order_description}}" name="decOrder" class="form-control" placeholder="توريد الأصناف المرفقة" style="height:80px;margin-bottom:10px;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>وصف أمر البيع</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" id="total_items_price" value="{{$orderObj->order_value}}" name="total_items_price" readonly class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>قيمة أمرالبيع</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="number" id="total_items_discount" value="{{$orderObj->total_disc_value}}" name="total_items_discount" readonly class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>إجمالي الخصم</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="number" id="total_items_final" value="{{$orderObj->total_final_cost}}" name="total_items_final" readonly class="form-control" placeholder="2250">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>صافي القيمة</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 shadow">
                                    
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" readonly value="{{$orderObj->purch_order_no}}" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>رقم أمر البيع</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <?php
                                                        $date2 = date_create($orderObj->order_date);
                                                        ?>
                                                        <input type="date" id="order_date" disabled value="{{ date_format($date2, 'Y-m-d')}}" name="order_date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ أمر البيع</b></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" readonly class="form-control"  placeholder="قيد التنفيذ">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>حالة أمرالبيع</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" value="@if($orderObj->order_decision_status_id==100) لم يتم اتخاز قرار @elseif($orderObj->order_decision_status_id==101) تمت الموافقة @elseif($orderObj->ORDER_DECISION_STATUS_ID==102) لم تتم الموافقه@else @endif" class="form-control" readonly placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>قرار أمرالبيع</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" class="form-control" disabled value="{{$orderObj->notes}}" name="notes" id="notes" placeholder="الملاحظات" style="height:80px;margin-bottom:10px;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="input-mask-title">
                                                        <label><b>ملاحظات</b></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <h3 style="text-align:right">الأصناف</h3>
                                <table class="table-striped" id="puchasetable" data-locale="ar-SA" data-pagination="true" data-pagination-pre-text="السابق" data-pagination-next-text="التالي" data-show-export="true" data-minimum-count-columns="2" data-page-list="[10, 25, 50, 100, all]" data-sort-name="index" data-sort-order="desc" data-search="true" style="direction:rtl" data-toggle="table" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="true" data-cookie="true" data-toolbar="#toolbar" data-show-toggle="true" data-show-fullscreen="true" data-show-columns-toggle-all="true">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="false"></th>
                                            <th data-field="index">كود البند</th>
                                            <th>UOM</th>
                                            <th>إسم البند</th>
                                            <th>الباتش</th>
                                            <th> رقم الباتش</th>
                                            <th>تاريخ الصلاحية</th>
                                            <th>الكمية الحالية</th>
                                            <th>كمية الصنف</th>
                                            <th>سعر الصنف</th>
                                            <th>الإجمالي</th>
                                            <th>نسبة الخصم</th>
                                            <th>قيمة الخصم</th>
                                            <th>السعر النهائي</th>
                                            <th> ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rows">

                                        @include('approve-sales-order.editAjax')
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
    $('select[name="person_id"]').on('change', function() {

        var select_value = $(this).val();

        $.ajax({
            type: 'GET',
            data: {

                select_value: select_value

            },
            url: "{{route('editSelectValPerson.fetch')}}",

            success: function(data) {
                var result = $.parseJSON(data);

                $("#saleCode").val(result[0]);
                $("#saleMan").val(result[1]);
                $("#marketCode").val(result[2]);
                $("#marketMan").val(result[3]);
                $("#person_name").val($('#person_id option:selected').text());

            },
            error: function(request, status, error) {

                $("#saleCode").val('');
                $("#saleMan").val('');
                $("#marketCode").val('');
                $("#marketMan").val('');
                $("#person_name").val($('#person_id option:selected').text());

            }
        });


    });



    $('select[name="stock_id"]').on('change', function() {


        $("#stock_name").val($('#stock_id option:selected').text());


    });
    $('#formid').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    function addRow(url) {
        index = $('#puchasetable > tbody > tr').length;
        var rowCount = $('#puchasetable tbody tr').length;
        stock_id = $('#stock_id option:selected').val();

        $.ajax({
            type: 'GET',
            data: {
                rowcount: index,
                stock: '{{$orderObj->STOCK_ID}}',


            },
            url: "{{url('addRow/fetch')}}",

            success: function(data) {
                ++rowCount;

                $('#rows').append(data);
                $('#puchasetable > tbody > tr').last().find('input').first().focus();
                $('#select' + index).select2();


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
    //Start row functions
    function deleteRow(index) {
        $('tr[data-id=' + index + ']').remove();
        var trs = $('#puchasetable > tbody').html();
        $('#puchasetable').bootstrapTable('destroy');
        $('#rows').html(trs);
        $('#puchasetable').bootstrapTable();
        headCalculations(index);
    }

    function editSelectVal(index) {
        debugger;
        var select_value = $('#select' + index + ' option:selected').val();


        $.ajax({
            type: 'GET',
            data: {

                select_value: '{{$orderObj->STOCK_ID}}'

            },
            url: "{{route('editSelectVal.fetch')}}",

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

    function editSelectBatch(index) {
        debugger;

        var select_value = $('#selectBatch' + index + ' option:selected').val();

        var person = $('#person_id option:selected').val();
        alert(person);
        $.ajax({
            type: 'GET',
            data: {

                select_value: select_value,
                person: '{{$orderObj->PERSON_ID}}',

            },
            url: "{{route('editSelectBatch.fetch')}}",

            success: function(data) {
                var result = $.parseJSON(data);

                $("#batchNum" + index + "").text(result[0]);
                $("#batchDate" + index + "").text(result[1]);
                $("#batchqty" + index + "").text(result[2]);
                $("#itemprice" + index + "").val(result[3]);
                headCalculations(index);


            },
            error: function(request, status, error) {

                $("#batchNum" + index + "").text('');
                $("#batchDate" + index + "").text('');
                $("#batchqty" + index + "").text('');
                console.log(request.responseText);
            }
        });


    }

    function itemPrice(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();

        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();
        $("#final" + index + "").text((price * qty) - disval);
        headCalculations(index);
        $("#itemprice" + index).attr('value', price);
    }

    function disPer(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();

        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();
        $("#final" + index + "").text((price * qty) - disval);
        headCalculations(index);
        $("#per" + index).attr('value', per);
    }

    function disval(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var disval = $("#disval" + index + "").val();

        $("#total" + index + "").text(price * qty);
        var cc = disval / (price * qty);

        $("#per" + index).val(cc);
        $("#final" + index + "").text((price * qty) - disval);
        headCalculations(index);
        $("#disval" + index).attr('value', disval);

    }

    function itemQty(index) {
        var price = $("#itemprice" + index + "").val();
        var qty = $("#qty" + index + "").val();
        var per = $("#per" + index + "").val();

        $("#total" + index + "").text(price * qty);
        var Amount = (price * qty) * per;
        $("#disval" + index).attr('value', Amount);
        var disval = $("#disval" + index + "").val();

        $("#final" + index + "").text((price * qty) - disval);
        headCalculations(index);


        $("#qty" + index).attr('value', qty);
    }

    // headCalculations(index);
    function headCalculations(index) {
        var total = 0;
        var discount = 0;
        var final = 0;

        console.log(index);
        $('#puchasetable > tbody  > tr').each(function() {

            var temp = $('#total' + index).text();

            var temp2 = $('#disval' + index).val();
            var temp3 = $('#final' + index).text();
            if ($('#total' + index).text()) {

                total = total + parseFloat($('#total' + index).text());

            }

            if (temp2) {
                discount += parseFloat($('#disval' + index).val());
            }
            if (temp3) {
                final += parseFloat($('#final' + index).text());


            }
            --index;
        })

        console.log(index);
        //    console.log(parseFloat($('#total' + index).text()));
        //  console.log(discount);
        $('#total_items_price').val(total.toFixed(2));
        $('#total_items_discount').val(discount.toFixed(2));
        $('#total_items_final').val(final.toFixed(2));

    }


    //Start row functions
    function DeleteOrderItem(id, index) {
        debugger;
        $("#del" + index).modal('hide');
        $('.modal-backdrop.fade.in').remove();
        $('.modal-open').css('overflow-y', 'scroll');
        $.ajax({
            type: 'GET',
            url: "{{url('/orders/Remove/Item')}}",
            data: {
                id: id,
                order_id: '{{$orderObj->ORDER_ID}}',
            },
            success: function(data) {

                headCalculations(index);
                location.reload(true);
            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        });
        headCalculations();
    }
</script>
@endsection