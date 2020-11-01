<?php

use App\Models\Stocks_items_total;

$counter = 1;

?>
<?php
$counterrrr = 1;
?>

@foreach($items as $i=> $itemo)
<tr  data-id="{{$counter}}">
    <input type="hidden" name="counter" value="{{$counter}}">

    <td> <input style="width: 30px;" type="number" readonly id="firstTT{{$counter}}" value="{{$counter}}"></td>
  
    <td>
        <input type="number" style="display: none;" value="{{$itemo->id}}" name="item_order_id{{$counter}}" id="item_order_id{{$counter}}" class="form-control " placeholder="">
        {{$itemo->Item->code ?? ''}}/{{$itemo->Item->ar_name ?? ''}}

        <span id="item_search{{$counter}}" style="display:none;"></span>
    </td>

    <td id="batchNum{{$counter}}" class="batchNum">{{$itemo->batch_no}} </td>


    <?php

    $date = date_create($itemo->expired_date);
    ?>
    <td id="batchDate{{$counter}}" class="batchDate">{{ date_format($date, "d-m-Y")}} </td>

    <td id="batchqty{{$counter}}" class="batchqty">
    {{$itemo->item_total_qty}}
    </td>
    <td>  {{$itemo->Item->person->name ?? ''}}</td>
</tr>

<?php
++$counter;

if ($counter > count($items)) {
?>
    @break
<?php }
$counterrrr++;
?>

@endforeach