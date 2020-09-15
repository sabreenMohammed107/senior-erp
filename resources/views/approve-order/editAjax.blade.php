
<?php

$counter = 0;

?>
   <?php
$counterrrr = 0;
?>

@foreach($orderItems as $i=> $itemo)

<tr data-id="{{$counter}}">
   <td>

   </td>
   <td>
   <input type="number" style="display: none;" value="{{$itemo->ORDER_ITEM_ID}}" name="item_order_id{{$counter}}" id="item_order_id{{$counter}}"  class="form-control " placeholder="">

 <select id="select{{$counter}}" name="selectup{{$counter}}"  onchange="editSelectVal({{$counter}})" data-placeholder="أختر صنف" class="chosen-select" tabindex="-1">
         
           @foreach ($items as $Itemx)
           <option 
           @if ($itemo->ITEM_ID = $Itemx->ITEM_ID)
               selected="selected"
           @endif 
           value="{{$Itemx->ITEM_ID}}">{{$Itemx->ITEM_CODE}}/{{$Itemx->ITEM_AR_NAME}}</option>
           @endforeach
       </select>


   </td>
   <td id="uom{{$counter}}" class="uom">{{$itemo->item->DEFAULT_UOM_ID ?? ''}}</td>
   <td id="ar_name{{$counter}}" class="ar_name">{{$itemo->item->ITEM_AR_NAME ?? ''}}</td>
   <td>
   <?php
               $data = DB::table('stocks_items_total')->where('ITEM_ID', $itemo->ITEM_ID)->get();

       ?>
       <select id="selectBatch{{$counter}}" name="selectBatchup{{$counter}}" qty  data-placeholder="Choose a Country..." class="chosen-select" tabindex="-1">
       <option>{{$itemo->BATCH_NO}} /{{$itemo->EXPIRED_DATE}}/{{$itemo->ITEM_QTY}}</option>
         
       @foreach ($data as $dataa)
           <option 
          
           value="{{$dataa->STOCK_ITEMS_ID}}">{{$dataa->BATCH_NO}}/{{$dataa->ITEM_TOTAL_QTY}}</option>
           @endforeach

       </select></td>
   <td id="batchNum{{$counter}}" class="batchNum">{{$itemo->BATCH_NO}} </td>
   <?php
    $date = date_create($itemo->EXPIRED_DATE);
   ?>
   <td id="batchDate{{$counter}}" class="batchDate">{{ date_format($date, "d-m-Y")}} </td>
   <td id="batchqty{{$counter}}" class="batchqty">{{$itemo->ITEM_QTY}} </td>
   <td>
       <div class="input-mark-inner mg-b-22">
           <input type="number" readonly  value="{{$itemo->ITEM_QTY}}" name="qtyup{{$counter}}" id="qty{{$counter}}"  class="form-control item_quantity" placeholder="">
       </div>
   </td>
   <td>
       <div class="input-mark-inner mg-b-22">
           <input type="number" step="0.01" readonly id="itemprice{{$counter}}" value="{{$itemo->ITEM_PRICE}}" name="itempriceup{{$counter}}"   class="form-control item_price" placeholder="">
       </div>
   </td>

   <td id="total{{$counter}}" class="total_item_price">
{{$itemo->TOTAL_LINE_COST}}
   </td>
   <td> <div class="input-mark-inner mg-b-22">
           <input type="number" step="0.01" readonly value="{{$itemo->ITEM_DISC_PERC}}"  name="perup{{$counter}}" id="per{{$counter}}"   class="form-control item_dis" placeholder="">
       </div></td>
   <td><div class="input-mark-inner mg-b-22">
           <input type="number" step="0.01" readonly value="{{$itemo->ITEM_DISC_VALUE}}"  name="disvalup{{$counter}}" id="disval{{$counter}}"  class="form-control item_disval" placeholder="">
       </div></td>
       <td id="final{{$counter}}" class="total_item_final">
      {{$itemo->FINAL_LINE_COST}}
   </td>
   <td>
       <div class="input-mark-inner mg-b-22">
           <input type="text"  value="{{$itemo->NOTES}}" readonly  name="detNoteup{{$counter}}" class="form-control detNote" placeholder="ملاحظات">
       </div>
   </td>
  
</tr>

<?php
++$counter;

if( $counter > count($orderItems)){
?>
@break
<?php }
$counterrrr++;
?>

@endforeach
<input type="number" style="display: none;"  value="{{$counterrrr}}" name="qqq"  class="form-control item_quantity" placeholder="">




