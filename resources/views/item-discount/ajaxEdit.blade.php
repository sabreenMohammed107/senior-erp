
<?php

$counter = 1;

?>
<?php
$counterrrr = 1;
?>

@foreach($discountItems as $i=> $itemo)

<tr data-id="{{$counter}}">
    <td>{{$counter}}</td>

    <td>
    <input type="number" style="display: none;" value="{{$itemo->id}}" name="item_price_id{{$counter}}" id="item_price_id{{$counter}}"  class="form-control " placeholder="">

    <input type="number" style="display: none;" value="{{$counter}}" name="counterStore" id="counter"  class="form-control" placeholder="">

        <div class="bt-df-checkbox">
            <input type="hidden" name="" class="inv_type" value="new">
            <input class="cat" disabled onclick="radioSelect({{$counter}})" @if($itemo->item_discount_type_id=101) checked @endif type="radio" value="no" id="catRadio{{$counter}}" name="optionsRadios{{$counter}}">
            <label><b> تصنيف </b></label>
            <input class="radio-checked cat" disabled onclick="radioSelect({{$counter}})" @if($itemo->item_discount_type_id=100) checked @endif type="radio" value="yes" id="clientRadio{{$counter}}" name="optionsRadios{{$counter}}">
            <label><b> عميل </b></label>
        </div>
    </td>

    <td><select id="selectCat{{$counter}}" name="selectCatup{{$counter}}" disabled class="form-control" placeholder="أختر المنتج">
            <option value=""> {{$itemo->category->ar_name ?? ''}} - {{$itemo->category->code ?? ''}} </option>
            @foreach ($cats as $cat)
            <option value="{{$cat->id}}">{{$cat->ar_name}} - {{$cat->code}}</option>
            @endforeach
        </select>

        <span id="item_cat{{$counter}}" style="display:none;">{{$itemo->category->ar_name ?? ''}} - {{$itemo->category->code ?? ''}}</span>
        </td>
    <td><select id="selectClient{{$counter}}" name="selectClientup{{$counter}}"  disabled style="display: none" class="form-control chosen-select" placeholder="أختر المنتج">
            <option value="">{{$itemo->client->name ?? ''}} - {{$itemo->client->code ?? ''}}</option>
            @foreach ($clients as $client)
            <option value="{{$client->id}}">{{$client->name}} - {{$client->code}}</option>
            @endforeach
        </select>
        <span id="item_client{{$counter}}" style="display:none;">{{$itemo->client->name ?? ''}} - {{$itemo->client->code ?? ''}}</span>

    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" onkeypress="enterForRow(event,{{$counter}})" id="itemprice{{$counter}}" name="item_priceup{{$counter}}"  oninput="itemPrice({{$counter}})" value="{{$itemo->item_discount_price}}" class="form-control item_price" placeholder="">
        </div>
        <span style="display:none;" id="total_item_price{{$counter}}"  class="total_item_price" placeholder="">{{$itemo->item_discount_price}}</span>

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
            </div>
            <div class="modal-footer info-md">
                <a data-dismiss="modal" href="#">إلغــاء</a>
                <a href="#" onclick="DeletePriceItem({{$itemo->id}},{{$counter}})">حـذف</a>
            </div>
        </div>
    </div>
</div>
<!--/Delete-->
    </td>
</tr>

<?php
++$counter;

if ($counter > count($discountItems)) {
?>
    @break
<?php }
$counterrrr++;
?>

@endforeach
<input type="number" step=".01" style="display: none;" value="{{$counterrrr}}" name="qqq" class="form-control item_quantity" placeholder="">