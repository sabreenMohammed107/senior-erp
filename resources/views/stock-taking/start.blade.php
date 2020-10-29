<?php

use App\Models\Stocks_items_total;

$counter = 1;

?>
<?php
$counterrrr = 1;
?>

@foreach($takingItem as $i=> $itemo)
<tr data-id="{{$counter}}">
    <input type="hidden" name="counter" value="{{$counter}}">

    <td>
    <input type="hidden" name="selectItem{{$counter}}" id="selectItem{{$counter}}" value="{{$itemo->item_id}}" >
    <input type="hidden" name="system_qty{{$counter}}" id="system_qty{{$counter}}" value="{{$itemo->system_qty}}" >
    <input type="hidden" name="batchno{{$counter}}" id="batchno{{$counter}}" value="{{$itemo->batch_no}}" >
    <input type="hidden" name="expired{{$counter}}" id="expired{{$counter}}" value="{{$itemo->expired_date}}" >

        <input type="hidden" name="take_item_id{{$counter}}" id="take_item_id{{$counter}}" value="{{$itemo->id}}" >
        <input style="width: 30px;" type="number" readonly id="firstTT{{$counter}}" value="{{$counter}}">
    </td>

    <td>
        <input type="number" style="display: none;" value="{{$itemo->id}}" name="item_order_id{{$counter}}" id="item_order_id{{$counter}}" class="form-control " placeholder="">
        {{$itemo->Item->code ?? ''}}/{{$itemo->Item->ar_name ?? ''}}

        <span id="item_search{{$counter}}" style="display:none;"></span>
    </td>

    <td id="batchNum{{$counter}}" class="batchNum">
        {{$itemo->batch_no}}
    </td>


    <?php

    $date = date_create($itemo->expired_date);
    ?>
    <td id="batchDate{{$counter}}" class="batchDate">
        {{ date_format($date, "d-m-Y")}}

    </td>

    <td id="batchqty{{$counter}}" class="batchqty">
        {{$itemo->system_qty}}
    </td>
    <td>
      
        <div class="input-mark-inner">
            <input type="number" @if($row->stock_taking_status_id==103) readonly @endif  value="{{$itemo->physical_qty}}" name="physical_qty{{$counter}}" id="physical_qty{{$counter}}" class="form-control item_quantity" placeholder="">
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="number" readonly class="form-control" name="additive_qty{{$counter}}" id="additive_qty{{$counter}}" value="{{$itemo->additive_qty}}"  >
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="number" step="0.01" readonly class="form-control" name="additive_cost{{$counter}}" id="additive_cost{{$counter}}" value="{{$itemo->additive_cost}}"  >
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="number" class="form-control" readonly name="subtractive_qty{{$counter}}" id="subtractive_qty{{$counter}}" value="{{$itemo->subtractive_qty}}"  >
        </div>
    </td>
    <td>
    <div class="input-mark-inner">
    <input type="number" step="0.01" class="form-control" readonly name="subtractive_cost{{$counter}}" id="subtractive_cost{{$counter}}" value="{{$itemo->subtractive_cost}}"  >        </div>
    </td>

    <td> {{$itemo->Item->person->name ?? ''}}</td>
</tr>

<?php
++$counter;

if ($counter > count($takingItem)) {
?>
    @break
<?php }
$counterrrr++;
?>

@endforeach


</tr>