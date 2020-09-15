
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

  <select id="select{{$counter}}" name="selectup{{$counter}}"  onchange="editSelectVal({{$counter}})" data-placeholder="Choose a Country..." class="chosen-select" tabindex="-1">
          
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
        <select id="selectBatch{{$counter}}" name="selectBatchup{{$counter}}" qty onchange="editSelectBatch({{$counter}})" data-placeholder="Choose a Country..." class="chosen-select" tabindex="-1">
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
            <input type="number" oninput="itemQty({{$counter}})" value="{{$itemo->ITEM_QTY}}" name="qtyup{{$counter}}" id="qty{{$counter}}"  class="form-control item_quantity" placeholder="">
        </div>
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" step="0.01" id="itemprice{{$counter}}" value="{{$itemo->ITEM_PRICE}}" name="itempriceup{{$counter}}" oninput="itemPrice({{$counter}})"  class="form-control item_price" placeholder="">
        </div>
    </td>

    <td id="total{{$counter}}" class="total_item_price">
{{$itemo->TOTAL_LINE_COST}}
    </td>
    <td> <div class="input-mark-inner mg-b-22">
            <input type="number" step="0.01" value="{{$itemo->ITEM_DISC_PERC}}" oninput="disPer({{$counter}})" name="perup{{$counter}}" id="per{{$counter}}"   class="form-control item_dis" placeholder="">
        </div></td>
    <td><div class="input-mark-inner mg-b-22">
            <input type="number" step="0.01" value="{{$itemo->ITEM_DISC_VALUE}}" oninput="disval({{$counter}})" name="disvalup{{$counter}}" id="disval{{$counter}}"  class="form-control item_disval" placeholder="">
        </div></td>
        <td id="final{{$counter}}" class="total_item_final">
       {{$itemo->FINAL_LINE_COST}}
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="text" onkeypress="enterForRow(event,{{$counter}})" value="{{$itemo->NOTES}}"  name="detNoteup{{$counter}}" class="form-control detNote" placeholder="ملاحظات">
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
                <h4>سيتم حذف المنتجات التي لم يتم حفظ تدوينها</h4>
            </div>
            <div class="modal-footer info-md">
                <a data-dismiss="modal" href="#">إلغــاء</a>
                <a href="#" onclick="DeleteOrderItem({{$itemo->ORDER_ITEM_ID}},{{$counter}})">حـذف</a>
            </div>
        </div>
    </div>
</div>
<!--/Delete-->
        
       
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




