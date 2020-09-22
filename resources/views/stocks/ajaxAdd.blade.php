<tr data-id="{{$rowCount}}" >
    <td></td>
    <td id="fTd{{$rowCount}}">{{$rowCount}}</td>
    <td>
    <input type="number" style="display: none;" value="{{$rowCount}}" name="rowCount" id="rowCount"  class="form-control " placeholder="">

        <select id="select{{$rowCount}}" name="select{{$rowCount}}" name="dropname" style="width: 200px" onchange="editSelectVal({{$rowCount}})" data-placeholder="Choose a Country..." class="form-control">
            <option value="">Select</option>
            @foreach ($items as $Item)
            <option value="{{$Item->id}}">{{$Item->code}}/{{$Item->ar_name}}</option>
            @endforeach
        </select>
    </td>
    <td id="ar_name{{$rowCount}}"></td>
    <td id="uom{{$rowCount}}"></td>
    <td>
        <div class="input-mark-inner">
            <input type="date" name="batchDate{{$rowCount}}" onchange="batchDate({{$rowCount}})" id="batchDate{{$rowCount}}" class="form-control">
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="text" id="batchNum{{$rowCount}}"  name="batchNum{{$rowCount}}" oninput="batchItem({{$rowCount}})" class="form-control" placeholder="" style="width: 130px">
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="number" name="qty{{$rowCount}}" oninput="itemQty({{$rowCount}})" id="qty{{$rowCount}}"  class="form-control" placeholder="" style="width: 130px">
        </div>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="number" class="form-control" id="itemprice{{$rowCount}}" oninput="itemPrice({{$rowCount}})" name="itemprice{{$rowCount}}" placeholder="" style="width: 130px">
        </div>
    </td>
    <td id="total{{$rowCount}}" class="total_item">
        0
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="text"  id="notes{{$rowCount}}" name="notes{{$rowCount}}" oninput="itemNotes({{$rowCount}})" onkeypress="enterForRow(event,{{$rowCount}})"  class="form-control" placeholder="" style="width: 200px">
        </div>
    </td>
    <td>
        <div class="product-buttons">
        <button id="del{{$rowCount}}" onclick="deleteRow({{$rowCount}})" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        </div>
    </td>
</tr>