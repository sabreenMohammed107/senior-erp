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

    .fixed-table-container .no-records-found {
        display: none;
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

        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcome-menu">
            <li>
                <a href="#"></a> المخزن <span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> جرد المخزن</span>
            </li>
        </ul>
    </div>
</div>


@endsection

@section('content')
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <form action="{{route('stock-taking.store')}}" id="formid" method="post">
            @csrf
            <div class="mg-b-23">
                <button data-toggle="modal" data-target="#cancle" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">رجوع</button>
                <button data-toggle="modal" data-target="#confi" type="button" class="btn btn-primary waves-effect waves-light mg-b-15 isDisabled"> نهاية</button>

                <button data-toggle="modal" data-target="#save" type="button" class="btn btn-primary waves-effect waves-light mg-b-15 isDisabled">حـفـــــظ</button>
                <button data-toggle="modal" data-target="#start" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">بداية</button>

                <!--save Company-->
                <div id="start" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header header-color-modal bg-color-2">
                                <h4 class="modal-title" style="text-align:right">بداية الجرد</h4>
                                <div class="modal-close-area modal-close-df">
                                    <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                            <div class="modal-body">
                                <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>

                                <h4>هل تريد بداية الجرد ؟ </h4>
                            </div>
                            <div class="modal-footer info-md">
                                <a data-dismiss="modal" href="#">إلغــاء</a>

                                <button class="btn btn-primary waves-effect waves-light" name="action" value="start" onclick="document.getElementById('formid').submit();">حفظ</button>

                            </div>
                        </div>
                    </div>
                </div>
                <!--/save Company-->

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

                                <button class="btn btn-primary waves-effect waves-light" name="action" value="save" onclick="document.getElementById('formid').submit();">حفظ</button>

                            </div>
                        </div>
                    </div>
                </div>
                <!--/save Company-->
                <!--confi Company-->
                <div id="confi" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header header-color-modal bg-color-2">
                                <h4 class="modal-title" style="text-align:right"> تأكيد الحفظ</h4>
                                <div class="modal-close-area modal-close-df">
                                    <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                            <div class="modal-body">
                                <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>

                                <h4>هل تريد تأكيد حفظ البيانات ؟ </h4>
                            </div>
                            <div class="modal-footer info-md">
                                <a data-dismiss="modal" href="#">إلغــاء</a>
                                <button class="btn btn-primary waves-effect waves-light" name="action" value="confirm" onclick="document.getElementById('formid').submit();">حفظ</button>

                            </div>
                        </div>
                    </div>
                </div>
                <!--/conf Company-->

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

                                <a class="btn btn-primary waves-effect waves-light" href="{{route('stock-taking.index')}}">رجــــــوع</a>

                            </div>
                        </div>
                    </div>
                </div>
                <!--/cancle Company-->
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 style="direction:rtl">إضافة حركة جرد المخزن</h1><br />
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="form-group-inner" style="margin-right:10px;">
                                    <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                            <div class="row">
                                                <input type="hidden" value="{{$stock->id}}" name="stock_id">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" readonly value="{{$stock->code ?? ''}}" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>كود المخزن</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="date" name="taking_date" class="form-control" placeholder="" autofocus>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>تاريخ الجرد</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" name="taking_no" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>رقم الجرد</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <select id="person_id" name="person_id" data-placeholder="Choose a Country..." class="chosen-select">
                                                            <option value="">Select</option>

                                                            @foreach($persons as $person)
                                                            <option value="{{$person->id}}">{{$person->name}} / {{$person->code}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>كود الشخص</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input name="" value="{{$stock->ar_name ?? ''}}" type="text" class="form-control" placeholder="" style="text-align:right" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>إسم المخزن باللغة العربية</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>كود المسئول 1</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>كود المسئول 2</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                    <div class="input-mark-inner mg-b-22">
                                                        <input type="text" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="input-mask-title">
                                                        <label><b>كود المسئول 3</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h3 style="text-align:right">بيان الأصناف</h3>
                                <table class="table  table-bordered" id="table" style="direction:rtl;">
                                    <thead>
                                        <tr>
                                            <th data-field="index">#</th>
                                            <th>كود البند</th>
                                            <th>رقم الباتش</th>
                                            <th>تاريخ الصلاحية</th>
                                            <th>كمية البند</th>
                                            <th>كمية الجرد</th>
                                            <th>كمية الزياده</th>
                                            <th>تكلفة الزياده</th>
                                            <th>كمية العجز</th>
                                            <th>تكلفة العجز</th>
                                            <th>إسم المورد</th>

                                        </tr>
                                    </thead>
                                    <tbody id="rows">

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Static Table End -->
@endsection
@section('modal')

@endsection
@section('scripts')

<script>
    $(function() {
        $("#table th:nth-child(6) , #table td:nth-child(6)").hide();
        $("#table th:nth-child(7) , #table td:nth-child(7)").hide();
        $("#table th:nth-child(8) , #table td:nth-child(8)").hide();
        $("#table th:nth-child(9) , #table td:nth-child(9)").hide();
        $("#table th:nth-child(10) , #table td:nth-child(10)").hide();



        $('select[name="person_id"]').on('change', function() {

            var select_value = $(this).val();

            $.ajax({
                type: 'GET',
                data: {

                    person: select_value,
                    stock_id: '{{$stock->id ?? 0}}',

                },
                url: "{{route('stock-taking-selectValPerson.fetch')}}",
                success: function(data) {
                    $('#rows').html(data);

                },
                error: function(request, status, error) {

                }
            });


        });
    });
</script>
@endsection