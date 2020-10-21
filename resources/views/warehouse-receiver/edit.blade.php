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

		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<ul class="breadcome-menu">
			<li>
				<a href="#"></a> المخزن <span class="bread-slash"> / </span>
			</li>
			<li>
				<span class="bread-blod">حركات المخزن</span>
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
            <form action="{{route('warehouse-receiver.update',$row->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
					<div class="mg-b-23">
						<button data-toggle="modal" data-target="#cancle" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">رجوع</button>

						<button data-toggle="modal" data-target="#save" type="button" class="btn btn-primary waves-effect waves-light mg-b-15">حـفـــــظ</button>
						<button data-toggle="modal" data-target="#confi" type="button" class="btn btn-primary waves-effect waves-light mg-b-15"> الموافقة</button>

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

										<button class="btn btn-primary waves-effect waves-light" name="action" value="save" onclick="document.getElementById('form-id').submit();">حفظ</button>

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
										<h4 class="modal-title" style="text-align:right">تأكيد الحفظ البيانات</h4>
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
										<button class="btn btn-primary waves-effect waves-light" name="action" value="confirm" onclick="document.getElementById('form-id').submit();">حفظ</button>

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

										<a class="btn btn-primary waves-effect waves-light" href="{{route('warehouse-receiver.index')}}">رجــــــوع</a>

									</div>
								</div>
							</div>
						</div>
						<!--/cancle Company-->
					</div>
					<div class="sparkline13-list">
						<div class="sparkline13-hd">
							<div class="main-sparkline13-hd">
								<h1 style="direction:rtl">بيان حركة المخزن</h1><br />
							</div>
						</div>
						<div class="sparkline13-graph">
							<div class="datatable-dashv1-list custom-datatable-overright">
								<div class="form-group-inner" style="margin-right:10px;">
									<div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
											<div class="row">
												<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
													<div class="input-mark-inner mg-b-22">
														<input type="text" value="{{$row->code}}" class="form-control" placeholder=""  readonly>
													</div>
												</div>
												<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
													<div class="input-mask-title">
														<label><b>كود الحركة</b></label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
													<div class="input-mark-inner mg-b-22">
                                                    <?php
															$date2 = null;
															$date2 = date_create($row->transaction_date) ?>
														<input type="date" value="{{date_format($date2,"Y-m-d") }}" name="transaction_date" class="form-control" placeholder="">
													</div>
												</div>
												<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
													<div class="input-mask-title">
														<label><b>تاريخ الحركة</b></label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
													<div class="bt-df-checkbox" style="direction:rtl">
                                                    <input class="radio-checked" type="radio" disabled @if(!$row->order_id) checked="" @endif value="general" id="optionsRadios1" name="optionsRadios">
														<label><b> عام </b></label>
														<input class="" type="radio" value="order" disabled @if($row->order_id) checked="" @endif  id="optionsRadios2" name="optionsRadios">
														<label><b> أمر مشتريات </b></label>
													</div>
												</div>
												<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
													<div class="input-mask-title">
														<label><b>نوع المرجع</b></label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
													<div class="input-mark-inner mg-b-22">
														<textarea name="notes" class="form-control" placeholder="">{{$row->notes}}</textarea>
													</div>
												</div>
												<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
													<div class="input-mask-title">
														<label><b>ملاحظات</b></label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
											<div class="row">
												<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
													<div class="input-mark-inner mg-b-22">
														<select id="person_id" name="person_id" disabled data-placeholder="Choose a Country..." class="chosen-select">
															@foreach($persons as $person)
															<option @if ($row->person_id == $person->id)
                                                                        selected="selected"
                                                                        @endif value="{{$person->id}}">{{$person->name}} / {{$person->code}}</option>
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
											<div class="row">
												<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
													<div class="input-mark-inner mg-b-22">
														<input type="text" id="person_name" value="{{$persons[0]->name ?? ''}}" name="person_name" readonly class="form-control" placeholder="">
													</div>
												</div>
												<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
													<div class="input-mask-title">
														<label><b>إسم الشخص</b></label>
													</div>
												</div>
											</div>
											<div @if(!$row->order_id) style="display:none" @endif  class="row">
												<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
													<div class="input-mark-inner mg-b-22">
														<select data-placeholder="Choose a Country..." disabled id="purchOrder" name="purchOrder" class="chosen-select">

                                                            @foreach($orders as $order)
                                                            <?php
															$date = null;
															$date = date_create($order->order_date) ?>
															<option @if ($row->order_id == $order->id)
                                                                        selected="selected"
                                                                        @endif  value="{{$order->id}}">{{date_format($date,"Y-m-d") }} / {{$order->purch_order_no}}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
													<div class="input-mask-title">
														<label><b>كود الطلب</b></label>
													</div>
												</div>
											</div>
										
										</div>
									</div>
								</div>
								<div class="row res-rtl" style="display: flex ">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow">
										<h3 style="text-align:right">الأصناف</h3>
										<button id="add" type="button" class="btn btn-primary waves-effect waves-light mg-b-15" style="float: left;">إضافة صنف</button>
										<input type="text" id="myInput" placeholder="إبحث  الصنف ..">
									</div>
								</div>
								<div style="overflow-x:auto;">


									<table class="table  table-bordered" id="table" style="direction:rtl;">
										<thead>
											<tr>
												<th data-field="state"></th>
												<th data-field="id">كود البند</th>
												<th>إسم البند</th>
												<th>UOM</th>
												<th>رقم الباتش</th>
												<th>تاريخ الصلاحية</th>
												<th>كمية البند</th>
												<th>ملاحظات</th>
												<th>حذف</th>
											</tr>
										</thead>
										<tbody id="rows">
											@include('warehouse-receiver.editAjax')
										</tbody>

									</table>
								</div>

							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Static Table End -->


