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
                <span class="bread-blod"> إضافة مستخدم جديد </span>
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-payment-inner-st">
                    <ul id="myTabedu1" class="tab-review-design" style="text-align:right;direction:rtl">
                        <li class="active"><a href="#description">البيانات الأساسية</a></li>

                    </ul>
                    <div id="myTabContent" class="tab-content custom-product-edit">
                        <div class="product-tab-list tab-pane fade active in" id="description">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="review-content-section">
                                        <div id="dropzone1" class="pro-ad">
                                            <form action="{{route('users.index')}}" method="GET" enctype="multipart/form-data" class="dropzone dropzone-custom needsclick add-professors" id="demo1-upload" style="direction:rtl">
                                         
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="">رقم التليفون</label>
                                                            <input name="mobile" readonly value="{{$row->mobile}}" type="number" class="form-control" placeholder="رقم التليفون">
                                                        </div>

                                                       
                                                        <div class="form-group">
                                                            <label class=""> الاسم بالكامل انجليزى</label>
                                                            <input name="en_fullName" readonly value="{{$row->en_full_name}}" type="text" class="form-control" placeholder=" الاسم بالكامل">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="">صورة</label>

                                                            <div id="uploadOne" class="img-upload">
                                                                <img src="{{ asset('uploads/users/'.$row->image)}}" alt="" style="width: 200px;height:150px;border: 1px dashed #CCC;">
                                                                <div class="upload-icon">
                                                                    <input type="file" disabled name="image" class="upload">
                                                                    <i class="fa fa-camera"></i>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                       
                                                        <div class="form-group">
                                                            <label class="">إسم المستخدم</label>
                                                            <input name="name" readonly value="{{$row->name}}" type="text" class="form-control" placeholder="إسم المستخدم">
                                                        </div>
                                                        <label class="">كلمة المرور</label>
                                                        <div class="form-group">
                                                   
                                                    <input id="myInput" readonly name="password" type="password" value="{{$row->password}}" class="form-control" placeholder="كلمة المرور">
                                                    <input type="checkbox" style="margin: 0 5px;" onclick="myFunction()">Show Password
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                            <label class=""> بريد الكترونى</label>
                                                            <input name="email" readonly value="{{$row->email}}" type="text" class="form-control" placeholder="البريد الالكترونى">
                                                        </div> 
                                                        <div class="form-group">
                                                            <label class="">الاسم بالكامل عربى </label>
                                                            <input name="ar_fullName" readonly value="{{$row->ar_full_name}}" type="text" class="form-control" placeholder=" الاسم بالكامل">
                                                        </div>

                                                        <div class="form-group res-mg-t-15">
                                                            <label class=""> الوظيفة</label>
                                                            <textarea name="job" readonly placeholder=" الوظيفة" style="max-height:90px">{{$row->job}}</textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="payment-adress">
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light"> رجوع</button>

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
</div>

@endsection
@section('scripts')
<script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
@endsection
