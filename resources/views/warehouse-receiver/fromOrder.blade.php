<?php

$counter = 1;

?>
<?php
$counterrrr = 1;
?>

@foreach($purchItems as $i=> $itemo)

<tr data-id="{{$counter}}">
<input type="hidden" name="counter" value="{{$counter}}">

<input type="number" style="display: none;" value="{{$itemo->id}}" name="item_trans_id{{$counter}}" id="item_trans_id{{$counter}}"  class="form-control " placeholder="">
<input type="number" style="display: none;" value="{{$itemo->transaction_id}}" name="transaction_id" id="transaction_id"  class="form-control " placeholder="">

   
    <td id="fTd{{$counter}}">{{$counter}}</td>
    <td>
    <input type="number" style="display: none;" value="{{$itemo->item_id}}" name="selectup{{$counter}}" id="selectup{{$counter}}"  class="form-control " placeholder="">

    {{$itemo->Item->code ?? ''}}/{{$itemo->Item->ar_name ?? ''}}
       
    </td>
    <td id="ar_name{{$counter}}">{{$itemo->item->ar_name ?? ''}} {{$itemo->item->code ?? ''}}</td>
    <td id="uom{{$counter}}">{{$itemo->item->uom->ar_name ?? ''}}</td>
    <td>
        <div class="input-mark-inner">
            <input type="text" id="orBatch{{$counter}}" name="orBatch{{$counter}}" class="form-control" placeholder="Some Text Here" style="width: 130px">
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="date" id="orDate{{$counter}}" name="orDate{{$counter}}" class="form-control" placeholder="Some Text Here" style="width: 130px">
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="number" id="orqty{{$counter}}" value="{{$itemo->item_qty}}" name="orqty{{$counter}}" class="form-control" style="width: 130px">
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="text" id="notes{{$counter}}" name="notesup{{$counter}}" value="{{$itemo->notes}}" oninput="itemNotes({{$counter}})" onkeypress="enterForRow(event,{{$counter}})" class="form-control" placeholder="" style="width: 200px">
        </div>
    </td>
    <td>
    <div class="product-buttons">
    <button id="del{{$counter}}" onclick="deleteRow({{$counter}})" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

        </div>
        <!--Delete-->
<div id="del{{$counter}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-color-modal bg-color-2">
                <h4 class="modal-title" style="text-align:right">حذف بيانات الصنف</h4>
                <div class="modal-close-area modal-close-df">
                    <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                </div>
            </div>
            <div class="modal-body">
                <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
                <h2></h2>
                <h4>هل تريد حذف جميع بيانات الصنف ؟  </h4>
            </div>
            <div class="modal-footer info-md">
                <a data-dismiss="modal" href="#">إلغــاء</a>
                <a href="#" onclick="DeletethisItem({{$itemo->id}},{{$counter}})">حـذف</a>
            </div>
        </div>
    </div>
</div>
<!--/Delete-->
    </td>
</tr>
<?php
++$counter;

if ($counter > count($purchItems)) {
?>
    @break
<?php }
$counterrrr++;
?>

@endforeach
<input type="number" style="display: none;" value="{{$counterrrr}}" name="qqq" class="form-control item_quantity" placeholder="">