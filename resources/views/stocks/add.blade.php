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
												<a href="#"></a> المخازن<span class="bread-slash"> / </span>
											</li>
											<li>
												<span class="bread-blod">   أضافة مخزن </span>
											</li>
										</ul>
									</div>
								</div>
						

@endsection

@section('content')
<!-- Single pro tab review Start-->
<div class="single-pro-review-area mt-t-30 mg-b-15">
			<div class="container-fluid">
            <form action="{{route('stocks.store')}}" method="POST">
                                            @csrf
            <a href="{{route('stocks.index')}}" class="btn btn-primary waves-effect waves-light">إلغاء</a>

<button class="btn btn-primary waves-effect waves-light" type="submit">حــفـظ</button>
<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="sparkline13-list">
							<div class="sparkline13-hd">
								<div class="main-sparkline13-hd">
									<h1 style="direction:rtl">بيانات المخزن</h1><br />
								</div>
							</div>
							<div class="sparkline13-graph">
								<div class="datatable-dashv1-list custom-datatable-overright">
									<div class="form-group-inner" style="margin-right:10px;">
                                        <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
                                      
                                            <input type="hidden" name="branch_id" value="{{$branch->id}}" >
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">
												<div class="form-group">
													<label class="">كود المخزن</label>
													<input name="code" type="text" class="form-control" placeholder="كود المخزن" disabled >
												</div>
												<div class="form-group">
													<label class="">إسم المخزن باللغة العربية</label>
													<input name="ar_name" type="text" class="form-control" placeholder="إسم المخزن باللغة العربية">
												</div>
												<div class="form-group">
													<label class="">إسم المخزن باللغة الإنجليزية</label>
													<input name="en_name" type="text" class="form-control" placeholder="إسم المخزن باللغة الإنجليزية">
												</div>
												<div class="form-group">
													<div class="chosen-select-single mg-b-20">
														<label><b> أمين المخزن</b> </label>
														<input name="RESPONSIBLE_EMP_ID" type="text" class="form-control" placeholder=" أمين المخزن">
													</div>
												</div>
												<!-- <div class="form-group">
													<label class="">موظف المخزن</label>
													<input name="" type="text" class="form-control" placeholder="موظف المخزن">
												</div> -->
												
											</div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="direction:rtl">
                                            <div class="form-group">
													<label class="">كود الفرع</label>
													<input name="" type="text" value="{{$branch->code}}" readonly class="form-control" placeholder="كود الفرع">
												</div>
												<div class="form-group">
													<label class="">إسم الفرع</label>
													<input name="" value="{{$branch->ar_name}}" readonly type="text" class="form-control" placeholder="إسم الفرع">
												</div>
												<!-- <div class="form-group">
													<label class="">أخر تاريخ لرصيد المخزن</label>
													<input name="" type="date" class="form-control" placeholder="تاريخ رصيد العميل" style="text-align:right">
												</div> -->
												<div class="form-group">
											<div class="chosen-select-single mg-b-20">
												<label> <span style="color:red" > * </span>رقم الحساب </label>
												<select data-placeholder="Choose a charts..."  name="gl_item_id" required class="chosen-select" >
													<option value="">Select</option>
													@foreach($charts as $type)
													<option value="{{$type->id}}">{{$type->code}} - {{$type->ar_name}}</option>
													@endforeach
												</select>
											</div>
										</div>
											
												<div class="form-group">
													<label class="">ملاحظات</label>
													<textarea name="notes" placeholder="ملاحظات" style="max-height:50px"></textarea>
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

@endsection
@section('modal')

@endsection
@section('scripts')
<script>
$(document).ready(function(){
	$('select').chosen();
    $('form').validate();
});
</script>
@endsection