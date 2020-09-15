
<tr data-id="{{$rowCount}}" >
<input type="hidden" name="rowCount" value="{{$rowCount}}" >

    <td>

    </td>
    <td>

<select id="select{{$rowCount}}" name="select{{$rowCount}}" name="dropname" onchange="editSelectVal({{$rowCount}})" data-placeholder="Choose a Country..." class="chosen-select" tabindex="-1">
    <option value="">Select</option>
    @foreach ($items as $Item)
    <option value="{{$Item->ITEM_ID}}">{{$Item->ITEM_CODE}}/{{$Item->ITEM_AR_NAME}}</option>
    @endforeach
</select>


</td>
<td id="uom{{$rowCount}}" class="uom">حبة</td>
<td id="ar_name{{$rowCount}}" class="ar_name">إسم البند</td>
<td>
        <select id="selectBatch{{$rowCount}}" name="selectBatch{{$rowCount}}" qty onchange="editSelectBatch({{$rowCount}})" data-placeholder="Choose a Country..." class="chosen-select" tabindex="-1">

        </select></td>
    <td id="batchNum{{$rowCount}}" class="batchNum"> </td>
    <td id="batchDate{{$rowCount}}" class="batchDate">
    <td id="batchqty{{$rowCount}}" class="batchqty"> </td>
    <input type="hidden" value="" name="batchNum1{{$rowCount}}"> </td>
    <input type="hidden" value="" name="batchDate1{{$rowCount}}"> </td>
    <input type="hidden" value="" name="batchqty1{{$rowCount}}"> </td>
    <input type="hidden" value="" name="itemprice1{{$rowCount}}"> </td>

    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" oninput="itemBons({{$rowCount}})" value="" name="bonas{{$rowCount}}" id="bonas{{$rowCount}}" class="form-control item_bonas" placeholder="">
        </div>
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" oninput="itemQty({{$rowCount}})" name="qty{{$rowCount}}" id="qty{{$rowCount}}"  class="form-control item_quantity" placeholder="">
        </div>
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number"  id="itemprice{{$rowCount}}" name="itemprice{{$rowCount}}" oninput="itemPrice({{$rowCount}})"  class="form-control item_price" placeholder="">
        </div>
    </td>

    <td id="total{{$rowCount}}" class="total_item_price">
        0
    </td>
    <td> <div class="input-mark-inner mg-b-22">
            <input type="number" step="0.01" oninput="disPer({{$rowCount}})" name="per{{$rowCount}}" id="per{{$rowCount}}"   class="form-control item_dis" placeholder="">
        </div></td>
    <td><div class="input-mark-inner mg-b-22">
            <input type="number" step="0.01" oninput="disval({{$rowCount}})" name="disval{{$rowCount}}" id="disval{{$rowCount}}"  class="form-control item_disval" placeholder="">
        </div></td>
        <td id="final{{$rowCount}}" class="total_item_final">
        {{$itemo->FINAL_LINE_COST ?? ''}}
    </td>
    <td id="totalvat{{$rowCount}}" class="input-mark-inner mg-b-22 vat_tax_value">
    <input type="hidden" value="" name="totalvat1{{$rowCount}}"> 
     0
    </td>
    <td  id="totalcit{{$rowCount}}"  class="input-mark-inner mg-b-22 comm_industr_tax">
    <input type="hidden" value="" name="totalcit1{{$rowCount}}"> 
     0
    </td>
    <td id="finalAll{{$rowCount}}" class="total_items_all">
        {{$itemo->FINAL_LINE_COST ?? ''}}
    </td>
   
   {{--<td>

    <div class="product-buttons">
            <button id="del{{$rowCount}}" onclick="deleteRow({{$rowCount}})" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        
        </div>
  


    </td>--}} 

</tr>

