@extends('Layout.web')



@section('crumb')
<div class="row">

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="#"></a> الشركات<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> الفروع </span>
            </li>
        </ul>
    </div>
</div>

@endsection

@section('content')
<div class="product-status mg-b-15">
    <div class="container-fluid">
        <a href="{{route('branch.index')}}" title="New" class="btn btn-primary waves-effect waves-light mg-b-15"> رجوع</a>

        <div class="row" style="direction:rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap drp-lst">
                    <h4>عرض بيانات الفرع</h4>
                    <div class="asset-inner">
                        <div class="product-payment-inner-st" style="padding-top:0px">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="review-content-section">
                                        <div id="dropzone1" class="pro-ad addcoursepro">
                                            <form action="/upload" class="dropzone dropzone-custom needsclick addcourse" id="demo1-upload">
                                                <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">

<div class="form-group">
    <label class="">كود </label>
    <input name="code" readonly value="{{$row->code}}" type="text" class="form-control" placeholder="كود العميل">
</div>
<div class="form-group">
    <label class="">تليفون الفرع</label>
    <input name="phone" readonly value="{{$row->phone}}" type="text" class="form-control" placeholder="تليفون الفرع">
</div>
<div class="form-group res-mg-t-15">
    <label class="">كود النهاية</label>
    <input name="end_code" readonly value="{{$row->end_code}}" type="text" class="form-control" placeholder="كود النهاية">
</div>
<div class="form-group">
    <label class="">موبايل1 الفرع</label>
    <input name="mobile1" readonly value="{{$row->mobile1}}" type="text" class="form-control" placeholder="موبايل الفرع">
</div>
<div class="form-group">
    <label class=""> موبايل 2الفرع</label>
    <input name="mobile2" readonly value="{{$row->mobile2}}" type="text" class="form-control" placeholder="موبايل الفرع">
</div>



<div class="form-group">
    <label class="">ملاحظات</label>
    <textarea name="notes" readonly placeholder="ملاحظات" style="max-height:100px">{{$row->notes}}</textarea>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">

<div class="form-group">
    <label class="">إسم الفرع عربي</label>
    <input name="ar_name" readonly value="{{$row->ar_name}}" type="text" class="form-control" placeholder="إسم الفرع عربي">
</div>
<div class="form-group">
    <label class="">إسم الفرع إنجليزي</label>
    <input name="en_name" readonly value="{{$row->en_name}}" type="text" class="form-control" placeholder="إسم الفرع إنجليزي">
</div>
<div class="form-group res-mg-t-15">
    <label class="">كود البداية</label>
    <input name="start_code" readonly value="{{$row->start_code}}" type="text" class="form-control" placeholder="كود البداية">
</div>

<div class="form-group">
    <label class="">البريد الالكترونى</label>
    <input name="email" readonly value="{{$row->email}}" type="text" class="form-control" placeholder="البريد الالكترونى">
</div>
<div class="form-group">
    <label class="">العنوان</label>
    <textarea name="address" readonly placeholder="العنوان" style="max-height:100px">{{$row->address}}</textarea>
</div>
</div>
</div>

                                                <style>
                                                    .dropzone.dz-clickable .dz-message {
                                                        display: none;
                                                    }
                                                </style>
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
</div>
@endsection