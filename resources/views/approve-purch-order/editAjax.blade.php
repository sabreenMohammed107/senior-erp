<?php

use App\Models\Stocks_items_total;

$counter = 1;

?>
<?php
$counterrrr = 1;
?>

@foreach($orderItems as $i=> $itemo)
<tr data-id="{{$counter}}">
    <input type="hidden" name="counter" value="{{$counter}}">
    <td> <input style="width: 30px;" type="number" readonly id="firstTT{{$counter}}" value="{{$counter}}"></td>
    <td>
        <input type="number" style="display: none;" value="{{$itemo->id}}" name="item_order_id{{$counter}}" id="item_order_id{{$counter}}" class="form-control " placeholder="">
        <input type="text" id="upselect{{$counter}}" name="upselect{{$counter}}" readonly value="{{$itemo->Item->code ?? ''}}/{{$itemo->Item->ar_name ?? ''}}">

        <span id="item_search{{$counter}}"  style="display:none;">{{$itemo->Item->code ?? ''}}/{{$itemo->Item->ar_name ?? ''}}</span>

    </td>
    <td id="uom{{$counter}}" class="uom">{{$itemo->item->uom->ar_name ?? ''}}</td>
    <td id="ar_name{{$counter}}" class="ar_name">{{$itemo->item->ar_name ?? ''}}</td>

   
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" style="width: 200px" value="{{$itemo->item->request_limit ?? ''}}" readonly  oninput="itemLimit({{$counter}})" onfocusout="maxQty({{$counter}})" name="upqtyLimit{{$counter}}" id="qtyLimit{{$counter}}"  class="form-control item_quantity" placeholder="">
        </div>
    </td>  
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" style="width: 200px" readonly oninput="itemQty({{$counter}})" value="{{$itemo->item_qty}}" onfocusout="maxQty({{$counter}})" name="upqty{{$counter}}" id="qty{{$counter}}" class="form-control item_quantity" placeholder="">
        </div>
    </td>

    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" step="0.01" readonly style="width: 200px" id="itemprice{{$counter}}" value="{{$itemo->item_price}}" name="upitemprice{{$counter}}" oninput="itemPrice({{$counter}})" class="form-control item_price" placeholder="">
        </div>
    </td>

    <td id="total{{$counter}}" class="total_item_price">
        {{$itemo->total_line_cost}}
    </td>
  
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="text" style="width: 200px" readonly onkeypress="enterForRow(event,{{$counter}})" name="updetNote{{$counter}}" value="{{$itemo->notes}}" class="form-control detNote" placeholder="ملاحظات">
        </div>
    </td>
      </div>
        </div>
        <!--/Delete-->
    </td>
</tr>

<?php
++$counter;

if ($counter > count($orderItems)) {
?>
    @break
<?php }
$counterrrr++;
?>

@endforeach
<input type="number" style="display: none;" value="{{$counterrrr}}" name="qqq" class="form-control item_quantity" placeholder="">