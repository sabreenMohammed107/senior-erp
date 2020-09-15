<!DOCTYPE html>
<html>
<head>
	<title>New Invoice Added</title>  
	<!--<link type="image/x-icon" rel="icon" href="images/icon.ico">-->
	<meta charset="utf-8" />	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

<style>
body {
    margin: 2em;
    font-family: Arial;
}

.tablerounededCorner {
    border: 1px solid #7a7b7b;
    background-color: #54676529;
    /* border-radius: 1.2em; */
}

.roundedTable {
    border-collapse: collapse;
    /* border-radius: 1.2em; */
    overflow: hidden;
    width: 100%;
    margin: 0;
}

.roundedTable th,
.roundedTable td {
    padding: .6em;
    background: #54676529;
    border-bottom: 1px solid white;
}

.roundedTable th {
    text-align: left;
}
th, td {
  border: 1px solid white;
  padding: 8px;
}


/* .roundedTable tr:last-child td {
    border-bottom: none;
} */
th, td {
  border: 1px solid #ccc;
  padding: 8px;
}


</style>
</head>
<body>
<h3>invoice</h3>
<div class="tablerounededCorner">
    <table class="table table-bordered table-striped roundedTable">
    <tr>
            <th data-field="state" data-checkbox="false"></th>
            <th data-field="id">رقم الفاتورة</th>
            <th>تاريخ الفاتورة</th>
            <th>إسم العميل</th>
            <th>حالة الفاتورة</th>
            <th>إجمالي قيمة البنود</th>
            <th>كود الفرع</th>
            <th>إسم الفرع</th>
            <th>كود العميل</th>
            <th>ملاحظات</th>
           
        </tr>
    </thead>

        <tr>
           
            <td></td>
            <td>{{$invoice->INVOICE_NO}}</td>
            <td>
</td>
            <td>{{$invoice->PERSON_NAME}}</td>
            
            <td> حالة الفاتورة</td>
            <td>{{$invoice->TOTAL_ITEMS_PRICE}}</td>
            <td> {{$invoice->branch->code ?? ''}}</td>
            <td>{{$invoice->branch->ar_name ?? ''}}</td>
            <td>{{$invoice->person->PERSON_CODE ?? ''}}</td>
            <td>{{$invoice->NOTES}}</td>
         
        </tr>
       
</table>
    </table>
</div>

</body>
</html>