@extends('Layout.web')



@section('crumb')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="#"></a> الشركات<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> العملاء </span>
            </li>
        </ul>
    </div>
</div>

@endsection

@section('content')
<!-- Single pro tab review Start-->
<div class="single-pro-review-area mt-t-30 mg-b-15">
    <div class="container-fluid">
    
            <a class="btn btn-primary waves-effect waves-light mg-b-15" href="{{route('customer.index')}}">رجــــــوع</a>
            <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="profile-info-inner">
                        <div class="form-group alert-up-pd" style="direction: rtl;">
                            <label class="">صورة</label>

                            <div id="uploadOne" class="img-upload">
                                <img src="{{ asset('uploads/persons/'.$row->image)}}" alt="" style="width: 200px;height:150px;border: 1px dashed #CCC;">
                                <div class="upload-icon">
                                    <input type="file" name="image" class="upload">
                                    <i class="fa fa-camera"></i>
                                </div>
                            </div>



                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="review-content-section">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="direction:rtl"">
												<div class=" form-group">
                                            <label class="">كود العميل</label>
                                            <input name="code" value="{{$row->code}}" readonly type="text" class="form-control" placeholder="اسم الشهرة">
                                        </div>
                                        <div class="form-group">
                                            <label class="">إسم العميل</label>
                                            <input name="name" value="{{$row->name}}" readonly type="text" class="form-control" placeholder="الاسم بالكامل">
                                        </div>
                                        <div class="form-group">
                                            <label class="">كنية العميل</label>
                                            <input name="nick_name" value="{{$row->nick_name}}" readonly type="text" class="form-control" placeholder="اسم الشهرة">
                                        </div>
                                        <div class="form-group">
                                            <label class="">رقم التليفون</label>
                                            <input name="phone1" value="{{$row->phone1}}" readonly type="text" class="form-control" placeholder=" رقم التليفون">
                                        </div>

                                        <div class="form-group">
                                            <div class="chosen-select-single mg-b-20">
                                                <label><b>كود الفرع</b> </label>
                                                <select data-placeholder="Select ...." disabled name="branch_id" class="chosen-select" >
                                                    <option value="">Select</option>
                                                    @foreach($branches as $obj)
                                                    <option @if($row->branch_id==$obj->id) selected @endif
                                                        value="{{$obj->id}}" >{{$obj->ar_name}} - {{$obj->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="chosen-select-single mg-b-20">
                                                <label><b>كود تصنيف العميل</b> </label>
                                                <select data-placeholder="Select ...." disabled name="person_category_id" class="chosen-select" >
                                                    <option value="">Select</option>
                                                    @foreach($person_categories as $obj)
                                                    <option @if($row->person_category_id==$obj->id) selected @endif
                                                        value="{{$obj->id}}">{{$obj->ar_name}} - {{$obj->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <div class="chosen-select-single mg-b-20">
                                                <label><b>كود التسويق</b> </label>
                                                <select data-placeholder="Select ...." disabled name="marketing_rep_id" class="chosen-select" >
                                                    <option value="">Select</option>
                                                    @foreach($marketers as $obj)
                                                    <option @if($row->marketing_rep_id==$obj->id) selected @endif value="{{$obj->id}}">{{$obj->ar_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="chosen-select-single mg-b-20">
                                                <label><b>كود المبيعات</b> </label>
                                                <select data-placeholder="Select ...." disabled name="sales_rep_id" class="chosen-select" >
                                                    <option value="">Select</option>
                                                    @foreach($sales as $obj)
                                                    <option @if($row->sales_rep_id==$obj->id) selected @endif value="{{$obj->id}}">{{$obj->ar_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="product-payment-inner-st res-mg-t-30 analysis-progrebar-ctn">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4 style="text-align:right">بيانات العميل</h4>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="review-content-section">
                                        <div id="dropzone1" class="pro-ad addcoursepro">
                                            <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">

                                                    <div class="form-group">
                                                        <label class="">شخص للتواصل</label>
                                                        <input name="contact_person" readonly value="{{$row->contact_person}}" type="text" class="form-control" placeholder="رقم التسجيل">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">تليفون مسئول التواصل</label>
                                                        <input name="contact_person_mobile" readonly value="{{$row->contact_person_mobile}}" type="text" class="form-control" placeholder="رقم التسجيل">
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="chosen-select-single mg-b-20">
                                                            <label><b>كود البلد</b> </label>
                                                            <select data-placeholder="Select ...." disabled name="country_id" id="country" class="chosen-select dynamic" >
                                                                <option value="">Select</option>
                                                                @foreach($countries as $obj)
                                                                <option @if($row->country_id==$obj->id) selected @endif value="{{$obj->id}}">{{$obj->ar_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="chosen-select-single mg-b-20">
                                                            <label><b>كود المنطقة</b> </label>
                                                            <select data-placeholder="Choose a city..."  disabled name="city_id" id="city" class="chosen-select city">
                                                                <option value="">Select</option>
                                                                @foreach($cities as $obj)
                                                                <option @if($row->city_id==$obj->id) selected @endif value="{{$obj->id}}">{{$obj->ar_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="chosen-select-single mg-b-20">
                                                            <label><b>كود الموقع</b> </label>
                                                            <select data-placeholder="Choose a location..."  disabled name="location_id" id="location" class="chosen-select" >
                                                            <option value="">Select</option>
                                                                @foreach($locations as $obj)
                                                                <option @if($row->location_id==$obj->id) selected @endif value="{{$obj->id}}">{{$obj->ar_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="chosen-select-single mg-b-20">
                                                            <label><b>كود العملة</b> </label>
                                                            <select data-placeholder="Select ...." disabled name="person_currency_id" class="chosen-select" >
                                                                <option value="">Select</option>
                                                                @foreach($currencies as $obj)
                                                                <option @if($row->person_currency_id==$obj->id) selected @endif value="{{$obj->id}}">{{$obj->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>
                                                            <input type="checkbox" name="balance_type" class="i-checks"  @if($row->balance_type=1) checked @endif> مدين
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">رصيد العميل</label>
                                                        <input name="person_open_balance" readonly value="{{$row->person_open_balance}}" type="text" class="form-control" placeholder="رصيد العميل">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">تاريخ رصيد العميل</label>
                                                        <?php
                                                        $date = null;
                                                        $date = date_create($row->person_open_balance_date) ?>

                                                        <input name="person_open_balance_date" readonly value="{{date_format($date,"Y-m-d") }}" type="date" class="form-control" placeholder="تاريخ رصيد العميل" style="text-align:right">
                                                    </div>
                                                    {{--<div class="form-group">
                                                        <label class="">حد رصيد العميل</label>
                                                        <input name="person_limit_balance" readonly value="{{$row->person_limit_balance}}" type="text" class="form-control" placeholder="حد رصيد العميل">
                                                    </div>--}}



                                                </div>


                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">
                                                    <!-- {{--<div class="form-group">

                                                        <label class="">تاريخ أخر فاتورة</label>
                                                        <?php
                                                        $date2 = null;
                                                        $date2 = date_create($row->person_open_balance_date) ?>
                                                        <input name="last_invoice_date" readonly type="date" value="{{date_format($date2,"Y-m-d") }}" class="form-control" placeholder="تاريخ أخر فاتورة">
                                                    </div>--}} -->
                                                    <div class="form-group">
                                                        <label class="">رقم الموبايل</label>
                                                        <input name="phone2" readonly value="{{$row->phone2}}" type="text" class="form-control" placeholder="السجل تجاري">
                                                    </div>

                                                    <div class="form-group res-mg-t-15">
                                                        <label class="">البريد الإالكترونى</label>
                                                        <input name="email" readonly value="{{$row->email}}" type="text" class="form-control" placeholder="البريد الإالكترونى">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">الموقع الإالكترونى</label>
                                                        <input name="website" readonly value="{{$row->website}}" type="text" class="form-control" placeholder="الموقع الإالكترونى">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="">رقم الفاكس</label>
                                                        <input name="fax" readonly value="{{$row->fax}}" type="text" class="form-control" placeholder="السجل تجاري">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">السجل التجاري</label>
                                                        <input name="commercial_register" readonly value="{{$row->commercial_register}}" type="text" class="form-control" placeholder="السجل التجاري">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">البطاقه الضريبية</label>
                                                        <input name="tax_card" readonly value="{{$row->tax_card}}" type="text" class="form-control" placeholder="البطاقه الضريبية">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">مصلحة الضرائب</label>
                                                        <input name="tax_authority" readonly value="{{$row->tax_authority}}" type="text" class="form-control" placeholder="مصلحة الضرائب">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="">ملاحظات</label>
                                                        <textarea name="notes" disabled placeholder="ملاحظات" style="max-height:100px">{{$row->notes}}</textarea>
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
            </div>
    </div>
</div>
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function() {

        $('.dynamic').change(function() {

            if ($(this).val() != '') {
                var select = $(this).attr("id");
                var value = $(this).val();


                $.ajax({
                    url: "{{route('dynamicPersonCountry.fetch')}}",
                    method: "get",
                    data: {
                        select: select,
                        value: value,

                    },
                    success: function(result) {

                        $('#city').append(result);
                        $("#city").addClass("chosen-select");
                        $("#city").trigger("chosen:updated");
                        $(select).trigger("chosen:updated");
                        $('#location').val('').trigger('chosen:updated');
                    }

                })
            }
        });


        $('.city').change(function() {

            if ($(this).val() != '') {
                var select = $(this).attr("id");
                var value = $(this).val();


                $.ajax({
                    url: "{{route('dynamicPersonCity.fetch')}}",
                    method: "get",
                    data: {
                        select: select,
                        value: value,

                    },
                    success: function(result) {

                        $('#location').append(result);
                        $("#location").addClass("chosen-select");
                        $("#location").trigger("chosen:updated");
                        $(select).trigger("chosen:updated");


                    }

                })
            }
        });

    });
</script>
@endsection