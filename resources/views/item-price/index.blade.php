@extends('Layout.web')



@section('crumb')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="#"></a> الأصناف<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod">  أسعار الأصناف </span>
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
    <a href="{{ route('item-price.create') }}" title="New" class="btn btn-primary waves-effect waves-light mg-b-15">إضافة سعر </a>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 style="direction:rtl">أسعار الاصناف</h1>
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright" style="direction:rtl">

                            <table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true"
                             data-show-refresh="true" data-key-events="true" data-resizable="true" data-cookie="true" 
                             data-cookie-id-table="saveId" data-show-export="true" data-ajaxed="false" data-click-to-select="true" 
                             data-toolbar="#toolbar">
                                <thead>
                                <tr>
												<th data-field="state"></th>
												<th data-field="id">كــود</th>
												<th>نوع الصنف</th>
												<th>إسم الصنف</th>
												<th>كود تصنيف العميل</th>
												<th>إسم تصنيف العميل</th>
												<th>كود العميل</th>
												<th>إسم العميل</th>
												<th>سعر الصنف</th>
												<th>الاختيارات</th>
											</tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $index=>$row)
                                    <tr>
                                        <td></td>
                                        <td>{{$index+1}}</td>

                                        <td>{{$row->priceType->ar_name}}</td>
                                        <td>{{$row->item->ar_name ?? ''}}</td>

                                        <td>{{$row->category->code ?? ''}}</td>
                                        <td>{{$row->category->ar_name ?? ''}}</td>
                                        <td>{{$row->client->code ?? ''}}</td>
                                        <td>{{$row->client->name ?? ''}}</td>
                                        <td>{{$row->item_price}}</td>
                                     
                                        <td>
                                            <div class="product-buttons">
                                                <a href="{{ route('item-price.show',$row->item_id)}}"><button title="View" class="pd-setting-ed"><i class="fa fa-file" aria-hidden="true"></i></button></a>
                                                <a href="{{ route('item-price.edit',$row->item_id)}}"><button title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
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