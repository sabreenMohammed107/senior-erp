<div class="form-group-inner" style="margin-right:10px;">
    <div class="row res-rtl" style="display: flex ;flex-direction: row-reverse ;">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b-22">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <div class="input-mark-inner mg-b-22">
                        <input type="text" value="{{$stock->branch->code ?? ''}}" class="form-control" placeholder="" readonly>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="input-mask-title">
                        <label><b>كود الفرع</b></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <div class="input-mark-inner mg-b-22">
                        <input type="text" class="form-control" value="{{$stock->code ?? ''}}" placeholder="" readonly>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="input-mask-title">
                        <label><b>كود المخزن</b></label>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b-22">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <div class="input-mark-inner mg-b-22">
                        <input type="text" value="{{$stock->branch->ar_name ?? ''}}" class="form-control" placeholder="" readonly>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="input-mask-title">
                        <label><b>إسم الفرع</b></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <div class="input-mark-inner mg-b-22">
                        <input type="text" value="{{$stock->ar_name ?? ''}}" class="form-control" placeholder="" readonly>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="input-mask-title">
                        <label><b>إسم المخزن باللغة العربية</b></label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<hr>
<form action="{{route('warehouse-receiver.creation')}}" method="get">
    <input type="hidden" value="{{$stock->id}}" id="stock" name="stock">

    <button type="submit" style="direction:ltr;margin-top:-20px;background: rgba(139,0,0,.7);color:white;padding:5px ; border-color: rgba(139,0,0,.7);">إضافة جديد</button>

</form>
<table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="false" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" style="direction:rtl;">
    <thead>
        <tr>
            <th data-field="state"></th>
            <th data-field="id">كود الحركة</th>
            <th>تاريخ الحركة</th>
            <th>كود الشخص</th>
            <th>إسم الشخص</th>
            <th>كود الصلاحية</th>
            <th>تاريخ الصلاحية</th>
            <th>التأكيد</th>
            <th>ملاحظات</th>
            <th>حذف</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $index=>$row)
        <tr>
            <td></td>
            <td>{{$row->code}}</td>
            <td><?php
                $date = null;
                $date = date_create($row->transaction_date) ?>
                @if($date) {{ date_format($date,"d-m-Y") }}@endif</td>
            <td>{{$row->person->code ??''}}</td>
            <td>{{$row->person->name ??''}}</td>
            <td> {{$row->permission_code}}</td>
            <td><?php
                $date = null;
                $date = date_create($row->permission_date) ?>
                @if($date) {{ date_format($date,"d-m-Y") }}@endif</td>
            <td>@if($row->confirmed==1)تم التأكيد @else لم يتم التأكيد @endif</td>
            <td>{{$row->notes}}</td>
            <td>
                <div class="product-buttons">
                    <!-- <button data-toggle="tooltip" title="View" class="pd-setting-ed"><i class="fa fa-file" aria-hidden="true"></i></button> -->
                    <a href="{{ route('warehouse-receiver.show',$row->id)}}"><button title="view" class="pd-setting-ed"><i class="fa fa-file" aria-hidden="true"></i></button></a>

                    <a @if($row->confirmed == 1) class="isDisabled" @endif href="{{ route('warehouse-receiver.edit',$row->id)}}"><button title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                    <button @if($row->confirmed == 1) class="isDisabled" @endif data-toggle="modal" data-target="#delete{{$row->id}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                </div>

                <!--Delete-->
                <div id="delete{{$row->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header header-color-modal bg-color-2">
                                <h4 class="modal-title" style="text-align:right">حذف امر البيع</h4>
                                <div class="modal-close-area modal-close-df">
                                    <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                            <div class="modal-body">
                                <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
                                <h2></h2>
                                <h4>هل تريد حذف جميع بيانات أمر البيع ؟ </h4>
                                <h4>سيتم حذف أمر البيع بجميع أصنافه التي تم تدوينها</h4>
                            </div>
                            <div class="modal-footer info-md">
                                <a data-dismiss="modal" href="#">إلغــاء</a>
                                <form id="delete" style="display: inline;" action="{{route('warehouse-receiver.destroy',$row->id)}}" method="POST">
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