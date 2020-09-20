@extends('Layout.web')



@section('crumb')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="{{route('items.index')}}"></a> الاصناف<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> بيانات الصنف </span>
            </li>
        </ul>
    </div>
</div>

@endsection

@section('content')
<!-- Single pro tab review Start-->
<div class="single-pro-review-area mt-t-30 mg-b-15">
    <div class="container-fluid">
       
            <a class="btn btn-primary waves-effect waves-light mg-b-15" href="{{route('items.index')}}">رجــــــوع</a>
            <div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="sparkline16-list responsive-mg-b-30">
							
                            <div class="form-group alert-up-pd" style="direction: rtl;">
                                                        <label class="">صورة</label>
                                                            
                                                                <div id="uploadOne" class="img-upload">
                                                                    <img src="{{ asset('uploads/items/'.$row->image)}}" alt="" style="width: 200px;height:150px;border: 1px dashed #CCC;">
                                                                    <div class="upload-icon">
                                                                        <input type="file" disabled name="image" class="upload">
                                                                        <i class="fa fa-camera"></i>
                                                                    </div>
                                                                </div>
                                                          


                                                            </div>

							<div class="sparkline16-hd">
								<div class="main-sparkline16-hd">
									<h1 style="text-align:right">البيانات الاساسية</h1>
									<br />
								</div>
							</div>
							<div class="sparkline16-graph">
								<div class="date-picker-inner" style="text-align:right">
									
									 <div class="form-group data-custon-pick" style="text-align:right">
										<label>كود الصنف</label>
										<div class="input-mark-inner mg-b-22">
											<input type="text" class="form-control" readonly value="{{$row->code}}" placeholder="">
										</div>
									</div> 
									<div class="form-group data-custon-pick" style="text-align:right">
										<label>إسم الصنف باللغة العربية <span  style="color:red"> * </span></label>
										<div class="input-mark-inner mg-b-22">
											<input type="text" disabled name="ar_name" value="{{$row->ar_name}}" class="form-control" placeholder="">
										</div>
									</div>
									<div class="form-group data-custon-pick" style="text-align:right">
										<label>إسم الصنف باللغة الإنجليزية <span  style="color:red"> * </span></label>
										<div class="input-mark-inner mg-b-22">
											<input type="text" disabled name="en_name" value="{{$row->en_name}}" class="form-control" placeholder="">
										</div>
									</div>
									<div class="form-group data-custon-pick" style="text-align:right">
										<label>إجمالي كمية الصنف</label>
										<div class="input-mark-inner mg-b-22">
											<input type="number" readonly name="item_total_qty" value="{{$row->item_total_qty}}" class="form-control" placeholder="">
										</div>
									</div>
									<div class="form-group data-custon-pick" style="text-align:right">
										<label>إجمالي تكلفة الصنف</label>
										<div class="input-mark-inner mg-b-22">
											<input type="number" readonly name="item_total_cost" value="{{$row->item_total_cost}}" class="form-control" placeholder="">
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="sparkline14-list">
							<div class="sparkline14-hd">
								<div class="main-sparkline14-hd">
									<h1 style="text-align:right">بيانات الصنف</h1>
								</div>
							</div>
							<div class="sparkline14-graph" style="text-align:right">
								<div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>مورد التصنيف <span  style="color:red"> * </span></label>
											<select data-placeholder="Choose a Country..." disabled name="person_id" class="chosen-select">
												<option value="">Select</option>
                                                @foreach($persons as $type)
                                                <option  @if ($row->person_id == $type->id)
                                                                selected
                                                            @endif
                                                            value="{{$type->id}}">{{$type->code}} - {{$type->name}}</option>
                                                @endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group">
											<div class="chosen-select-single mg-b-20">
												<label>كود التصنيف <span  style="color:red"> * </span></label>
												<select data-placeholder="Choose a Country..." disabled name="item_category_id" class="chosen-select">
													<option value="">Select</option>
                                                    @foreach($category as $type)
                                                <option @if ($row->item_category_id == $type->id)
                                                                selected
                                                            @endif
                                                            value="{{$type->id}}">{{$type->code}} - {{$type->ar_name}}</option>
                                                @endforeach
												</select>
											</div>
										</div>
									</div>
									{{--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group">
											<div class="chosen-select-single mg-b-20">
												<label>وحدة التخزين</label>
												<select data-placeholder="Choose a Country..." disabled name="storage_uom_id" class="chosen-select">
													<option value="">Select</option>
                                                    @foreach($uoms as $type)
                                                <option 
                                                @if ($row->storage_uom_id == $type->id)
                                                                selected
                                                            @endif
                                                value="{{$type->id}}"> {{$type->code}} - {{$type->er_name}}</option>
                                                @endforeach
												</select>
											</div>
										</div>
									</div>--}}
								</div>
								<div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>وصف الصنف باللغة العربية</label>
											<div class="input-mark-inner mg-b-22">
												<textarea type="number" disabled class="form-control"  name="ar_description" placeholder="" style="max-height:50px">{{$row->ar_description}}</textarea>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="form-group">
											<div class="chosen-select-single mg-b-20">
												<label>وصف الصنف باللغة الإنجليزية </label>
												<div class="input-mark-inner mg-b-22">
													<textarea type="number" disabled class="form-control" name="en_description" placeholder=""style="max-height:50px">{{$row->en_description}}</textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr style="border-top: 2px solid rgba(139,0,0,.7);" />
								<div class="row mg-b-15">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="colorpicker-inner ts-forms mg-b-23">
											<div class="tsbox">
												<label class="label"> </label>
												<div class="i-checks" style="float:right">
													<label><b>الصنف متاح للبيع</b>
														<input type="checkbox" disabled value="1" @if($row->allow_sale_commission==1) checked @endif id="ALLOW_SELLING_COMMISSIONS"  name="allow_sale_commission"> <i></i>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>سعر التجزئة</label>
											<div class="input-mark-inner mg-b-22">
												<input type="number" readonly id="RETAIL_PRICE" value="{{$row->retail_price}}" name="retail_price" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>سعر الجملة</label>
											<div class="input-mark-inner mg-b-22">
												<input type="number" readonly id="WHOLESALE_PRICE" value="{{$row->wholesale_price}}" name="wholesale_price" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>متوسط السعر</label>
											<div class="input-mark-inner mg-b-22">
												<input type="number" disabled id="AVERAGE_PRICE" name="average_price" value="{{$row->average_price}}" readonly class="form-control" placeholder="">
											</div>
										</div>
									</div>
								</div>
								<div class="row mg-b-15">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="colorpicker-inner ts-forms mg-b-23">
											<div class="tsbox">
												<div class="i-checks" style="float:right">
													<label><b>له بار كود ؟</b>
														<input type="checkbox" disabled  value="1"  @if($row->has_barcode==1) checked @endif   id="HAS_BARCODE" name="has_barcode"> <i></i>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
                                <div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="form-group">
											<div class="chosen-select-single mg-b-20">
												<label>رقم الباركود </label>
												<div class="input-mark-inner mg-b-22">
													<input type="number" disabled id="ITEM_BARCODE" readonly name="item_barcode" value="{{$row->item_barcode}}" class="form-control" placeholder="">
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>نسبة الضريبة المضافة</label>
											<div class="input-mark-inner mg-b-22">
												<input type="number" disabled name="vat_value" step="0.01" value="{{$row->vat_value}}" class="form-control" placeholder="">
											</div>
										</div>
									</div>
								
								</div>
								<hr style="border-top: 2px solid rgba(139,0,0,.7);" />
								<h4>حد الصنف / وحدات التخزين</h4>
								<div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>وحدة القياس</label>
											<select data-placeholder="Choose a Country..." disabled name="default_uom_id" class="chosen-select">
												<option value="">Select</option>
                                                @foreach($uoms as $type)
                                                <option  @if ($row->default_uom_id == $type->id)
                                                                selected
                                                            @endif value="{{$type->id}}">{{$type->code}} - {{$type->ar_name}}</option>
                                                @endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>وحدة التخزين</label>
											<select data-placeholder="Choose a Country..." disabled name="storage_uom_id" class="chosen-select">
												<option value="">Select</option>
                                                @foreach($uoms as $type)
                                                <option @if ($row->storage_uom_id == $type->id)
                                                                selected
                                                            @endif value="{{$type->id}}">{{$type->code}} -  {{$type->ar_name}}</option>
                                                @endforeach
											</select>
										</div>
									</div>
									{{--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group">
											<div class="chosen-select-single mg-b-20">
												<label>نوع الصنف </label>
												<select data-placeholder="Choose a Country..." class="chosen-select">
													<option value="">Select</option>
													<option value="United States">United States</option>
													<option value="United Kingdom">United Kingdom</option>
													<option value="Afghanistan">Afghanistan</option>
													<option value="Aland Islands">Aland Islands</option>
													<option value="Albania">Albania</option>
													<option value="Algeria">Algeria</option>
													<option value="American Samoa">American Samoa</option>
													<option value="Andorra">Andorra</option>
													<option value="Angola">Angola</option>
													<option value="Anguilla">Anguilla</option>
													<option value="Antarctica">Antarctica</option>
													<option value="Antigua and Barbuda">Antigua and Barbuda</option>
													<option value="Argentina">Argentina</option>
													<option value="Armenia">Armenia</option>
													<option value="Aruba">Aruba</option>
													<option value="Australia">Australia</option>
												</select>
											</div>
										</div>
									</div>--}}
								</div>
								<div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>أقل حد</label>
											<div class="input-mark-inner mg-b-22">
												<input type="number" disabled name="min_limit" value="{{$row->min_limit}}" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>أقصي حد</label>
											<div class="input-mark-inner mg-b-22">
												<input type="number" disabled name="max_limit" value="{{$row->max_limit}}" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group">
											<div class="chosen-select-single mg-b-20">
												<label>حد إعادة الطلب </label>
												<div class="input-mark-inner mg-b-22">
													<input type="number" disabled name="request_limit" value="{{$row->request_limit}}" class="form-control" placeholder="">
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr style="border-top: 2px solid rgba(139,0,0,.7);" />
								<div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="colorpicker-inner ts-forms mg-b-23">
											<div class="tsbox">
												<label class="label"> </label>
												<div class="i-checks" style="float:right">
													<label>
														<b>AllowedSerial</b>
														<input type="checkbox" disabled @if($row->allowed_serial==1) checked @endif name="allowed_serial" value="1"> <i></i>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="colorpicker-inner ts-forms mg-b-23">
											<div class="tsbox">
												<label class="label"> </label>
												<div class="i-checks" style="float:right">
													<label><b>HasExpiredDate</b>
														<input type="checkbox" disabled @if($row->has_expired_date==1) checked @endif name="has_expired_date" value="1"> <i></i>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="colorpicker-inner ts-forms mg-b-23">
											<div class="tsbox">
												<label class="label"> </label>
												<div class="i-checks" style="float:right">
													<label>
														<b>HasBatch</b>
														<input type="checkbox" disabled value="1" @if($row->has_batch==1) checked @endif  name="has_batch"> <i></i>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row mg-b-15 res-rtl"style="display: flex ;flex-direction: row-reverse ;">
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="colorpicker-inner ts-forms mg-b-23">
											<div class="tsbox">
												<label class="label"> </label>
												<div class="i-checks" style="float:right">
													<label>
														<b>AlloweDiscounts</b>
														<input type="checkbox" disabled value="1" @if($row->allowe_discount==1) checked @endif name="allowe_discount"> <i></i>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="colorpicker-inner ts-forms mg-b-23">
											<div class="tsbox">
												<label class="label"> </label>
												<div class="i-checks" style="float:right">
													<label><b>AllowSellingCommissions</b>
														<input type="checkbox" disabled value="1" @if($row->allow_sale_commission==1) checked @endif name="allow_sale_commission"> <i></i> 
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="colorpicker-inner ts-forms mg-b-23">
											<div class="tsbox">
												<label class="label"> </label>
												<div class="i-checks" style="float:right">
													<label>
														<b>AllowFreeSamples</b>
														<input type="checkbox" disabled value="1" @if($row->allow_free_sale==1) checked @endif name="allow_free_sale"> <i></i>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>ملاحظات</label>
											<div class="input-mark-inner mg-b-22">
												<textarea type="text" name="notes" class="form-control" placeholder=""style="max-height:50px">{{$row->notes}}</textarea>
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







@endsection