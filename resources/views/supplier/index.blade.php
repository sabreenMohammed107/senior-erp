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
        text-align: right;
    }
</style>
@endsection
@section('content')
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <a href="{{ route('supplier.create') }}" title="New" class="btn btn-primary waves-effect waves-light mg-b-15">إضافة مورد </a>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 style="direction:rtl">الموردين</h1>
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright" style="direction:rtl">

                            <table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-ajaxed="false" data-click-to-select="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="state"></th>
                                        <th data-field="id">كــود</th>
                                        <th>إسم المورد</th>

                                        <th>البريد الالكتروني</th>
                                        <th>الهاتف</th>
                                        <th> تاريخ الرصيد الإفتتاحى</th>
                                        <th>الرصيد الإفتتاحى</th>
                                        <th>الاختيارات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $index=>$row)
                                    <tr>
                                        <td></td>
                                        <td>{{$row->code}}</td>
                                        <td>{{$row->name}}</td>

                                        <td>{{$row->email}}</td>
                                        <td>{{$row->phone1}}</td>
                                        <td><?php
                                            $date = null;
                                            $date = date_create($row->person_open_balance_date) ?>
                                            @if($date) {{ date_format($date,"d-m-Y") }}@endif</td>
                                        <td>{{$row->person_open_balance}}</td>
                                        <td>
                                            <div class="product-buttons">
                                                <a href="{{ route('supplier.show',$row->id)}}"><button title="View" class="pd-setting-ed"><i class="fa fa-file" aria-hidden="true"></i></button></a>
                                                <a href="{{ route('supplier.edit',$row->id)}}"><button title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                                <button data-toggle="modal" data-target="#del{{$row->id}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!--Delete Company-->
                                    <div id="del{{$row->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header header-color-modal bg-color-2">
                                                    <h4 class="modal-title" style="text-align:right">حذف بيانات التصنيف</h4>
                                                    <div class="modal-close-area modal-close-df">
                                                        <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
                                                    <h2>{{$row->ar_name}}</h2>
                                                    <h4>هل تريد حذف جميع بيانات المورد ؟ </h4>
                                                </div>
                                                <div class="modal-footer info-md">
                                                    <a data-dismiss="modal" href="#">إلغــاء</a>
                                                    <form id="delete" style="display: inline;" action="{{ route('supplier.destroy', $row->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit">حذف</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/Delete Company-->
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