@endsection
@section('scripts')

<script>
	$(function() {
		debugger;


		$('#add').on('click', function() {
			var rowCount = 0;

			if ($('#table > tbody  > tr').attr('data-id')) {
				rowCount = $('#table > tbody  > tr:last').attr('data-id');
			}

			order = $('#purchOrder option:selected').val();
			person = $('#person_id option:selected').val();
			var rowSS = parseFloat(rowCount) + 1;


			$.ajax({
				type: 'GET',
				async: false,
				data: {
					rowCount: parseFloat(rowCount) + 1,
					order: order,
					person: person

				},
				url: "{{url('addRow-warehouse-receiver/fetch')}}",

				success: function(data) {

					$('#rows').append(data);
					$("#select" + rowSS).select2();
					$('#firstTT' + rowSS).focus();
					console.log(rowSS);
				},

				error: function(request, status, error) {
					console.log(request.responseText);
				}
			});


		})

		//filter
		$("#myInput").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#table > tbody > tr").filter(function() {
				var row_num = $(this).attr('data-id');
				$(this).toggle(
					$('#item_search' + row_num).text().toLowerCase().indexOf(value) > -1


				);
			});

		});

	})
	$('select[name="purchOrder"]').on('change', function() {

		var select_value = $(this).val();

		$.ajax({
			type: 'GET',
			data: {

				select_value: select_value

			},
			url: "{{route('editSelectpurchOrder.fetch')}}",

			success: function(data) {
				$('#rows').append(data);
				$("#select" + rowSS).select2();
				$('#firstTT' + rowSS).focus();
			}
		});


	});



	$('select[name="person_id"]').on('change', function() {

		index = $('#table > tbody > tr').length;
		if (index > 0) {

			$('#rows').html('');
		}
		$("#person_name").val($('#person_id option:selected').text());


	});
	$('#form-id').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

	function addRow(url) {
		var rowCount = 0;

		if ($('#table > tbody  > tr').attr('data-id')) {
			rowCount = $('#table > tbody  > tr:last').attr('data-id');
		}

		order = $('#purchOrder option:selected').val();
		person = $('#person_id option:selected').val();
		var rowSS = parseFloat(rowCount) + 1;


		$.ajax({
			type: 'GET',
			async: false,
			data: {
				rowCount: parseFloat(rowCount) + 1,
				order: order,
				person: person

			},
			url: "{{url('addRow-warehouse-receiver/fetch')}}",

			success: function(data) {

				$('#rows').append(data);
				$("#select" + rowSS).select2();
				$('#firstTT' + rowSS).focus();
				console.log(rowSS);
			},

			error: function(request, status, error) {
				console.log(request.responseText);
			}
		});

	}

	function enterForRow(e, index) {
		if (e.keyCode == 13) {
			addRow();

		}
	}


	function deleteRow(index) {
		//delete Row

		$('tr[data-id=' + index + ']').remove();


	}

	function editSelectVal(index) {
		debugger;

		var select_value = $('#select' + index + ' option:selected').val();
		var text = $('#select' + index + ' option:selected').text();
		var select_stock = $('#stock_id option:selected').val();

		$.ajax({
			type: 'GET',
			data: {

				select_value: select_value,
				select_stock: select_stock

			},
			url: "{{route('editSelectVal-warehouse-receiver.fetch')}}",

			success: function(data) {
				var result = $.parseJSON(data);
				$("#ar_name" + index + "").text(result[0]);
				$("#uom" + index + "").text(result[1]);

			},
			error: function(request, status, error) {

				$("#uom" + index + "").text(' ');
				$("#ar_name" + index + "").text(' ');
				console.log(request.responseText);
			}
		});
		$('#item_search' + index).text(text);

	}

    function DeletethisItem(id,index) {
		debugger;
		$("#del" + index).modal('hide');
		$('.modal-backdrop.fade.in').remove();
		$('.modal-open').css('overflow-y', 'scroll');
		$.ajax({
			type: 'GET',
			url: "{{url('/warehouse-receiver/Remove-virtual/Item')}}",
			data: {
				id: id,
				order : $('#purchOrder option:selected').val(),
			},
			success: function(data) {

				location.reload(true);
			},
			error: function(request, status, error) {
				console.log(request.responseText);
			}
		});
	}
</script>
@endsection