@extends('Layout.web')



@section('crumb')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="{{route('users.index')}}"></a> المستخدم<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> تعديل بيانات المستخدم </span>
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
                        <li><a href="#reviews"> المواقع </a></li>
                        <li><a href="#INFORMATION"> المخازن </a></li>

                    </ul>
                    <div id="myTabContent" class="tab-content custom-product-edit">
                        <div class="product-tab-list tab-pane fade active in" id="description">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="review-content-section">
                                        <div id="dropzone1" class="pro-ad">
                                            <form action="{{route('users.update',$row->id)}}" method="POST" enctype="multipart/form-data" class="dropzone dropzone-custom needsclick add-professors" id="demo1-upload" style="direction:rtl">
                                                @csrf
                                                @method('PUT')
                                                <div class="row res-rtl" style="display: flex ;">
                                                  
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class=""> بريد الكترونى</label>
                                                            <input name="email" value="{{$row->email}}" type="text" class="form-control" placeholder="البريد الالكترونى">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="">كلمة المرور</label>
                                                            <input id="myInput" name="password" type="password" value="{{$row->password}}" class="form-control" placeholder="كلمة المرور">
                                                            <input type="checkbox" onclick="myFunction()">Show Password
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="">إسم المستخدم</label>
                                                            <input name="name" value="{{$row->name}}" type="text" class="form-control" placeholder="إسم المستخدم">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="">الاسم بالكامل عربى </label>
                                                            <input name="ar_fullName" value="{{$row->ar_fullName}}" type="text" class="form-control" placeholder=" الاسم بالكامل">
                                                        </div>

                                                        <div class="form-group res-mg-t-15">
                                                            <label class=""> الوظيفة</label>
                                                            <textarea name="job" placeholder=" الوظيفة" style="max-height:90px">{{$row->job}}</textarea>
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="">رقم التليفون</label>
                                                            <input name="mobile" value="{{$row->name}}" type="number" class="form-control" placeholder="رقم التليفون">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="">تاريخ القفل</label>
                                                            <?php
                                                            $date = date_create($row->lock_date);
                                                            ?>
                                                            <input name="lock_date" value="{{ date_format($date,'Y-m-d') }}" id="finish" type="date" class="form-control" placeholder="تاريخ القفل">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class=""> الاسم بالكامل انجليزى</label>
                                                            <input name="en_fullName" value="{{$row->name}}" type="text" class="form-control" placeholder=" الاسم بالكامل">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="">صورة</label>

                                                            <div id="uploadOne" class="img-upload">
                                                                <img src="{{ asset('uploads/users/'.$row->image)}}" alt="" style="width: 200px;height:150px;border: 1px dashed #CCC;">
                                                                <div class="upload-icon">
                                                                    <input type="file" name="image" class="upload">
                                                                    <i class="fa fa-camera"></i>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="payment-adress">
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light">تعديل المستخدم</button>
                                                            <a class="btn btn-primary waves-effect waves-light" href="{{route('users.index')}}">إلغــاء</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                                    <form id="form" action="{{route('userSite')}}" method="GET" class="wizard-big">
                                                                        <input type="hidden" name="siteUser" value="{{$row->id}}">
                                                                        <select class="form-control dual_select" name="sites[]" multiple>
                                                                            @foreach($branches as $branch)
                                                                            <option value="{{$branch->id}}">{{$branch->code}} - {{$branch->ar_name}}</option>
                                                                            @endforeach

                                                                            @foreach($row->branch as $roeBr)

                                                                            <option value="{{$roeBr->id}}" selected="selected">{{$roeBr->code}} - {{$roeBr->ar_name}}</option>

                                                                            @endforeach
                                                                        </select>
                                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">حــفــظ</button>

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
                            <!-- dual list Start -->
                            <div class="dual-list-box-area mg-b-15" style="direction:rtl">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="sparkline10-list">
                                                <div class="sparkline10-hd">
                                                    <div class="main-sparkline10-hd">
                                                        <h1 style="text-align:right">إختيار المخازن</h1>
                                                    </div>
                                                </div>

                                                <div class="sparkline10-graph">
                                                    <div class="basic-login-form-ad">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="dual-list-box-inner">
                                                                    <form id="form" action="{{route('userStock')}}" method="GET" class="wizard-big">
                                                                        <input type="hidden" name="stockUser" value="{{$row->id}}">
                                                                        <select class="form-control dual_select" name="stocks[]" style="direction: rtl;" multiple>

                                                                            @foreach($stocks as $stock)
                                                                            <option value="{{$stock->STOCK_ID}}">{{$stock->STOCK_CODE}} - {{$stock->STOCK_AR_NAME}}</option>
                                                                            @endforeach

                                                                            @foreach($row->stock as $roeSt)

                                                                            <option value="{{$roeSt->STOCK_ID}}" selected="selected">{{$roeSt->STOCK_CODE}} - {{$roeSt->STOCK_AR_NAME}}</option>

                                                                            @endforeach

                                                                        </select>
                                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">حــفــظ</button>

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
                    </div>
                </div>
            </div>
        </div>

        @endsection
        @section('scripts')
        <!-- tab JS
		============================================ -->
        <script src="{{ asset('webassets/js/tab.js')}}"></script>
        <script src="{{ asset('webassets/js/duallistbox/jquery.bootstrap-duallistbox.js')}}"></script>
        <script src="{{ asset('webassets/js/duallistbox/duallistbox.active.js')}}"></script>
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