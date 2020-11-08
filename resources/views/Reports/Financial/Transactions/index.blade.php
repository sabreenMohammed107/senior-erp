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
        
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="#"></a> تقارير<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> تقرير  القيود المحاسبية </span>
            </li>
        </ul>
    </div>
</div>
@endsection
@section('content')
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
<form action="{{url('/Reports/Financial/Transactions/Fetch')}}" method="post">
{{ csrf_field() }}
<div class="container-fluid">
    <button class="btn btn-primary waves-effect waves-light mg-b-15" data-toggle="modal" data-target="#add">رجــــــوع</button>
    <button class="btn btn-primary waves-effect waves-light mg-b-15" data-toggle="modal" data-target="#add">عرض التقرير</button>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="sparkline13-list">
                <div class="sparkline13-hd">
                    <div class="main-sparkline13-hd">
                        <h1 style="direction:rtl">القيود المحاسبية</h1><br />
                    </div>
                </div>
                <div class="sparkline13-graph">
                    <div class="datatable-dashv1-list custom-datatable-overright">
                        <div class="form-group-inner" style="margin-right:10px;">
                            <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
                            
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22"style="direction:rtl">
                                    
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                            <select name="transaction_type_id" data-placeholder="Choose a Country..." class="chosen-select">
                                                <option value="">الكل</option>
                                                @foreach ($Transactions_Types as $Type)
                                                    <option value="{{$Type->id}}">{{$Type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                            <div class="input-mask-title">
                                                <label><b>أرصده إفتتاحية</b></label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                            <div class="input-mark-inner mg-b-22">
                                                <input name="from_date" type="date" required class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                            <div class="input-mask-title">
                                                <label><b>تاريخ البداية <span style="color: red;font-size: 20px;">*</span></b></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                            <div class="input-mark-inner mg-b-22">
                                                <input name="to_date" type="date" required class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                            <div class="input-mask-title">
                                                <label><b>تاريخ النهاية <span style="color: red;font-size: 20px;">*</span></b></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                            <select name="branch_id" data-placeholder="Choose a Country..." class="chosen-select">
                                                <option value="">الكل</option>
                                                @foreach ($Branches as $Branch)
                                                    <option value="{{$Branch->branch_id}}">{{$Branch->ar_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                            <div class="input-mask-title">
                                                <label><b>كود الفرع</b></label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                            <select name="stock_id" data-placeholder="Choose a Country..." class="chosen-select">
                                                <option value="">الكل</option>
                                                @foreach ($Stocks as $Stock)
                                                    <option value="{{$Stock->id}}">{{$Stock->ar_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                            <div class="input-mask-title">
                                                <label><b>كود المخزن</b></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                            <select name="person_id" data-placeholder="Choose a Country..." class="chosen-select">
                                                <option value="">الكل</option>
                                                @foreach ($Persons as $Person)
                                                    <option value="{{$Person->id}}">{{$Person->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                            <div class="input-mask-title">
                                                <label><b>كود الشخص</b></label>
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
<!-- Static Table End -->
@endsection
@section('modal')
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
    <script>
        $(document).ready(function(){
            $('#gl_selector').change(function(){
                var gl_name = $('#gl_selector option:selected').attr('data-name');
                $('#gl_name').val(gl_name);
            })
        })
    </script>
@endsection
