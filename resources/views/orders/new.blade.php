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
				<a href="#"></a> المبيعات<span class="bread-slash"> / </span>
			</li>
			<li>
				<span class="bread-blod"> أوامر المبيعات </span>
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
                <form action="{{route('orders.store')}}" id="formid" method="post" >
                    @csrf
				<div class="mg-b-23">
					<div class="">

						<a href="{{route('orders.index')}}" class="btn btn-primary waves-effect waves-light">إلغاء</a>

						<button class="btn btn-primary waves-effect waves-light"  type="submit">حــفـظ</button>

					</div>
				</div>
				<input type="hidden" value="{{$branch->id ?? 0}}" name="branch" class="form-control" placeholder="">

				<div class="sparkline13-list">
					<div class="sparkline13-hd">
						<div class="main-sparkline13-hd">
							<h1 style="direction:rtl">إضافة أصناف أمر البيع</h1><br />
						</div>
					</div>
                     <div class="sparkline13-graph">
					<div class="datatable-dashv1-list custom-datatable-overright" style="direction:rtl">
						<div class="form-group-inner" style="margin-right:10px;">
							<div class="row" style="text-align:right !important;direction:rtl !important">
								<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 shadow">
									<div class="row">

										<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
											<div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
												<div class="input-mark-inner mg-b-22">
													<input type="text" value="{{$branch->ar_name ?? ''}}" readonly class="form-control" placeholder=" ">
												</div>
											</div>
											<div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
												<div class="input-mask-title">
													<label><b>إسم الفرع </b></label>
												</div>
											</div>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
											<div class="row">
												<div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
													<div class="input-mark-inner mg-b-22">
														<input type="text" readonly value="{{$branch->code ?? ''}}" class="form-control" placeholder=" ">
													</div>
												</div>
												<div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
													<div class="input-mask-title">
														<label><b> كود الفرع </b></label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">

										<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
											<div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
												<div class="input-mark-inner mg-b-22">
													<input type="text" readonly value="" id="marketMan" class="form-control" placeholder="">
												</div>
											</div>
											<div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
												<div class="input-mask-title">
													<label><b>مسئول التسويق</b></label>
												</div>
											</div>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
											<div class="row">
												<div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
													<div class="input-mark-inner mg-b-22">
														<input type="text" value="" id="marketCode" readonly class="form-control" placeholder="">
													</div>
												</div>
												<div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
													<div class="input-mask-title">
														<label><b>كود التسويق</b></label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
											<div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
												<div class="input-mark-inner mg-b-22">
													<input type="text" readonly value="" id="saleMan" class="form-control" placeholder="">
												</div>
											</div>
											<div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
												<div class="input-mask-title">
													<label><b>مسئول المبيعات</b></label>
												</div>
											</div>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
											<div class="row">
												<div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
													<div class="input-mark-inner mg-b-22">
														<input type="text" id="saleCode" readonly class="form-control" placeholder="">
													</div>
												</div>
												<div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
													<div class="input-mask-title">
														<label><b>كود المبيعات</b></label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
											<div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
												<div class="input-mark-inner mg-b-22">
													<input type="text" id="stock_name" readonly class="form-control" placeholder=" ">
												</div>
											</div>
											<div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
												<div class="input-mask-title">
													<label><b>إسم المخزن</b></label>
												</div>
											</div>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
											<div class="row">
												<div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
													<div class="input-mark-inner mg-b-22">
														<select id="stock_id" name="stock_id" data-placeholder="Choose a Country..." class="chosen-select" tabindex="-1">
															<option value="">Select</option>
															@foreach($stocks as $stock)
															<option value="{{$stock->STOCK_ID}}">{{$stock->STOCK_AR_NAME}} / {{$stock->STOCK_CODE}}</option>

															@endforeach
														</select>
														<input type="hidden" id="output" />
													</div>
												</div>
												<div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
													<div class="input-mask-title">
														<label><b>كود المخزن</b></label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
											<div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
												<div class="input-mark-inner mg-b-22">
													<input type="text" id="person_name" name="person_name" readonly class="form-control" placeholder="">
												</div>
											</div>
											<div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
												<div class="input-mask-title">
													<label><b>إسم العميل</b></label>
												</div>
											</div>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
											<div class="row">
												<div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
													<div class="input-mark-inner mg-b-22">
														<select id="person_id" name="person_id" data-placeholder="Choose a Country..." class="chosen-select" tabindex="-1">
															<option value="">Select</option>
															@foreach($persons as $person)
															<option value="{{$person->PERSON_ID}}">{{$person->PERSON_NAME}} / {{$person->PERSON_CODE}}</option>
															@endforeach

														</select> </div>
												</div>
												<div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
													<div class="input-mask-title">
														<label><b>كود العميل</b></label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
											<div class="col-lg-7 col-md-7 col-sm-9 col-xs-12">
												<div class="input-mark-inner mg-b-22">
													<input type="text" readonly class="form-control" placeholder="">
												</div>
											</div>
											<div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
												<div class="input-mask-title">
													<label><b>سعر التحويل</b></label>
												</div>
											</div>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
											<div class="row">
												<div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
													<div class="input-mark-inner mg-b-22">
														<select data-placeholder="Choose a Country..." class="chosen-select" tabindex="-1">
                                                            <option value="">Select</option>
                                                            @foreach($currencies as $cur)
                                                            <option value="{{$cur->CURRENCY_ID}}">{{$cur->CURRENCY_NAME}}</option>
															@endforeach
														</select> </div>
												</div>
												<div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
													<div class="input-mask-title">
														<label><b>كود العملة</b></label>
													</div>
												</div>
											</div>
										</div>
									</div>


								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 shadow">
									<div class="row">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<div class="input-mark-inner mg-b-22">
												<input type="date" id="order_delev" name="order_delev" class="form-control" placeholder="">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="input-mask-title">
												<label><b>تاريخ الإستلام</b></label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<div class="input-mark-inner mg-b-22">
												<input type="text" id="decOrder" name="decOrder" class="form-control" placeholder="" style="height:80px;margin-bottom:10px;">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="input-mask-title">
												<label><b>وصف أمر البيع</b></label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<div class="input-mark-inner mg-b-22">
												<input type="text" id="total_items_price" name="total_items_price" readonly class="form-control" placeholder="">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="input-mask-title">
												<label><b>قيمة أمرالبيع</b></label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<div class="input-mark-inner mg-b-22">
												<input type="number" id="total_items_discount" name="total_items_discount" readonly class="form-control" placeholder="">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="input-mask-title">
												<label><b>إجمالي الخصم</b></label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<div class="input-mark-inner mg-b-22">
												<input type="number" id="total_items_final" name="LOCAL_NET_INVOICE" readonly class="form-control" placeholder="">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="input-mask-title">
												<label><b>صافي القيمة</b></label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 shadow">
									<div class="row">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<div class="input-mark-inner mg-b-22">
												<input type="text" readonly class="form-control" placeholder="">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="input-mask-title">
												<label><b>رقم أمر البيع</b></label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<div class="input-mark-inner mg-b-22">
												<input type="date" id="order_date" name="order_date" class="form-control" placeholder="">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="input-mask-title">
												<label><b>تاريخ أمر البيع</b></label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<div class="input-mark-inner mg-b-22">
												<input type="text" readonly class="form-control" placeholder="">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="input-mask-title">
												<label><b>حالة أمرالبيع</b></label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<div class="input-mark-inner mg-b-22">
												<input type="text" class="form-control" readonly placeholder="">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="input-mask-title">
												<label><b>قرار أمرالبيع</b></label>
											</div>
										</div>
									</div>
									<div class="row">

										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

											<div class="input-mark-inner mg-b-22">
												<input type="text" class="form-control" name="notes" id="notes" placeholder="" style="height:80px;margin-bottom:10px;">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="input-mask-title">
												<label><b>ملاحظات</b></label>
											</div>
										</div>
									</div>

								</div>
							</div>

						</div>

						<h3 style="text-align:right">الأصناف</h3>
						<button id="add" onclick="addRow()" type="button" class="btn btn-primary waves-effect waves-light">إضافة صنف</button>
						<table class="table-striped" id="puchasetable" data-locale="ar-SA" data-pagination="true" data-pagination-pre-text="السابق" data-pagination-next-text="التالي" data-show-export="true" data-minimum-count-columns="2" data-page-list="[10, 25, 50, 100, all]" data-sort-name="index" data-sort-order="desc" data-search="true" style="direction:rtl" data-toggle="table" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="true" data-cookie="true" data-toolbar="#toolbar" data-show-toggle="true" data-show-fullscreen="true" data-show-columns-toggle-all="true">
							<thead>
								<tr>
									<th data-field="state" data-checkbox="true"></th>
									<th data-field="index">كود البند</th>
									<th>UOM</th>
									<th>إسم البند</th>
									<th>الباتش</th>
									<th> رقم الباتش</th>
									<th>تاريخ الصلاحية</th>
									<th>الكمية الحالية</th>
									<th>كمية الصنف</th>
									<th>سعر الصنف</th>
									<th>الإجمالي</th>
									<th>نسبة الخصم</th>
									<th>قيمة الخصم</th>
									<th>السعر النهائي</th>
									<th>ملاحظات</th>
									<th>حذف</th>
								</tr>
							</thead>
							<tbody id="rows">
							</tbody>



						</table>
					</div>
                </div>
