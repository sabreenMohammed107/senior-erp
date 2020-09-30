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

        <span id="item_search{{$counter}}" style="display:none;"></span>

    </td>
    <td id="uom{{$counter}}" class="uom">{{$itemo->item->uom->ar_name ?? ''}}</td>
    <td id="ar_name{{$counter}}" class="ar_name">{{$itemo->item->ar_name ?? ''}}</td>

   
    <td>
    <?php
    $data = App\Models\Stocks_items_total::where('item_id', $itemo->item_id)->where('stock_id',$itemo->order->stock_id)
    ->where('expired_date', $itemo->expired_date)->where('batch_no', $itemo->batch_no)->first();
    $dateBatch =null;
    if($data){
        $dateBatch = date_create($data->expired_date);

    }
    ?>
    <input type="text" id="upselectBatch{{$counter}}" name="upselectBatch{{$counter}}" readonly value="{{$data->batch_no ?? ''}} /@if($dateBatch){{ date_format($dateBatch, 'Y-m-d')}}@endif /{{$data->item_total_qty ?? ''}}">

   <span id="batch_search{{$counter}}" style="display:none;"></span>
    </td>
    <td id="batchNum{{$counter}}" class="batchNum">{{$itemo->batch_no}} </td>
    <?php
   
    $date = date_create($itemo->expired_date);
    ?>
    <td id="batchDate{{$counter}}" class="batchDate">{{ date_format($date, "d-m-Y")}} </td>
    <td id="batchqty{{$counter}}" class="batchqty">{{$data->item_total_qty ?? ''}} </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" style="width: 200px" oninput="itemQty({{$counter}})" value="{{$itemo->item_qty}}" onfocusout="maxQty({{$counter}})" name="upqty{{$counter}}" id="qty{{$counter}}" class="form-control item_quantity" placeholder="">
        </div>
    </td>

    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" step="0.01" style="width: 200px" id="itemprice{{$counter}}" value="{{$itemo->item_price}}" name="upitemprice{{$counter}}" oninput="itemPrice({{$counter}})" class="form-control item_price" placeholder="">
        </div>
    </td>

    <td id="total{{$counter}}" class="total_item_price">
        {{$itemo->total_line_cost}}
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" step="0.01" style="width: 200px" value="{{$itemo->item_disc_perc}}" oninput="disPer({{$counter}})" name="upper{{$counter}}" id="per{{$counter}}" class="form-control item_dis" placeholder="">
        </div>
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" step="0.01" style="width: 200px" value="{{$itemo->item_disc_value}}" oninput="disval({{$counter}})" name="updisval{{$counter}}" id="disval{{$counter}}" class="form-control item_disval" placeholder="">
        </div>
    </td>
    <td id="final{{$counter}}" class="total_item_final">
        {{$itemo->final_line_cost}}
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="text" style="width: 200px" onkeypress="enterForRow(event,{{$counter}})" name="updetNote{{$counter}}" value="{{$itemo->notes}}" class="form-control detNote" placeholder="ملاحظات">
        </div>
    </td>
    <td>
        <div class="product-buttons">
            <button type="button" @if($itemo->order->confirmed==1) disabled @endif data-toggle="modal" data-target="#del{{$counter}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
                        <a href="#" onclick="DeleteOrderItem({{$itemo->id}},{{$counter}})">حـذف</a>
                    </div>
                </div>
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