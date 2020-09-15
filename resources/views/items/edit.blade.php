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
                <span class="bread-blod"> تعديل الصنف </span>
            </li>
        </ul>
    </div>
</div>

@endsection

@section('content')
<!-- Single pro tab review Start-->
<div class="single-pro-review-area mt-t-30 mg-b-15">
    <div class="container-fluid">
        <form action="{{route('items.update',$row->ITEM_ID)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <a class="btn btn-primary waves-effect waves-light mg-b-15" href="{{route('items.index')}}">رجــــــوع</a>
            <button class="btn btn-primary waves-effect waves-light mg-b-15" type="submit">حـفـــــظ</button>
            <div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="sparkline16-list responsive-mg-b-30">
							
                            <div class="form-group alert-up-pd" style="direction: rtl;">
                                                        <label class="">صورة</label>
                                                            
                                                                <div id="uploadOne" class="img-upload">
                                                                    <img src="{{ asset('uploads/items/'.$row->image)}}" alt="" style="width: 200px;height:150px;border: 1px dashed #CCC;">
                                                                    <div class="upload-icon">
                                                                        <input type="file" name="image" class="upload">
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
											<input type="text" class="form-control" readonly value="{{$row->ITEM_CODE}}" placeholder="">
										</div>
									</div> 
									<div class="form-group data-custon-pick" style="text-align:right">
										<label>إسم الصنف باللغة العربية <span  style="color:red"> * </span></label>
										<div class="input-mark-inner mg-b-22">
											<input type="text" name="ITEM_AR_NAME" value="{{$row->ITEM_AR_NAME}}" class="form-control" placeholder="">
										</div>
									</div>
									<div class="form-group data-custon-pick" style="text-align:right">
										<label>إسم الصنف باللغة الإنجليزية <span  style="color:red"> * </span></label>
										<div class="input-mark-inner mg-b-22">
											<input type="text" name="ITEM_EN_NAME" value="{{$row->ITEM_EN_NAME}}" class="form-control" placeholder="">
										</div>
									</div>
									<div class="form-group data-custon-pick" style="text-align:right">
										<label>إجمالي كمية الصنف</label>
										<div class="input-mark-inner mg-b-22">
											<input type="number" readonly name="ITEM_TOTAL_QTY" value="{{$row->ITEM_TOTAL_QTY}}" class="form-control" placeholder="">
										</div>
									</div>
									<div class="form-group data-custon-pick" style="text-align:right">
										<label>إجمالي تكلفة الصنف</label>
										<div class="input-mark-inner mg-b-22">
											<input type="number" readonly name="ITEM_TOTAL_COST" value="{{$row->ITEM_TOTAL_COST}}" class="form-control" placeholder="">
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
											<select data-placeholder="Choose a Country..." name="PERSON_ID" class="chosen-select">
												<option value="">Select</option>
                                                @foreach($persons as $type)
                                                <option  @if ($row->PERSON_ID == $type->PERSON_ID)
                                                                selected
                                                            @endif
                                                            value="{{$type->PERSON_ID}}">{{$type->PERSON_CODE}} - {{$type->PERSON_NAME}}</option>
                                                @endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group">
											<div class="chosen-select-single mg-b-20">
												<label>كود التصنيف <span  style="color:red"> * </span></label>
												<select data-placeholder="Choose a Country..." name="ITEM_CATEGORY_ID" class="chosen-select">
													<option value="">Select</option>
                                                    @foreach($category as $type)
                                                <option @if ($row->ITEM_CATEGORY_ID == $type->id)
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
												<select data-placeholder="Choose a Country..." name="STORAGE_UOM_ID" class="chosen-select">
													<option value="">Select</option>
                                                    @foreach($uoms as $type)
                                                <option 
                                                @if ($row->STORAGE_UOM_ID == $type->UNIT_MEASURE_ID)
                                                                selected
                                                            @endif
                                                value="{{$type->UNIT_MEASURE_ID}}"> {{$type->UNIT_MEASURE_CODE}} - {{$type->UNIT_MEASURE_AR_NAME}}</option>
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
												<textarea type="number" class="form-control"  name="ITEM_AR_DESCRIPTION" placeholder="" style="max-height:50px">{{$row->ITEM_AR_DESCRIPTION}}</textarea>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="form-group">
											<div class="chosen-select-single mg-b-20">
												<label>وصف الصنف باللغة الإنجليزية </label>
												<div class="input-mark-inner mg-b-22">
													<textarea type="number" class="form-control" name="ITEM_EN_DESCRIPTION" placeholder=""style="max-height:50px">{{$row->ITEM_EN_DESCRIPTION}}</textarea>
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
														<input type="checkbox" value="1" @if($row->ALLOW_SELLING_COMMISSIONS==1) checked @endif id="ALLOW_SELLING_COMMISSIONS"  name="ALLOW_SELLING_COMMISSIONS"> <i></i>
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
												<input type="number" readonly id="RETAIL_PRICE" value="{{$row->RETAIL_PRICE}}" name="RETAIL_PRICE" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>سعر الجملة</label>
											<div class="input-mark-inner mg-b-22">
												<input type="number" readonly id="WHOLESALE_PRICE" value="{{$row->WHOLESALE_PRICE}}" name="WHOLESALE_PRICE" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>متوسط السعر</label>
											<div class="input-mark-inner mg-b-22">
												<input type="number" id="AVERAGE_PRICE" name="AVERAGE_PRICE" value="{{$row->AVERAGE_PRICE}}" readonly class="form-control" placeholder="">
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
														<input type="checkbox"  value="1"  @if($row->HAS_BARCODE==1) checked @endif   id="HAS_BARCODE" name="HAS_BARCODE"> <i></i>
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
													<input type="number" id="ITEM_BARCODE" readonly name="ITEM_BARCODE" value="{{$row->ITEM_BARCODE}}" class="form-control" placeholder="">
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>نسبة الضريبة المضافة</label>
											<div class="input-mark-inner mg-b-22">
												<input type="number" name="VAT_VALUE" step="0.01" value="{{$row->VAT_VALUE}}" class="form-control" placeholder="">
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
											<select data-placeholder="Choose a Country..." name="DEFAULT_UOM_ID" class="chosen-select">
												<option value="">Select</option>
                                                @foreach($uoms as $type)
                                                <option  @if ($row->DEFAULT_UOM_ID == $type->UNIT_MEASURE_ID)
                                                                selected
                                                            @endif value="{{$type->UNIT_MEASURE_ID}}">{{$type->UNIT_MEASURE_CODE}} - {{$type->UNIT_MEASURE_AR_NAME}}</option>
                                                @endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>وحدة التخزين</label>
											<select data-placeholder="Choose a Country..." name="STORAGE_UOM_ID" class="chosen-select">
												<option value="">Select</option>
                                                @foreach($uoms as $type)
                                                <option @if ($row->STORAGE_UOM_ID == $type->UNIT_MEASURE_ID)
                                                                selected
                                                            @endif value="{{$type->UNIT_MEASURE_ID}}">{{$type->UNIT_MEASURE_CODE}} -  {{$type->UNIT_MEASURE_AR_NAME}}</option>
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
												<input type="number" name="MIN_LIMIT" value="{{$row->MIN_LIMIT}}" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group data-custon-pick" style="text-align:right">
											<label>أقصي حد</label>
											<div class="input-mark-inner mg-b-22">
												<input type="number" name="MAX_LIMIT" value="{{$row->MAX_LIMIT}}" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<div class="form-group">
											<div class="chosen-select-single mg-b-20">
												<label>حد إعادة الطلب </label>
												<div class="input-mark-inner mg-b-22">
													<input type="number" name="REQUEST_LIMIT" value="{{$row->REQUEST_LIMIT}}" class="form-control" placeholder="">
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
														<input type="checkbox" @if($row->ALLOWED_SERIAL==1) checked @endif name="ALLOWED_SERIAL" value="1"> <i></i>
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
														<input type="checkbox" @if($row->HAS_EXPIRED_DATE==1) checked @endif name="HAS_EXPIRED_DATE" value="1"> <i></i>
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
														<input type="checkbox" value="1" @if($row->HAS_BATCH==1) checked @endif  name="HAS_BATCH"> <i></i>
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
														<input type="checkbox" value="1" @if($row->ALLOW_DISCOUNTS==1) checked @endif name="ALLOW_DISCOUNTS"> <i></i>
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
														<input type="checkbox" value="1" @if($row->ALLOW_SELLING_COMMISSIONS==1) checked @endif name="ALLOW_SELLING_COMMISSIONS"> <i></i> 
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
														<input type="checkbox" value="1" @if($row->ALLOW_FREE_SAMPLES==1) checked @endif name="ALLOW_FREE_SAMPLES"> <i></i>
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
												<textarea type="text" name="NOTES" class="form-control" placeholder=""style="max-height:50px">{{$row->NOTES}}</textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
        </form>
    </div>
</div>







@endsection