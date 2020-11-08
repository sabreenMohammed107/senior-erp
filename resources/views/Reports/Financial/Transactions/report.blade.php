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
    margin-top: 165px;
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
    <hr>
    <div class="body">
        <span>
            <div class="body-page">
                <htmlpageheader name="page-header">
                    <div class="image" dir="rtl">
                        <span><img height="50" style="text-align: right;" src="{{public_path('/webassets/img/logo/logo.png')}}" /></span>
                    </div>
                    <div class="from-to" style="margin-top:20px;text-align:right;">
                        <span style="font-size:12px;" dir="rtl">من : {{$from}} - الي : {{$to}}</span>
                    </div>
                    <div class="rep_name">
                        <span>{{$Title}}</span>
                    </div>

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
    <table dir="rtl" style="width:100%;border-collapse: collapse;border:1px solid #000;">
        <thead>
            <tr style="background-color: #cecece;">
                <th>المسلسل</th>
                <th>نوع القيد</th>
                <th>التاريخ</th>
                <th>كود الحساب</th>
                <th>اسم الحساب</th>
                <th>مدين</th>
                <th>دائن</th>
                <th>كود الشخص</th>
                <th>اسم الشخص</th>
                <th>كود الخزينه</th>
                <th>اسم الخزينة</th>
                <th>كود المخزن</th>
                <th>اسم المخزن</th>
                <th>كود الفرع</th>
                <th>اسم الفرع</th>
                <th>البيان</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($Entries as $i => $Entry)
                <tr>
                    <td style="padding: 10px;">{{$Entry->entry_serial}}</td>
                    <td>{{$Entry->trans_name}}</td>
                    <td>{{date('d-m-Y', strtotime($Entry->entry_date))}}</td>
                    <td>{{$Entry->gl_code}}</td>
                    <td>{{$Entry->gl_name}}</td>
                    <td>{{$Entry->debit}}جم</td>
                    <td>{{$Entry->credit}}جم</td>
                    <td>{{$Entry->person_code}}</td>
                    <td>{{$Entry->person_name}}</td>
                    <td>{{$Entry->cash_code}}</td>
                    <td>{{$Entry->cash_name}}</td>
                    <td>{{$Entry->stock_code}}</td>
                    <td>{{$Entry->stock_name}}</td>
                    <td>{{$Entry->branch_code}}</td>
                    <td>{{$Entry->branch_name}}</td>
                    <td>{{$Entry->entry_statment}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
