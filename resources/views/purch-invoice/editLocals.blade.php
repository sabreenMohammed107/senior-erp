<?php

use App\Models\Stocks_items_total;

$localCountt = 1;

?>
<?php
$counterrrr = 1;
?>

@foreach($localsItems as  $itemo)
<tr data-id="{{$localCountt}}">
    <input type="hidden" name="localCountt" value="{{$localCountt}}">
    <td> <input style="width: 30px;" type="number" readonly id="first_id{{$localCountt}}" value="{{$localCountt}}"></td>
    <td>
       
        <select data-placeholder="Choose a Country..." disabled id="select_add{{$localCountt}}" name="select_add{{$localCountt}}" class="form-control" style="width: 130px">
            @foreach ($locals as $Item)
            <option @if ($itemo->additive_item_id == $Item->id)
                selected="selected"
                @endif
                value="{{$Item->id}}">{{$Item->name}}</option>
            @endforeach
        </select>
    </td>
    <td>
    
        <div class="input-mark-inner">
            <input type="text" class="form-control" value="{{$itemo->additive_item_value}}" oninput="localStyle({{$localCountt}})" id="localVal{{$localCountt}}" name="localVal{{$localCountt}}" placeholder="200" style="width: 130px">
        </div>
    </td>
    <td>
    <div class="product-buttons">
           <button type="button" data-toggle="modal" data-target="#del{{$localCountt}}" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
          
        </div>
        <!--Delete-->
        <div id="del{{$localCountt}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
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
                        <h4>هل تريد حذف هذه الأضافات ؟ </h4>
                        <h4>سيتم حذف هذه الإضافات كليا من الجداول المربوطه بها   </h4>
                    </div>
                    <div class="modal-footer info-md">
                        <a data-dismiss="modal" href="#">إلغــاء</a>
                       <a href="#" onclick="DeleteLocalItem({{$itemo->id}},{{$localCountt}})">حـذف</a>
                       </div>
                </div>
            </div>
        </div> 
        <!--/Delete-->
    </td>
</tr>
<?php
++$localCountt;
$counterrrr++;
if (is_countable($localsItems)) {
    if ($localCountt > count($localsItems)) {


?>

        @break
<?php
    }
}

?>
@endforeach