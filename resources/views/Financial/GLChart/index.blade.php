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
				<input type="text" placeholder="...إبحث هنا" class="search-int form-control" style="text-align:right">
				<a href="#"><i class="fa fa-search"></i></a>
			</form>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<ul class="breadcome-menu">
			<li>
				<a href="#"></a> الاعدادات<span class="bread-slash"> / </span>
			</li>
			<li>
				<span class="bread-blod"> شجرة الحسابات </span>
			</li>
		</ul>
	</div>
</div>

@endsection
@section('content')
		<!-- Static Table Start -->
		<div class="data-table-area mg-b-15">
			<div class="container-fluid">
				<form method="get">
					<input type="hidden" id="id" name="id" class="form-control" placeholder="">
					<button formaction="{{url('/Financial/GLChart/Edit')}}" class="btn btn-primary waves-effect waves-light mg-b-15">تعديل</button>
					<button formaction="{{url('/Financial/GLChart/Add')}}" class="btn btn-primary waves-effect waves-light mg-b-15">إضافة</button>
				</form>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="sparkline13-list">
							<div class="sparkline13-hd">
								<div class="main-sparkline13-hd">
									<h1 style="direction:rtl">البيانات</h1><br />
								</div>
							</div>
							<div class="sparkline13-graph">
								<div class="datatable-dashv1-list custom-datatable-overright">
									<div class="form-group-inner" style="margin-right:10px;">
										<div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
											
											<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg-b-22">
												<div class="row">
													<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
														<div class="input-mark-inner mg-b-22">
															<input type="text" id="code" readonly class="form-control" placeholder=""autofocus>
															
														</div>
													</div>
													<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
														<div class="input-mask-title">
															<label><b>كود الحساب</b></label>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
														<div class="input-mark-inner mg-b-22">
															<input type="text" id="ar_name" readonly class="form-control" placeholder="">
														</div>
													</div>
													<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
														<div class="input-mask-title">
															<label><b>إسم الحساب باللغة العربية</b></label>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
														<div class="input-mark-inner mg-b-22">
															<input type="text" id="en_name" readonly class="form-control" placeholder="">
														</div>
													</div>
													<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
														<div class="input-mask-title">
															<label><b>إسم الحساب باللغة الإنجليزية</b></label>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
														<div class="input-mark-inner mg-b-22">
															<input type="text" id="parent_id" readonly class="form-control" placeholder="">
															{{-- <select id="gl_parent" data-placeholder="Choose a Country..." disabled class="chosen-select">
																<option value="">Select</option>
																<option value="United States">United States</option>
																<option value="United Kingdom">United Kingdom</option>
																<option value="Afghanistan">Afghanistan</option>
																<option value="Aland Islands">Aland Islands</option>
																<option value="Albania">Albania</option>
																<option value="Algeria">Algeria</option>
																<option value="American Samoa">American Samoa</option>
																<option value="Andorra">Andorra</option>
																<option value="Angola">Angola</option>
																<option value="Anguilla">Anguilla</option>
																<option value="Antarctica">Antarctica</option>
																<option value="Antigua and Barbuda">Antigua and Barbuda</option>
																<option value="Argentina">Argentina</option>
																<option value="Armenia">Armenia</option>
																<option value="Aruba">Aruba</option>
																<option value="Australia">Australia</option>
															</select> --}}
														</div>
													</div>
													<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
														<div class="input-mask-title">
															<label><b>كود الحساب الرئيسي</b></label>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
														<div class="input-mark-inner mg-b-22">
															<input type="text" id="level" readonly class="form-control" placeholder="">
														</div>
													</div>
													<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
														<div class="input-mask-title">
															<label><b>مستوي الحساب</b></label>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
														<div class="input-mark-inner mg-b-22">
															<input type="text" id="open" readonly class="form-control" placeholder="">
														</div>
													</div>
													<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
														<div class="input-mask-title">
															<label><b>الرصيد الإفتتاحى</b></label>
														</div>
													</div>
												</div>
											
												<div class="row">
													<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
														<div class="input-mark-inner mg-b-22">
															<input type="date" id="date" value="" readonly class="form-control" placeholder="">
														</div>
													</div>
													<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
														<div class="input-mask-title">
															<label><b>تاريخ بداية الترصيد</b></label>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
														<div class="" style="direction:rtl">
															{{-- <input class="radio-checked" type="radio" value="0" checked="" id="debit" disabled name="optionsRadios1">
															<label><b> مدين </b></label>
															<input class="" type="radio" value="1" id="credit" disabled name="optionsRadios1">
															<label><b> دائن </b></label> --}}
															<label id="btype"></label>
														</div>
													</div>
													<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
														<div class="input-mask-title">
															<label><b>  نوع الحساب</b></label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mg-b-22"></div>
											
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b-22">
												<div class="dx-viewport">
													<div class="demo-container">
														<div id="treeview"></div>
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
		<!-- Static Table End -->

		<!--Delete-->
		<div id="del" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header header-color-modal bg-color-2">
						<h4 class="modal-title" style="text-align:right">حذف بيانات الفاتورة</h4>
						<div class="modal-close-area modal-close-df">
							<a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
						</div>
					</div>
					<div class="modal-body">
						<span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
						<h2>كود الفاتورة</h2>
						<h4>هل تريد حذف جميع بيانات الفاتورة ؟  </h4>
					</div>
					<div class="modal-footer info-md">
						<a data-dismiss="modal" href="#">إلغــاء</a>
						<a href="#">حـذف</a>
					</div>
				</div>
			</div>
		</div>
		<!--/Delete-->
		<!--Back-->
		<div id="bk" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header header-color-modal bg-color-2">
						<h4 class="modal-title" style="text-align:right">رجوع</h4>
						<div class="modal-close-area modal-close-df">
							<a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
						</div>
					</div>
					<div class="modal-body">
						<span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
						<h2>كود الفاتورة</h2>
						<h4>هل تريد الرجوع من بيانات الفاتورة ؟  </h4>
					</div>
					<div class="modal-footer info-md">
						<a data-dismiss="modal" href="#">إلغــاء</a>
						<a href="#">رجوع</a>
					</div>
				</div>
			</div>
		</div>
		<!--/Back-->
		<!--Cancel-->
		<div id="cl" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header header-color-modal bg-color-2">
						<h4 class="modal-title" style="text-align:right">الغاء بيانات الفاتورة</h4>
						<div class="modal-close-area modal-close-df">
							<a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
						</div>
					</div>
					<div class="modal-body">
						<span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
						<h2>كود الفاتورة</h2>
						<h4>هل تريد الغاء جميع بيانات الفاتورة ؟  </h4>
					</div>
					<div class="modal-footer info-md">
						<a data-dismiss="modal" href="#">إلغــاء</a>
						<a href="#">موافق</a>
					</div>
				</div>
			</div>
		</div>
		<!--/Cancel-->
		<!--Delete-->
		<div id="sv" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header header-color-modal bg-color-2">
						<h4 class="modal-title" style="text-align:right">حفظ بيانات الفاتورة</h4>
						<div class="modal-close-area modal-close-df">
							<a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
						</div>
					</div>
					<div class="modal-body">
						<span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
						<h2>كود الفاتورة</h2>
						<h4>هل تريد حفظ جميع بيانات الفاتورة ؟  </h4>
					</div>
					<div class="modal-footer info-md">
						<a data-dismiss="modal" href="#">إلغــاء</a>
						<a href="#">حــفــظ</a>
					</div>
				</div>
			</div>
		</div>
		<!--/Delete-->
		<!--Delete-->
		<div id="cn" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header header-color-modal bg-color-2">
						<h4 class="modal-title" style="text-align:right">تأكيد بيانات الفاتورة</h4>
						<div class="modal-close-area modal-close-df">
							<a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
						</div>
					</div>
					<div class="modal-body">
						<span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
						<h2>كود الفاتورة</h2>
						<h4>هل تريد تأكيد جميع بيانات الفاتورة ؟  </h4>
					</div>
					<div class="modal-footer info-md">
						<a data-dismiss="modal" href="#">إلغــاء</a>
						<a href="#">تأكيد</a>
					</div>
				</div>
			</div>
		</div>
		<!--/Delete-->
	</div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>
	<link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css" />
	<link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css" />
	<script src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
	<script src="data.js"></script>
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<script src="index.js"></script>
	<script>
		$(function () {
			$.ajax({
				url: "{{url('/Financial/GLChart/Fetch')}}",
				method: 'GET',
				success:function(data){
					var items_array = data;
					var products = [{
						id: "0",
						text: "شجرة الحسابات",
						expanded: true,
						items: items_array,
					}];
					var treeView = $("#treeview").dxTreeView({
						items: products,
						width: 400,
						searchEnabled: true,
						onItemClick: function(e){
							console.log(e.itemData);
							var Data = e.itemData;
							$('#code').val(Data.code);
							$('#id').val(Data.id);
							$('#ar_name').val(Data.ar_name);
							$('#en_name').val(Data.en_name);
							$('#parent_id').val(Data.parent_id);
							$('#level').val(Data.gl_item_level);
							$('#open').val(Data.open_balance);
							var formattedDate = new Date(Data.open_balance_date);
							var d = formattedDate.getDate();
							if(d < 10){
								d = '0' + d ;
							}
							var m =  formattedDate.getMonth();
							m += 1;
							if(m < 10){
								m = '0' + m ;
							}
							var y = formattedDate.getFullYear();
							$('#date').attr('value',y+"-"+m+'-'+d);
							// $('#gl_parent').val('United States')
							if (Data.balance_type == '1') {
								$('#btype').text('دائن');
							} else {
								$('#btype').text('مدين');
							}
						}
					}).dxTreeView("instance");

					$("#searchMode").dxSelectBox({
						items: ["contains", "startswith"],
						value: "contains",
						onValueChanged: function (data) {
							treeView.option("searchMode", data.value);
						}
					});
					console.table(items_array);
				}
			});
			
		});
    </script>
@endsection
