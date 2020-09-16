<?php

$counter = 1;

?>
<?php
$counterrrr = 0;
?>
<input type="number" style="display: none;" value="{{count($orderItems)}}" name="qqq" class="form-control " placeholder="">

@foreach($orderItems as $i=> $itemo)

<tr data-id="{{$counter}}">
<td> <input style="width: 30px;" type="number" readonly id="firstTT{{$counter}}"  value="{{$counter}}" ></td>

    <td>
    <input type="number" style="display: none;" value="{{$itemo->ORDER_ITEM_ID ?? 0}}" name="item_order_id{{$counter}}" id="item_order_id{{$counter}}" class="form-control " placeholder="">

    </td>
    <td>
        <input type="hidden" name="selectup{{$counter}}" style="width: 200px" value="{{$itemo->item->ITEM_ID ?? 0}}" >
    {{$itemo->item->ITEM_CODE ?? ''}}

    </td>
   
        <td id="ar_name{{$counter}}" class="ar_name">{{$itemo->item->ITEM_AR_NAME ?? ''}}</td>


 
    <td id="uom{{$counter}}" class="uom">{{$itemo->item->DEFAULT_UOM_ID ?? ''}}</td>
    <?php
     $date = date_create($itemo->EXPIRED_DATE);
    ?>

    <?php
                $data = DB::table('stocks_items_total')->where('ITEM_ID', $itemo->ITEM_ID)->get();

        ?>
        <td>
            <input type="text" style="width: 200px" value="{{$itemo->BATCH_NO}} - {{ date_format($date, "d-m-Y")}} - {{$itemo->ITEM_QTY}}" readonly>
     
        </td>
    <td id="batchNum{{$counter}}" class="batchNum">{{$itemo->BATCH_NO}} </td>
   
    <td id="batchDate{{$counter}}" class="batchDate">
        {{ date_format($date, "d-m-Y")}} </td>
    <td id="batchqty{{$counter}}" class="batchqty">{{$itemo->ITEM_QTY}} </td>
    <input type="hidden" value=" {{$itemo->BATCH_NO}}" name="batchNum1up{{$counter}}"> </td>
    <input type="hidden" value="{{ date_format($date, "d-m-Y")}}" name="batchDate1up{{$counter}}"> </td>
    <input type="hidden" value="{{$itemo->ITEM_QTY}}" name="batchqty1up{{$counter}}"> </td>
   
    
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" style="width: 200px" readonly oninput="itemQty({{$counter}})" value="{{$itemo->ITEM_QTY ?? ''}}" name="qtyup{{$counter}}" id="qty{{$counter}}" class="form-control item_quantity" placeholder="">
        </div>
    </td>
   
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" style="width: 200px" readonly step="0.01" id="itemprice{{$counter}}" value="{{$itemo->ITEM_PRICE ?? ''}}" name="itempriceup{{$counter}}" oninput="itemPrice({{$counter}})" class="form-control item_price" placeholder="">
        </div>
    </td>

    <td id="total{{$counter}}" class="total_item_price">
        {{$itemo->TOTAL_LINE_COST ?? ''}}
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" style="width: 200px" readonly step="0.01" value="{{$itemo->ITEM_DISC_PERC ?? ''}}" oninput="disPer({{$counter}})" name="perup{{$counter}}" id="per{{$counter}}" class="form-control item_dis" placeholder="">
        </div>
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" style="width: 200px" readonly step="0.01" value="{{$itemo->ITEM_DISC_VALUE ??''}}" oninput="disval({{$counter}})" name="disvalup{{$counter}}" id="disval{{$counter}}" class="form-control item_disval" placeholder="">
        </div>
    </td>
    <td id="final{{$counter}}" class="total_item_final">
        {{$itemo->FINAL_LINE_COST ?? ''}}
    </td>
    <td id="totalvat{{$counter}}" class="input-mark-inner mg-b-22 vat_tax_value">
    <input type="hidden" value="" name="totalvat1{{$counter}}"> 
    {{$itemo->item->VAT_VALUE ?? ''}}
    </td>
    <td  id="totalcit{{$counter}}" class="input-mark-inner mg-b-22 comm_industr_tax">
    <input type="hidden" value="" name="totalcit1{{$counter}}"> 
    {{$itemo->FINAL_LINE_COST  *  $itemo->item->VAT_VALUE }}

    
    </td>
    <td id="finalAll{{$counter}}" class="total_item_final">
        {{ $itemo->FINAL_LINE_COST - ($itemo->FINAL_LINE_COST  *  $itemo->item->VAT_VALUE)}}
    </td>
   
    <td>

        <div class="product-buttons">
            <!-- <button type="button" data-toggle="modal" data-target="#del{{$counter}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button> -->
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
                        <h4>هل تريد حذف جميع بيانات الصنف ؟ </h4>
                        <h4>سيتم حذف المنتجات التي لم يتم حفظ تدوينها</h4>
                    </div>
                    <div class="modal-footer info-md">
                        <a data-dismiss="modal" href="#">إلغــاء</a>
                        <a href="#" onclick="DeleteOrderItem({{$itemo->ORDER_ITEM_ID ?? 0}},{{$counter}})">حـذف</a>
                    </div>
                </div>
            </div>
        </div>
        <!--/Delete-->


    </td>

</tr>

<?php
++$counter;
$counterrrr++;
if(is_countable($orderItems)) {
    if ($counter > count($orderItems)) {


?>

    @break
<?php }}

?>
@endforeach

