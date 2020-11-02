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
<h3 style="text-align:right">بيان حركات الصادر
</h3>
<table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="false" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" style="direction:rtl;">
    <thead>
        <tr>
            <th data-field="state"></th>
            <th>Serial</th>
            <th data-field="id">كود الحركة</th>
            <th>تاريخ الحركة</th>
            <th>كود مخزن الصادر</th>
            <th>كود مخزن الوارد</th>
            <th>التأكيد</th>
            <th>تأكيد الإستلام</th>
            <th>ملاحظات</th>
            <th>عرض / تعديل</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $index=>$incoming)
        <tr>
            <td></td>
            <td>{{$index+1}}</td>
            <td>{{$incoming->code}}</td>
            <td><?php
             $date = date_create($incoming->transaction_date) ?>
                {{ date_format($date,"d-m-Y") }}</td>
                <td>{{$incoming->transaction->code ?? ''}} / {{$incoming->transaction->ar_name ?? ''}}</td>
            <td>{{$incoming->secondry->code ?? ''}} / {{$incoming->secondry->ar_name ?? ''}}</td>
            <td>@if($incoming->confirmed==1) تم تأكيد @else لم يتم تأكيد  @endif</td>

            <td>@if($incoming->rcvd_confirmed==1) تم تأكيد الإستلام@else لم يتم تأكيد الإستلام @endif</td>
            <td>{{$incoming->notes}}</td>
            <td>
                <div class="product-buttons">
                <a href="{{ route('incoming-stock-trans.show',$incoming->id)}}"> <button title="Show" class="pd-setting-ed"><i class="fa fa-file" aria-hidden="true"></i></button></a>
                    <a  @if($incoming->confirmed == 1) class="isDisabled" @endif href="{{ route('incoming-stock-trans.edit',$incoming->id)}}"><button title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                   {{--<button @if($incoming->confirmed == 1) class="isDisabled" @endif data-toggle="modal" data-target="#delete{{$incoming->id}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                   --}}  </div>

                <!--Delete-->
                <div id="delete{{$incoming->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
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
                                <h4>هل تريد حذف جميع الحركة الصادره ؟ </h4>
                                <h4>سيتم حذف هذه الحركه بجميع أصنافها التي تم تدوينها</h4>
                            </div>
                            <div class="modal-footer info-md">
                                <a data-dismiss="modal" href="#">إلغــاء</a>
                                <form id="delete" style="display: inline;" action="{{route('incoming-stock-trans.destroy',$incoming->id)}}" method="POST">
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