</form>
			</div>
		</div>
	</div>
</div>
</div>
<!-- Static Table End -->

@endsection
@section('modal')

@endsection
@section('scripts')
<script>
    $('select[name="person_id"]').on('change', function() {

        var select_value = $(this).val();

$.ajax({
    type: 'GET',
    data: {

        select_value: select_value

    },
    url: "{{route('editSelectValPerson.fetch')}}",

    success: function(data) {
        var result = $.parseJSON(data);

        $("#saleCode").val(result[0]);
        $("#saleMan").val(result[1]);
        $("#marketCode").val(result[2]);
        $("#marketMan").val(result[3]);
        $("#person_name").val($('#person_id option:selected').text());
      
    },
    error: function(request, status, error) {

        $("#saleCode").val('');
        $("#saleMan").val('');
        $("#marketCode").val('');
        $("#marketMan").val('');
        $("#person_name").val($('#person_id option:selected').text());
      
    }
});


});



	$('select[name="stock_id"]').on('change', function() {

		index = $('#puchasetable > tbody > tr').length;

		if (index > 1) {

			$('#rows').html('');
		}
        $("#stock_name").val($('#stock_id option:selected').text());


	});
	$('#formid').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	function addRow(url) {
		index = $('#puchasetable > tbody > tr').length;
		stock_id = $('#stock_id option:selected').val();
		var rowCount = $('#puchasetable > tbody > tr').length;
		$.ajax({
			type: 'GET',
			data: {
				rowcount: rowCount,
				stock: stock_id


			},
			url: "{{url('addRow/fetch')}}",

			success: function(data) {

				$('#rows').append(data);
				$('#puchasetable > tbody > tr').last().find('input').first().focus();
				$('#select' + index).select2();

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
	//Start row functions
	function deleteRow(index) {
		$('tr[data-id=' + index + ']').remove();
		var trs = $('#puchasetable > tbody').html();
		$('#puchasetable').bootstrapTable('destroy');
		$('#rows').html(trs);
		console.log(trs);
        console.log(index);
		$('#puchasetable').bootstrapTable();
		headCalculations(index);
	}

	function editSelectVal(index) {
		debugger;

		var select_value = $('#select' + index + ' option:selected').val();


		$.ajax({
			type: 'GET',
			data: {

				select_value: select_value

			},
			url: "{{route('editSelectVal.fetch')}}",

			success: function(data) {
				var result = $.parseJSON(data);

				$("#ar_name" + index + "").text(result[0]);
				$("#uom" + index + "").text(result[1]);
				$("#selectBatch" + index + "").html(result[2]);
				$('#selectBatch' + index).select2();
				headCalculations(index);

			},
			error: function(request, status, error) {

				$("#uom" + index + "").text(' ');
				$("#ar_name" + index + "").text(' ');
				console.log(request.responseText);
			}
		});


	}

	function editSelectBatch(index) {
		debugger;

		var select_value = $('#selectBatch' + index + ' option:selected').val();

		var person = $('#person_id option:selected').val();
		alert(person);
		$.ajax({
			type: 'GET',
			data: {

				select_value: select_value,
				person: person

			},
			url: "{{route('editSelectBatch.fetch')}}",

			success: function(data) {
				var result = $.parseJSON(data);

				$("#batchNum" + index + "").text(result[0]);
				$("#batchDate" + index + "").text(result[1]);
				$("#batchqty" + index + "").text(result[2]);
				$("#itemprice" + index + "").val(result[3]);
				headCalculations(index);


			},
			error: function(request, status, error) {

				$("#batchNum" + index + "").text('');
				$("#batchDate" + index + "").text('');
				$("#batchqty" + index + "").text('');
				console.log(request.responseText);
			}
		});


	}

	function itemPrice(index) {
		var price = $("#itemprice" + index + "").val();
		var qty = $("#qty" + index + "").val();
		var per = $("#per" + index + "").val();

		$("#total" + index + "").text(price * qty);
		var Amount = (price * qty) * per;
		$("#disval" + index).attr('value', Amount);
		var disval = $("#disval" + index + "").val();
		$("#final" + index + "").text((price * qty) - disval);
		headCalculations(index);
		$("#itemprice" + index).attr('value', price);
	}

	function disPer(index) {
		var price = $("#itemprice" + index + "").val();
		var qty = $("#qty" + index + "").val();
		var per = $("#per" + index + "").val();

		$("#total" + index + "").text(price * qty);
		var Amount = (price * qty) * per;
		$("#disval" + index).attr('value', Amount);
		var disval = $("#disval" + index + "").val();
		$("#final" + index + "").text((price * qty) - disval);
		headCalculations(index);
		$("#per" + index).attr('value', per);
	}

	function disval(index) {
		var price = $("#itemprice" + index + "").val();
		var qty = $("#qty" + index + "").val();
		var disval = $("#disval" + index + "").val();

		$("#total" + index + "").text(price * qty);
		var cc = disval / (price * qty);

		$("#per" + index).val(cc);
		$("#final" + index + "").text((price * qty) - disval);
		headCalculations(index);
		$("#disval" + index).attr('value', disval);

	}

	function itemQty(index) {
		var price = $("#itemprice" + index + "").val();
		var qty = $("#qty" + index + "").val();
		var per = $("#per" + index + "").val();

		$("#total" + index + "").text(price * qty);
		var Amount = (price * qty) * per;
		$("#disval" + index).attr('value', Amount);
		var disval = $("#disval" + index + "").val();

		$("#final" + index + "").text((price * qty) - disval);
		headCalculations(index);


		$("#qty" + index).attr('value', qty);
	}
	

	// headCalculations(index);
	function headCalculations(index) {
		index = $('#puchasetable > tbody > tr').length;
		var total = 0;
		var discount = 0;
		var final = 0;


		$('#puchasetable > tbody  > tr').each(function() {

			var temp = $('#total' + index).text();

			var temp2 = $('#disval' + index).val();
			var temp3 = $('#final' + index).text();
			if (temp) {
				total += parseFloat($('#total' + index).text());


			}

			if (temp2) {
				discount += parseFloat($('#disval' + index).val());
			}
			if (temp3) {
				final += parseFloat($('#final' + index).text());


			}
			--index;
		})
		console.log(total);
		console.log(discount);
		$('#total_items_price').val(total.toFixed(2));
		$('#total_items_discount').val(discount.toFixed(2));
		$('#total_items_final').val(final.toFixed(2));
	

	}




</script>
@endsection