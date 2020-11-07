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
<h3 style="text-align:right">بيان المرتجعات</h3>
<table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="false" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" style="direction:rtl;">
    <thead>
        <tr>
            <th data-field="state"></th>
            <th>Serial</th>
            <th data-field="id">كود الحركة</th>
            <th>تاريخ الحركة</th>
            <th>إسم العميل</th>
            <th>إجمالي سعر البند</th>
            <th>كود المخزن</th>
            <th>كود الفرع</th>
            <th>ملاحظات</th>
            <th>--</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reverts as $index=>$revert)
        <tr>
            <td></td>
            <td>{{$index+1}} - {{$revert->id}}</td>
            <td>{{$revert->code}}</td>
            <td><?php
                $date = null;
                $date = date_create($revert->transaction_date) ?>
                @if($date) {{ date_format($date,"d-m-Y") }}@endif</td>
            <td>{{$revert->person_name}}</td>
            <td>{{$revert->total_items_price}}</td>
            <td>{{$revert->transaction->code ??''}} /{{$revert->transaction->ar_name ?? ''}}</td>
            <td>{{$revert->invoice->branch->code ??''}} /{{$revert->invoice->branch->ar_name ?? ''}}</td>
            <td>{{$revert->notes}}</td>
            <td>
                <div class="product-buttons">
                    <a href="{{route('all-revert-purch.show',$revert->id)}}"><button title="View" class="pd-setting-ed"><i class="fa fa-file" aria-hidden="true"></i></button></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>