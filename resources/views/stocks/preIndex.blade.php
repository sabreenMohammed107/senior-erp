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
<table class="table-striped" id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
    <thead>
        <tr>
            <th data-field="state"></th>
            <th data-field="id">كود المخزن</th>
            <th>إسم المخزن عربي</th>
            <th>إسم المخزن إنجليزي</th>


            <th> اخر تاريخ جرد</th>

            <th>تاريخ الرصيد الإفتتاحي</th>
            <th>ملاحظات</th>
            <th>الاختيارات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stocks as $index=>$stock)
        <tr>
            <td></td>

            <td>
                {{$stock->code}}
            </td>
            <td>{{$stock->ar_name}}</td>
            <td>{{$stock->en_name}}</td>


            <td><?php
                $date = null;
                $date = date_create($stock->stock_taking_last_date) ?>
                @if($date) {{ date_format($date,"d-m-Y") }}@endif</td>
            <td><?php



                $date = null;
                $date = date_create($stock->open_balance_date) ?>
                @if($date) {{ date_format($date,"d-m-Y") }}@endif </td>
            <td> {{$stock->notes}}</td>
            <td>
                <div class="product-buttons">
                  
                    <a href="{{ route('stocks.show',$stock->id)}}"><button title="View" class="pd-setting-ed"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                    <a href="{{ route('stocks.edit',$stock->id)}}"><button title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                    <?php
                    $open=count($stock->type()->where('transaction_type_id', 100)->get());
                   
                    ?>
                 @if($open == 1) 
                    <a  href="{{ route('stocks.openBalance',$stock->id)}}"><button title="open balance" class="pd-setting-ed"><i class="fa fa-book" aria-hidden="true"></i></button></a>
                   @endif
                    <button data-toggle="modal" data-target="#del{{$stock->id}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                </div>

                <!--Delete Company-->

                <div id="del{{$stock->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header header-color-modal bg-color-2">
                                <h4 class="modal-title" style="text-align:right">حذف بيانات المخزن</h4>
                                <div class="modal-close-area modal-close-df">
                                    <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                            <div class="modal-body">
                                <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
                                <h2>{{$stock->ar_name}}</h2>

                                <h4>هل تريد حذف جميع بيانات المخزن ؟ </h4>
                            </div>
                            <div class="modal-footer info-md">
                                <a data-dismiss="modal" href="#">إلغــاء</a>
                                <form id="delete" style="display: inline;" action="{{route('stocks.destroy',$stock->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">حذف</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/Delete Company-->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>