<div class="form-group-inner" style="margin-right:10px;">
    <div class="row" style="text-align:right !important;direction:rtl !important">
       
        
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="">إسم المخزن باللغة الإنجليزية</label>
                <input name="" type="text" value="{{$row->en_name ?? ''}}" class="form-control" style="text-align:right" disabled>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="">إسم المخزن باللغة العربية</label>
                <input name="" value="{{$row->ar_name ?? ''}}" type="text" class="form-control" placeholder="" style="text-align:right" disabled>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="">كـــــــود المخزن</label>
                <input name="" value="{{$row->code ?? ''}}" type="text" class="form-control" style="text-align:right" disabled>
            </div>
        </div> 
    </div>
</div>
<div class="form-group-inner" style="margin-right:10px;">
    <div class="row" style="text-align:right !important;direction:rtl !important">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
           
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="">ملاحظات</label>
                <input name="" type="number" value="{{$row->notes ?? ''}}" class="form-control" style="text-align:right" disabled>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="">تاريخ الرصيد المفتوح</label>
                <?php
                $date = null;
                $date = date_create($row->open_balance_date) 
                ?>
             
                <input name="" type="text" @if($row->open_balance_date) value="{{ date_format($date,"d-m-Y") }}" @endif class="form-control" placeholder="" style="text-align:right" disabled>
            </div>
        </div>
    </div>
</div>
<h3 style="text-align:right">بيان الجرد
</h3>
<table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="false" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" style="direction:rtl;">
    <thead>
        <tr>
            <th data-field="state"></th>
            <th>Serial</th>
            <th data-field="id">كود جرد المخزن</th>
            <th>رقم جرد المخزن</th>
            <th>تاريخ جرد المخزن</th>
            <th>حالة جرد المخزن</th>
            <th>مسئول الجرد</th>
            <th>مسئول الجرد</th>
            <th>مسئول الجرد</th>
            <th>ملاحظات</th>
            <th>خيارات</th>
        </tr>
    </thead>
    <tbody>
    @foreach($rows as $index=>$take)
        <tr>
            <td></td>
            <td>{{$index+1}}</td>
            <td>{{$take->code}}</td>
            <td>{{$take->taking_no}}</td>
            <td><?php
             $date = date_create($take->taking_date) ?>
                {{ date_format($date,"d-m-Y") }}</td>
            <td>{{$take->status->ar_status ?? ''}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$take->notes}}</td>
            <td>
            <a  href="{{ route('stock-taking.edit',$take->id)}}"><button title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>