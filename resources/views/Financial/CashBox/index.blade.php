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
            <form role="search" class="sr-input-func">
                {{-- <input type="text" placeholder="...إبحث هنا" class="search-int form-control" style="text-align:right">
                <a href="#"><i class="fa fa-search"></i></a> --}}
            </form>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="#"></a> المالية <span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> الخزينة </span>
            </li>
        </ul>
    </div>
</div>
@endsection
@section('content')
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <button class="btn btn-primary waves-effect waves-light mg-b-15" data-toggle="modal" data-target="#add">رجــــــوع</button>
        <!--<button class="btn btn-primary waves-effect waves-light mg-b-15" data-toggle="modal" data-target="#add">إلغــــاء</button>-->
        <!--<button class="btn btn-primary waves-effect waves-light mg-b-15" data-toggle="modal" data-target="#add">حـفـــــظ</button>-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <!-- <h1 style="direction:rtl"> بيانات الخزن </h1><br /> -->
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <!-- <div class="form-group-inner" style="margin-right:10px;">
                                <div class="row res-rtl"style="display: flex ;flex-direction: row-reverse ;">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                        <div class="row">
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <div class="input-mask-title">
                                                    <label><b>كود الخزينة</b></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                                <div class="input-mark-inner mg-b-22">
                                                    <input type="text" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <div class="input-mask-title">
                                                    <label><b>إسم الخزينة</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <h3 style="text-align:right">بيانات الخزن</h3>
                        <a href="{{url('/Financial/CashBox/Add')}}" class="btn_add_item">إضافة خزينة</a>
                            <table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="false" data-cookie="true"
                                   data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" style="direction:rtl;">
                                <thead>
                                    <tr>
                                        <th data-field="state"></th>
                                        <th>كود الخزينة</th>
                                        <th>إسم الخزينة باللغة العربية</th>
                                        <th>إسم الخزينة باللغة الإنجليزية</th>
                                        <th>الفرع</th>
                                        <th>الرصيد الإفتتاحى</th>
                                        <th>تاريخ بداية الترصيد</th>
                                        <th>الرصيد الحالي</th>
                                        <th>ملاحظات</th>
                                        <th>حذف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($CashBoxes as $i => $Box)
                                    <tr>
                                        <td></td>
                                        <td>{{++$i}}</td>
                                        <td>{{$Box->ar_name}}</td>
                                        <td>{{$Box->en_name}}</td>
                                        <td>{{$Box->branch->ar_name}}</td>
                                        <td>{{$Box->open_balance}}</td>
                                        <td>{{date('Y-m-d', strtotime($Box->start_date))}}</td>
                                        <td>{{$Box->current_balance}}</td>
                                        <td>{{$Box->notes}}</td>
                                        <td>
                                            <div class="product-buttons">
                                                <a href="{{url("/Financial/CashBox/View/$Box->id")}}" class="pd-setting-ed btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a href="{{url("/Financial/CashBox/Edit/$Box->id")}}" class="pd-setting-ed btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a href="#" data-toggle="modal" data-target="#del{{$Box->id}}" title="Trash" class="pd-setting-ed btn"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </div>
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
@foreach ($CashBoxes as $BoxModal)
    <!--Delete-->
<div id="del{{$BoxModal->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-color-modal bg-color-2">
                <h4 class="modal-title" style="text-align:right">حذف بيانات البنك</h4>
                <div class="modal-close-area modal-close-df">
                    <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                </div>
            </div>
        <form action="{{url('/Financial/CashBox/Delete')}}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
                <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
            <h2>{{$BoxModal->ar_name}}</h2>
                <h4>هل تريد حذف جميع بيانات الخزينة ؟  </h4>
                <input type="hidden" name="id" value="{{$BoxModal->id}}">
            </div>
            <div class="modal-footer info-md">
                <a data-dismiss="modal" href="#">إلغــاء</a>
                <button type="submit">حـذف</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!--/Delete-->
@endforeach
@endsection
@section('scripts')
    <!-- data table JS
    ============================================ -->
    <script src="{{ asset('webassets/js/data-table/bootstrap-table.js')}}"></script>
    <script src="{{ asset('webassets/js/data-table/tableExport.js')}}"></script>
    <script src="{{ asset('webassets/js/data-table/data-table-active.js')}}"></script>
    <script src="{{ asset('webassets/js/data-table/bootstrap-table-editable.js')}}"></script>
    <script src="{{ asset('webassets/js/data-table/bootstrap-editable.js')}}"></script>
    <script src="{{ asset('webassets/js/data-table/bootstrap-table-resizable.js')}}"></script>
    <script src="{{ asset('webassets/js/data-table/colResizable-1.5.source.js')}}"></script>
    <script src="{{ asset('webassets/js/data-table/bootstrap-table-export.js')}}"></script>
    <!--  editable JS
            ============================================ -->
    <script src="{{ asset('webassets/js/editable/jquery.mockjax.js')}}"></script>
    <script src="{{ asset('webassets/js/editable/mock-active.js')}}"></script>
    <script src="{{ asset('webassets/js/editable/select2.js')}}"></script>
    <script src="{{ asset('webassets/js/editable/moment.min.js')}}"></script>
    <script src="{{ asset('webassets/js/editable/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{ asset('webassets/js/editable/bootstrap-editable.js')}}"></script>
    <script src="{{ asset('webassets/js/editable/xediable-active.js')}}"></script>
@endsection
