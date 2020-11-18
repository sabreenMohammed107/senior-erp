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
<h3 style="text-align:right">بيانات فواتير البيع</h3>
<table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
    <thead>
        <tr>
            <th data-field="state" data-checkbox="false"></th>
            <th data-field="id">رقم الفاتورة</th>
            <th>تاريخ الفاتورة</th>
            <th>إسم العميل</th>
            <th>حالة الفاتورة</th>
            <th>إجمالي قيمة البنود</th>
            <th>كود الفرع</th>
            <th>إسم الفرع</th>
            <th>كود العميل</th>
            <th>ملاحظات</th>
            <th>الفواتير / التقارير</th>
            <th>الاختيارات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $index=>$invoice)
        <tr>

            <td></td>
            <td>{{$invoice->invoice_no}}</td>
            <td>
                <?php

               

                $date =null;
                $date = date_create($invoice->order_date) ?>
               @if($date) {{ date_format($date,"d-m-Y") }}@endif
            </td>
            <td>{{$invoice->PERSON_NAME}}</td>

            <td> حالة الفاتورة</td>
            <td>{{$invoice->totale_item_price}}</td>
            <td> {{$invoice->branch->code ?? ''}}</td>
            <td>{{$invoice->branch->ar_name ?? ''}}</td>
            <td>{{$invoice->person->code ?? ''}}</td>
            <td>{{$invoice->notes}}</td>
            <td> فواتير وتقارير</td>
            <td>
                <div class="product-buttons">
                    <a  href="{{route('sale-invoice.show',$invoice->id)}}"><button title="View" class="pd-setting-ed"><i class="fa fa-file" aria-hidden="true"></i></button></a>
                    <a @if($invoice->confirmed == 1) class="isDisabled" @endif href="{{route('sale-invoice.edit',$invoice->id)}}"><button title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                    <a @if($invoice->confirmed != 1) class="isDisabled" @endif href="{{route('revert-sale.show',$invoice->id)}}"><button title="Revert" class="pd-setting-ed"><i class="fa fa-undo" aria-hidden="true"></i></button></a>

                    <button data-toggle="modal" @if($invoice->confirmed == 1) class="isDisabled" @endif  data-target="#delete{{$invoice->id}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                </div>

                	 <!--Delete-->
		 <div id="delete{{$invoice->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header header-color-modal bg-color-2">
                        <h4 class="modal-title" style="text-align:right">حذف  فاتورة البيع</h4>
                        <div class="modal-close-area modal-close-df">
                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                        </div>
                    </div>
                    <div class="modal-body">
                        <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
                        <h2></h2>
                        <h4>هل تريد حذف جميع بيانات فاتورة البيع ؟ </h4>
                        <h4>سيتم حذف أمر البيع بجميع أصنافه التي تم تدوينها</h4>
                    </div>
                    <div class="modal-footer info-md">
                        <a data-dismiss="modal" href="#">إلغــاء</a>
						<form id="delete" style="display: inline;" action="{{route('sale-invoice.destroy',$invoice->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">حذف</button>
                                </form>
                    </div>
                </div>
            </div>
        </div>
		<!--/Delete-->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>