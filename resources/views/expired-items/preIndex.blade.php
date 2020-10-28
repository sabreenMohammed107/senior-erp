<h3 style="text-align:right">بيانات حركات الصادر</h3>
<table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="false" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" style="direction:rtl;">
    <thead>
        <tr>
            <th data-field="state"></th>
            <th>Serial</th>
            <th data-field="id">كود الحركة</th>
            <th>تاريخ الحركة</th>
            <th>كود مخزن الوارد</th>
            <th>ملاحظات</th>
            <th>عرض / تعديل</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $index=>$transaction)
        <tr>
            <td></td>
            <td>{{$index+1}}</td>
            <td>{{$transaction->code}}</td>
            <td>
                <?php
                $date = date_create($transaction->transaction_date);
                ?>
                {{ date_format($date, 'Y-m-d')}} </td>
            <td>{{$transaction->transaction->code ??''}}</td>
            <td>{{$transaction->notes}}</td>
            <td>
                <div class="product-buttons">
                <a  href="{{route('expired-items.show',$transaction->id)}}"><button title="View" class="pd-setting-ed"><i class="fa fa-file" aria-hidden="true"></i></button></a>
                    <a @if($transaction->confirmed == 1) class="isDisabled" @endif href="{{route('expired-items.edit',$transaction->id)}}"><button title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                    <button data-toggle="modal" @if($transaction->confirmed == 1) class="isDisabled" @endif  data-target="#delete{{$transaction->id}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
               </div>
                 <!--Delete-->
                 <div id="delete{{$transaction->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header header-color-modal bg-color-2">
                                <h4 class="modal-title" style="text-align:right">حذف  الاصناف التالفة</h4>
                                <div class="modal-close-area modal-close-df">
                                    <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                            <div class="modal-body">
                                <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
                                <h2></h2>
                                <h4>هل تريد حذف جميع بيانات الاصناف التالفه ؟ </h4>
                                <h4>سيتم حذف  الاصناف التالفة بجميع أصنافه التي تم تدوينها</h4>
                            </div>
                            <div class="modal-footer info-md">
                                <a data-dismiss="modal" href="#">إلغــاء</a>
                                <form id="delete" style="display: inline;" action="{{route('expired-items.destroy',$transaction->id)}}" method="POST">
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