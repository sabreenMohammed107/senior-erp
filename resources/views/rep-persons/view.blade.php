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
                <a href="#"></a> المناديب<span class="bread-slash"> / </span>
            </li>
            <li>
                <span class="bread-blod"> أضافة مندوب </span>
            </li>
        </ul>
    </div>
</div>


@endsection

@section('content')
<!-- Single pro tab review Start-->
<div class="single-pro-review-area mt-t-30 mg-b-15">
    <div class="container-fluid">
       
            <a href="{{route('rep-persons.index')}}" class="btn btn-primary waves-effect waves-light mg-b-15">رجوع</a>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 style="direction:rtl">بيانات المندوب</h1><br />
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="form-group-inner" style="margin-right:10px;">
                                    <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="direction:rtl">
                                            <div class="form-group">
                                                <label class="">كود المندوب</label>
                                                <input name="" value="{{$row->code}}" readonly type="text" class="form-control" placeholder="" style="text-align:right">
                                            </div>
                                            <div class="form-group">
                                                <label class="">إسم المندوب باللغة العربية</label>
                                                <input name="ar_name" readonly value="{{$row->ar_name}}" type="text" class="form-control" placeholder="" style="text-align:right">
                                            </div>
                                            <div class="form-group">
                                                <label class="">إسم المندوب باللغة الإنجليزية</label>
                                                <input name="en_name" readonly value="{{$row->en_name}}" type="text" class="form-control" style="text-align:right">
                                            </div>
                                            <div class="form-group">
                                                <label class="">موبايل المندوب</label>
                                                <input name="mobile" readonly value="{{$row->mobile}}" type="text" class="form-control" style="text-align:right">
                                            </div>

                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="direction:rtl">

                                            <div class="form-group">
                                                <label class="">كود الفرع</label>
                                                <input type="hidden" name="branch_id" value="{{$branch->id}}">
                                                <input name="" readonly value="{{$branch->code ?? ''}} / {{$branch->ar_name ?? ''}}" type="text" class="form-control" style="text-align:right">
                                            </div>
                                            <div class="form-group">
                                                <label class="">نوع المندوب</label>
                                                <select data-placeholder="Choose a Country..." disabled name="rep_type_id" class="chosen-select">
                                                    <option value="">Select</option>
                                                    @foreach($types as $type)
                                                    <option @if ($row->rep_type_id == $type->id)
                                                        selected="selected"
                                                        @endif
                                                        value="{{$type->id}}">{{$type->ar_name}}</option>

                                                    @endforeach
                                                </select>
                                            </div>

                                           
                                        </div>
                                    </div>
    </div>
</div>



@endsection
@section('modal')

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('select').chosen({
            search_contains: true
        });

    });
</script>
@endsection