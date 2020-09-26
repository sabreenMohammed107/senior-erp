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
                <span class="bread-blod"> الموردين </span>
            </li>
        </ul>
    </div>
</div>

@endsection

@section('content')
<!-- Single pro tab review Start-->
<div class="single-pro-review-area mt-t-30 mg-b-15">
    <div class="container-fluid">
    <form action="{{route('supplier.store')}}" id="form_id" method="POST" enctype="multipart/form-data">
                @csrf
                <button data-toggle="modal" data-target="#cancle" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">رجوع</button>

<button data-toggle="modal" data-target="#save" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">حـفـــــظ</button>

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

                <button class="btn btn-primary waves-effect waves-light" onclick="document.getElementById('form-id').submit();">حفظ</button>

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

                <a class="btn btn-primary waves-effect waves-light" href="{{route('customer.index')}}">رجــــــوع</a>

            </div>
        </div>
    </div>
</div>
<!--/cancle Company-->  <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="profile-info-inner">
                    <div class="form-group alert-up-pd" style="direction: rtl;">
                        <label class="">صورة</label>

                        <div id="uploadOne" class="img-upload">
                            <img src="{{ asset('webassets/img/default.png')}}" alt="" style="width: 200px;height:150px;border: 1px dashed #CCC;">
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
                                        <label class="">كود المورد</label>
                                        <input name="code" readonly type="text" class="form-control" placeholder="الكود">
                                    </div>
                                    <div class="form-group">
                                        <label class="">إسم المورد</label>
                                        <input name="name" type="text" class="form-control" placeholder="الاسم بالكامل">
                                    </div>
                                    <div class="form-group">
                                        <label class="">كنية المورد</label>
                                        <input name="nick_name" type="text" class="form-control" placeholder="اسم الشهرة">
                                    </div>
                                    <div class="form-group">
                                        <label class="">رقم التليفون</label>
                                        <input name="phone1" type="text" class="form-control" placeholder=" رقم التليفون">
                                    </div>

                                  

                                    <div class="form-group">
                                        <div class="chosen-select-single mg-b-20">
                                            <label><b>كود تصنيف المورد</b> </label>
                                            <select data-placeholder="Choose a Country..." name="person_category_id" class="chosen-select" tabindex="-1">
                                                <option value="">Select</option>
                                                @foreach($person_categories as $obj)
                                                <option value="{{$obj->id}}">{{$obj->ar_name}} - {{$obj->code}}</option>
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
                        <h4 style="text-align:right">بيانات المورد</h4>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="review-content-section">
                                    <div id="dropzone1" class="pro-ad addcoursepro">
                                            <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">

                                                    <div class="form-group">
                                                        <label class="">شخص للتواصل</label>
                                                        <input name="contact_person" type="text" class="form-control" placeholder="رقم التسجيل">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">تليفون مسئول التواصل</label>
                                                        <input name="contact_person_mobile" type="text" class="form-control" placeholder="رقم التسجيل">
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="chosen-select-single mg-b-20">
                                                            <label><b>كود العملة</b> </label>
                                                            <select data-placeholder="Choose a Country..." name="person_currency_id" class="chosen-select" tabindex="-1">
                                                                <option value="">Select</option>
                                                                @foreach($currencies as $obj)
                                                                <option value="{{$obj->id}}">{{$obj->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>
                                                            <input type="checkbox" name="balance_type" class="i-checks" checked> دائن
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">رصيد المورد</label>
                                                        <input name="person_open_balance" type="text" class="form-control" placeholder="رصيد المورد">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">تاريخ رصيد المورد</label>
                                                        <input name="person_open_balance_date" type="date" class="form-control" placeholder="تاريخ رصيد المورد" style="text-align:right">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">حد رصيد المورد</label>
                                                        <input name="person_limit_balance" type="text" class="form-control" placeholder="حد رصيد المورد">
                                                    </div>



                                                </div>


                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">
                                                  
                                                    <div class="form-group">
                                                        <label class="">رقم الموبايل</label>
                                                        <input name="phone2" type="text" class="form-control" placeholder="السجل تجاري">
                                                    </div>

                                                    <div class="form-group res-mg-t-15">
                                                        <label class="">إيميل المورد</label>
                                                        <input name="email" type="text" class="form-control" placeholder="إيميل المورد">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">موقع المورد</label>
                                                        <input name="website" type="text" class="form-control" placeholder="موقع المورد">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="">رقم الفاكس</label>
                                                        <input name="fax" type="text" class="form-control" placeholder="السجل تجاري">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">السجل التجاري</label>
                                                        <input name="commercial_register" type="text" class="form-control" placeholder="السجل التجاري">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">كارت الضرائب</label>
                                                        <input name="tax_card" type="text" class="form-control" placeholder="كارت الضرائب">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">مصلحة الضرائب</label>
                                                        <input name="tax_authority" type="text" class="form-control" placeholder="مصلحة الضرائب">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="">ملاحظات</label>
                                                        <textarea name="notes" placeholder="ملاحظات" style="max-height:100px"></textarea>
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
    </form>
</div>
</div>
@endsection

@section('scripts')

<script>
  
</script>
@endsection