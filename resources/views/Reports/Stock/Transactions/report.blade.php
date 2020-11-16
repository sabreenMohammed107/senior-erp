<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$Title}}</title>
    <style>
@page {
	header: page-header;
    footer: page-footer;
    margin-top: 200px;
}
html,body,.body{
    box-sizing: border-box;
}
.body-page{
    padding: 35px 0 0;
    direction: ltr;
    /* background: #ddd; */
    width: 100%;
}
.header{
    padding: 25px 10px;
    width: 30%;
    font-size: 10px;
    text-align: center;
    float: left;
}
.footer{
    padding: 5px 10px;
    width: 20%;
    font-size: 10px;
    text-align: center;
}
.report-header{
    float: right;
    width: 40%;
    display: inline-block;
}
.date{
    float: right;
    padding: 10px;
    width: 40%;
    font-size: 12px;
    text-align: center;
}
.image{
    width: 100%;
    text-align: left ;
    clear: both;
    padding: 30px 50px 10px 10px;

    /* background: #021625; */
}
.company{
    width: 100%;
    /* background: #255; */
}
.name{
    background-color: #cecece;
    padding: 10px;
    margin: 10px;
    width: 95px;
    font-size: 12px;
    float: right;
}
.off_name{
    padding: 10 20px;
    float: right;
    width: 180px;
}
.rep_name{
    padding: 0px;
    display: inline-block;
    width: 200px;
    float: left;
    font-size: 20px;
    text-align: center;
    margin: 10px auto;
    clear: both;
}
.right{
    margin: 250px 0;
}
.right, .left{
    float: right;
    width:50%;
}
tbody tr{
    /* background: #cecece; */
}
thead tr th{
    font-weight: 100;
    font-size: 12px;
    padding: 10px;
}
tbody tr td,th{
    color: #222 !important;
    font-size: 12px;
    font-size: 12px;
    border: #222 solid 1px;
    text-align: center;
}

    </style>
</head>
<body>
    <div class="body">
        <span>
            <div class="body-page">
                <htmlpageheader name="page-header">
                    <div class="image" dir="rtl">
                        <span><img height="50" style="text-align: right;" src="{{public_path('/webassets/img/logo/logo.png')}}" /></span>
                    </div>
                    <div class="rep_name">
                        <span>{{$Title}}</span>
                    </div>
                    <div style="clear: both"></div>
                    <div class="from-to" style="margin-top:20px;text-align:right;">
                        <span style="font-size:14px;" dir="rtl"><b>المخزن</b> : {{$Stock->code}} - {{$Stock->ar_name}}</span>
                    </div>
                    <div class="from-to" style="margin-top:20px;text-align:right;">
                        <span style="font-size:12px;" dir="rtl"><b>من</b> : {{$from}} - <b>الي</b> : {{$to}}</span>
                    </div>
<hr>
                </htmlpageheader>

                <htmlpagefooter name="page-footer">
                    <div class="header">
                        <span>{{$Today}}</span>
                    </div>
                    <div class="header">
                        <span>الصفحة رقم : {PAGENO} / {nbpg}</span>
                    </div>
                    <div class="header">
                        <span dir="rtl">اسم المستخدم : {{$User->name}}</span>
                    </div>
                    {{-- <div class="footer">
                        <span>{{$Title}}</span>
                    </div> --}}
                </htmlpagefooter>
            </div>
        </span>
    </div>
    @foreach ($Transactions as $Entry)
    <div class="from-to" style="margin-top:20px;text-align:right;">
        <span style="font-size:14px;" dir="rtl"><b>نوع الحركة</b> : {{$Entry->type->name}}</span>
    </div>
    <div class="from-to" style="margin:10px 0px;text-align:right;">
        <span style="font-size:14px;" dir="rtl"><b>تاريخ الحركة</b> : {{date('d-m-Y', strtotime($Entry->transaction_date))}}</span>
    </div>
        <table dir="rtl" style="width:100%;border-collapse: collapse;border:1px solid #000;">
            <thead>
                <tr style="background-color: #cecece;">
                    <th>اسم الصنف</th>
                    <th>وحدة القياس</th>
                    <th>رقم الباتش</th>
                    <th>تاريخ انتهاء الصلاحية</th>
                    <th>الكمية</th>
                    <th>اجمالي السعر</th>
                    <th>كمية بونص</th>
                    <th>الملاحظات</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($Entry->item as $TransItem)
       
                <tr>
                    <td>{{$TransItem->item->ar_name}}</td>
                    <td>{{$TransItem->item->uom->ar_name}}</td>
                    <td>{{$TransItem->batch_no}}</td>
                    <td>{{date('d-m-Y', strtotime($TransItem->expired_date))}}</td>
                    <td>{{$TransItem->item_qty}}</td>
                    <td>{{$TransItem->item_qty * $TransItem->item->average_price}}</td>
                    <td>{{$TransItem->item_bonus_qty}}</td>
                    <td>{{$TransItem->notes}}</td>
                </tr>
            
        @endforeach
    </tbody>
</table>
    @endforeach
    <hr>
    <div class="from-to" style="margin-top:20px;text-align:right;">
        <span style="font-size:14px;" dir="rtl"><b>المخزن</b> : {{$Stock->code}}</span>
    </div><br>
    <table dir="rtl" style="width:100%;border-collapse: collapse;border:1px solid #000;">
        <thead>
            <tr style="background-color: #cecece;">
                <th>اسم الصنف</th>
                <th>وحدة القياس</th>
                <th>رقم الباتش</th>
                <th>تاريخ انتهاء الصلاحية</th>
                <th>الكمية</th>
                <th>اجمالي السعر</th>
                <th>كمية غير مؤكده</th>
                <th>الملاحظات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Transaction_Batches as $Batch)
                <tr>
                    <td>{{$Batch->item->ar_name}}</td>
                    <td>{{$Batch->item->uom->ar_name}}</td>
                    <td>{{$Batch->batch_no}}</td>
                    <td>{{date('d-m-Y', strtotime($Batch->expired_date))}}</td>
                    <td>{{$Batch->item_total_qty}}</td>
                    <td>{{$Batch->item->average_price*$Batch->item_total_qty}}</td>
                    <td>{{$Batch->item_qty_unconfirmed}}</td>
                    <td>{{$Batch->notes}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <table dir="rtl" style="width:100%;border-collapse: collapse;border:1px solid #000;">
        <thead>
            <tr style="background-color: #cecece;">
                <th>اسم الصنف</th>
                <th>اجمالي الكمية</th>
                <th>اجمالي السعر</th>
                <th>كمية غير مؤكده</th>
                <th>متوسط السعر</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Transaction_Items as $Item)
                <tr>
                    <td>{{$Item->ar_name}}</td>
                    <td>{{$Item->item_total_qty}}</td>
                    <td>{{$Item->total_item_price}}</td>
                    <td>{{$Item->item_qty_unconfirmed}}</td>
                    <td>{{$Item->average_price}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
