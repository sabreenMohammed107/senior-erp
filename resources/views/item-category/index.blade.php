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
            <div class="add-product">
                <a data-toggle="modal" data-target="#add" href="#" style="direction:ltr;margin-top:-20px">إضافة تصنيف</a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="#"></a> التصنيف<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> تصنيفات الأصناف </span>
            </li>
        </ul>
    </div>
</div>

@endsection

@section('content')
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 style="direction:rtl">التصنيفات</h1>
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright" style="direction:rtl">

                            <table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="false"></th>
                                        <th>كــود تصـنيف الصنف</th>
                                        <th>إسم التصنيف باللغة العربية</th>
                                        <th>إسم التصنيف باللغة الإنجليزية</th>
                                        <th>وصف التصنيف باللغة العربية</th>
                                        <th>وصف التصنيف باللغة العربية</th>
                                        <th>الاختيارات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $index=>$row)
                                    <tr>
                                        <td></td>
                                        <td>{{$row->code}}</td>
                                        <td>{{$row->ar_name}}</td>
                                        <td> {{$row->en_name}}</td>
                                        <td> {{$row->ar_description}}</td>
                                        <td>{{$row->en_description}} </td>
                                        <td>
                                            <div class="product-buttons">
                                                <a href="{{ route('item-category.show',$row->id)}}"><button title="View" class="pd-setting-ed"><i class="fa fa-file" aria-hidden="true"></i></button></a>
                                                <a href="{{ route('item-category.edit',$row->id)}}"><button title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
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
                                                    <h4>هل تريد حذف جميع بيانات التصنيف  والتصنيفات الداخلية؟ </h4>
                                                </div>
                                                <div class="modal-footer info-md">
                                                    <a data-dismiss="modal" href="#">إلغــاء</a>
                                                    <form id="delete" style="display: inline;" action="{{ route('item-category.destroy', $row->id) }}" method="POST">
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
@section('modal')
<!--Add-->
<div id="add" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-color-modal bg-color-2">
                <h4 class="modal-title" style="text-align:right">إضافة تصنيف جديد</h4>
                <div class="modal-close-area modal-close-df">
                    <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                </div>
            </div>
            <form action="{{route('item-category.store')}}" method="POST" class="dropzone dropzone-custom needsclick addcourse" id="demo1-upload">

                @csrf
                <div class="modal-body">
                    <div class="message-content" style="text-align:right;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="review-content-section">
                                <div id="dropzone1" class="pro-ad addcoursepro">

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="direction:rtl">
                                            <!-- <div class="form-group">
														<label class="">كود التصنيف للبند</label>
														<input name="" type="text" class="form-control" placeholder="" style="text-align:right" >
													</div> -->
                                            <div class="form-group">
                                                <label class="">إسم التصنيف باللغة العربية</label>
                                                <input name="ar_name" type="text" class="form-control" placeholder="" style="text-align:right">
                                            </div>
                                            <div class="form-group">
                                                <label class="">إسم التصنيف باللغة الإنجليزية</label>
                                                <input name="en_name" type="text" class="form-control" style="text-align:right">
                                            </div>
                                            <div class="form-group">
                                                <label class="">وصف التصنيف باللغة العربية</label>
                                                <input name="ar_description" type="text" class="form-control" placeholder="" style="text-align:right">
                                            </div>
                                            <div class="form-group">
                                                <label class="">وصف التصنيف باللغة الانجليزية</label>
                                                <input name="en_description" type="text" class="form-control" style="text-align:right">
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer info-md">
                    <a data-dismiss="modal" href="#">إلغــاء</a>
                    <button type="submit">إضافة التصنيف</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!--/Add-->
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