<tr  data-id="{{$rowCountt}}" >
    <input type="hidden" name="rowCountt" value="{{$rowCountt}}">
    <td> <input style="width: 30px;" type="number" readonly id="first_id{{$rowCountt}}" value="{{$rowCountt}}"></td>
    <td>
        <select data-placeholder="Choose a Country..." id="select_add{{$rowCountt}}" name="select_add{{$rowCountt}}" class="form-control" style="width: 130px">
        @foreach ($locals as $Item)
            <option value="{{$Item->id}}">{{$Item->name}}</option>
            @endforeach
        </select>
    </td>
    <td>
        <div class="input-mark-inner">
            <input type="text" class="form-control" oninput="localStyle({{$rowCountt}})" id="localVal{{$rowCountt}}" name="localVal{{$rowCountt}}" placeholder="200" style="width: 130px">
        </div>
    </td>
    <td>
        <div class="product-buttons">
            <button data-toggle="modal" type="button" onclick="deleteLocalRow({{$rowCountt}})" data-target="#del" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        </div>
    </td>
</tr>