<?php

$counter = 1;

?>
<?php
$counterrrr = 1;
?>

@foreach($transItems as $i=> $itemo)

<tr data-id="{{$counter}}">
<input type="number" style="display: none;" value="{{$itemo->id}}" name="item_trans_id{{$counter}}" id="item_trans_id{{$counter}}"  class="form-control " placeholder="">
<input type="number" style="display: none;" value="{{$itemo->transaction_id}}" name="transaction_id" id="transaction_id"  class="form-control " placeholder="">
<input type="number" style="display: none;" value="{{$itemo->item_id}}" name="selectup{{$counter}}" id="selectup{{$counter}}"  class="form-control " placeholder="">

   
    <td id="fTd{{$counter}}">{{$counter}}</td>
    <td>

    {{$itemo->Item->code ?? ''}}/{{$itemo->Item->ar_name ?? ''}}
       
    </td>
    <td id="ar_name{{$counter}}">{{$itemo->item->ar_name ?? ''}} {{$itemo->item->code ?? ''}}</td>
    <td id="uom{{$counter}}">{{$itemo->item->uom->ar_name ?? ''}}</td>
    <td>
        <div class="input-mark-inner">
            <?php
            $date = date_create($itemo->expired_date);
            ?>
            <input type="date" name="batchDateup{{$counter}}" value="{{ date_format($date, "Y-m-d")}}" onchange="batchDate({{$counter}})" id="batchDate{{$counter}}" class="form-control">
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="text" id="batchNum{{$counter}}" value="{{$itemo->batch_no}}" name="batchNumup{{$counter}}" oninput="batchItem({{$counter}})" class="form-control" placeholder="" style="width: 130px">
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="number" name="qtyup{{$counter}}" value="{{$itemo->item_qty}}"  oninput="itemQty({{$counter}})" id="qty{{$counter}}" class="form-control" placeholder="" style="width: 130px">
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="number" class="form-control" value="{{$itemo->item_price}}" id="itemprice{{$counter}}" oninput="itemPrice({{$counter}})" name="itempriceup{{$counter}}" placeholder="" style="width: 130px">
        </div>
    </td>
    <td id="total{{$counter}}" class="total_item">
    {{$itemo->item_qty * $itemo->item_price}}
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="text" id="notes{{$counter}}" name="notesup{{$counter}}" value="{{$itemo->notes}}" oninput="itemNotes({{$counter}})" onkeypress="enterForRow(event,{{$counter}})" class="form-control" placeholder="" style="width: 200px">
        </div>
    </td>
    <td>
    <div class="product-buttons">
        <button type="button" data-toggle="modal" data-target="#del{{$counter}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
                <a href="#" onclick="DeleteStockItem({{$itemo->id}},{{$counter}})">حـذف</a>
            </div>
        </div>
    </div>
</div>
<!--/Delete-->
    </td>
</tr>
<?php
++$counter;

if ($counter > count($transItems)) {
?>
    @break
<?php }
$counterrrr++;
?>

@endforeach
<input type="number" style="display: none;" value="{{$counterrrr}}" name="qqq" class="form-control item_quantity" placeholder="">