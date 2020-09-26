<tr data-id="{{$rowCount}}">
    <td>{{$rowCount}}</td>

    <td>
    <input type="number" style="display: none;" value="{{$rowCount}}" name="rowCountStore" id="rowCount"  class="form-control" placeholder="">

        <div class="bt-df-checkbox">
            <input type="hidden" name="" class="inv_type" value="new">
            <input class="cat" onclick="radioSelect({{$rowCount}})" checked="" type="radio" value="no" id="catRadio{{$rowCount}}" name="optionsRadios{{$rowCount}}">
            <label><b> تصنيف </b></label>
            <input class="radio-checked cat" onclick="radioSelect({{$rowCount}})" type="radio" value="yes" id="clientRadio{{$rowCount}}" name="optionsRadios{{$rowCount}}">
            <label><b> عميل </b></label>
        </div>
    </td>

    <td><select id="selectCat{{$rowCount}}" name="selectCat{{$rowCount}}" class="form-control" placeholder="أختر المنتج">
            <option value="">أختر تصنيف</option>
            @foreach ($cats as $cat)
            <option value="{{$cat->id}}">{{$cat->ar_name}} - {{$cat->code}}</option>
            @endforeach
        </select></td>


    <td><select id="selectClient{{$rowCount}}" name="selectClient{{$rowCount}}"  disabled style="display: none" class="form-control chosen-select" placeholder="أختر المنتج">
            <option value="">أختر عميل</option>
            @foreach ($clients as $client)
            <option value="{{$client->id}}">{{$client->name}} - {{$client->code}}</option>
            @endforeach
        </select></td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" onkeypress="enterForRow(event,{{$rowCount}})" id="itemprice{{$rowCount}}" name="item_price{{$rowCount}}"  oninput="itemPrice({{$rowCount}})" value="0" class="form-control item_price" placeholder="">
        </div>
    </td>
    <td>
        <div class="product-buttons">
        <button id="del{{$rowCount}}" onclick="deleteRow({{$rowCount}})" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        </div>
    </td>
</tr>