<div class="form-group-inner" style="margin-right:10px;">
	<div class="row" style="text-align:right !important;direction:rtl !important">
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="">عنوان الفرع</label>
				<input name="" value="{{$row->address ?? ''}}" type="text" class="form-control" placeholder="" style="text-align:right" disabled>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="">كـــــــود الفرع</label>
				<input name="" value="{{$row->code ?? ''}}" type="text" class="form-control" style="text-align:right" disabled>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="">إسم الفرع باللغة العربية</label>
				<input name="" type="text" value="{{$row->ar_name ?? ''}}" class="form-control" style="text-align:right" disabled>
			</div>
		</div>
	</div>
</div>
<div class="form-group-inner" style="margin-right:10px;">
	<div class="row" style="text-align:right !important;direction:rtl !important">
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="">البريد الإلكتروني</label>
				<input name="" type="email" value="{{$row->email ?? ''}}" class="form-control" placeholder="" style="text-align:right" disabled>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="">رقم التليفون</label>
				<input name="" type="number" value="{{$row->phone ?? ''}}" class="form-control" style="text-align:right" disabled>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="">إسم الفرع باللغة الإنجليزية</label>
				<input name="" type="text" value="{{$row->en_name ?? ''}}" class="form-control" style="text-align:right" disabled>
			</div>
		</div>
	</div>
</div>
<h3 style="text-align:right">بيانات أوامر البيع</h3>
<table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
	<thead>
		<tr>
			<th data-field="state" data-checkbox="false"></th>
			<th data-field="id">رقم أمر البيع</th>
			<th>تاريخ أمر البيع</th>
			<th>إسم العميل</th>
			<th>وصف أمر البيع</th>
			<th>قيمة أمر البيع</th>
			<th>حالة قرار الطلب</th>
			<th>إسم الفرع</th>
			<th>الاختيارات</th>
		</tr>
	</thead>
	<tbody>
		@foreach($orders as $index=>$order)
		<tr>
			<td></td>
			<td>{{$index+1}}</td>
			<td>
			<?php
             $date = date_create($order->ORDER_DATE) ?>
                {{ date_format($date,"d-m-Y") }}
			</td>
			<td>{{$order->PERSON_NAME}}</td>
			<td>{{$order->ORDER_DESCRIPTION}}</td>
			<td>{{$order->ORDER_VALUE}}</td>
			<td>@if($order->ORDER_DECISION_STATUS_ID==1) لم يتم اتخاز قرار @elseif($order->ORDER_DECISION_STATUS_ID==2) تمت الموافقة @elseif($order->ORDER_DECISION_STATUS_ID==3) لم تتم الموافقه@else @endif</td>
			<td>فرع القاهرة</td>
			<td>
				<div class="product-buttons">
					<!-- <button data-toggle="tooltip" title="View" class="pd-setting-ed"><i class="fa fa-file" aria-hidden="true"></i></button> -->
					<a href="{{ route('approve-order.edit',$order->ORDER_ID)}}"><button title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>