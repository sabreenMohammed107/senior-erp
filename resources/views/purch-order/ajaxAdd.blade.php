<tr data-id="{{$rowCount}}">
    <input type="hidden" name="rowCount" value="{{$rowCount}}" >
    <td> <input style="width: 30px;" type="number" readonly id="firstTT{{$rowCount}}"  value="{{$rowCount}}" ></td>
    <td>
   
        <select id="select{{$rowCount}}" name="select{{$rowCount}}" name="dropname" style="width: 200px" onchange="editSelectVal({{$rowCount}})" data-placeholder="Choose a Country..." class="chosen-select" >
            <option value="">Select</option>
            @foreach ($items as $Item)
            <option value="{{$Item->id}}">{{$Item->code}}/{{$Item->ar_name}}</option>
            @endforeach
        </select>
        <span id="item_search{{$rowCount}}" style="display:none;"></span>


    </td>
    <td id="uom{{$rowCount}}" class="uom">حبة</td>
    <td id="ar_name{{$rowCount}}"  class="ar_name">إسم البند</td>
   
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" style="width: 200px" value="0" readonly  oninput="itemLimit({{$rowCount}})" onfocusout="maxQty({{$rowCount}})" name="qtyLimit{{$rowCount}}" id="qtyLimit{{$rowCount}}"  class="form-control item_quantity" placeholder="">
        </div>
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" style="width: 200px" value="0"  oninput="itemQty({{$rowCount}})" onfocusout="maxQty({{$rowCount}})" name="qty{{$rowCount}}" id="qty{{$rowCount}}"  class="form-control item_quantity" placeholder="">
        </div>
    </td>
   
    <td>
        <div class="input-mark-inner mg-b-22" >
          <input type="number" step="0.01" style="width: 200px" value="0" id="itemprice{{$rowCount}}" value="" name="itemprice{{$rowCount}}" oninput="itemPrice({{$rowCount}})"  class="form-control item_price" placeholder="">
        </div>
    </td>

    <td id="total{{$rowCount}}" class="total_item_price">
        0
    </td>
   
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="text" style="width: 200px" onkeypress="enterForRow(event,{{$rowCount}})" name="detNote{{$rowCount}}" class="form-control detNote" placeholder="ملاحظات">
        </div>
    </td>
    <td>
        <div class="product-buttons">
            <button id="del{{$rowCount}}" onclick="deleteRow({{$rowCount}})" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        
        </div>
    </td>
</tr>