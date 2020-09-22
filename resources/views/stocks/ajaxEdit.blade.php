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

    <td></td>
    <td id="fTd{{$counter}}">{{$counter}}</td>
    <td>

    {{$itemo->Item->code}}/{{$itemo->Item->ar_name}}
       
    </td>
    <td id="ar_name{{$counter}}">{{$itemo->item->ar_name ?? ''}}</td>
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
            <button id="del{{$counter}}" onclick="deleteRow({{$counter}})" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        </div>
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