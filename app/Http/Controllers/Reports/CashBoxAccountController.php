<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Cash_box;
use App\Models\Financial_entry;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as PDF;

class CashBoxAccountController extends Controller
{
    // -- /Reports/CashBox/Account/Create
    public function index()
    {
        $CashBoxes = Cash_box::all();

        return view('Reports.CashBox.Account.index',[
            'CashBoxes'=>$CashBoxes,
        ]);
    }

    // -- /Reports/CashBox/Account/Fetch
    // http-request[POST]
    public function FetchEntries(Request $request)
    {
        $id = $request->id;
        $CashBox = Cash_box::find($id);
        $gl_item_id = $CashBox->gl_item_id;

        // $OpenBalanceEntries = Financial_entry::where([['trans_type_id','=',102],['cash_box_id','=',$id]])->whereBetween('entry_date', [$request->from_date, $request->to_date])->get();
        // $SaleInvoicesEntries = Financial_entry::where([['trans_type_id','=',110 ],['gl_item_id','=',$gl_item_id],['cash_box_id','=',$id]])->whereBetween('entry_date', [$request->from_date, $request->to_date])->get();
        // $ReceiptVoucherEntries = Financial_entry::where([['trans_type_id','=',    112],['cash_box_id','=',$id]])->whereBetween('entry_date', [$request->from_date, $request->to_date])->get(); // سند القبض
        // $ExchangeVoucherEntries = Financial_entry::where([['trans_type_id','=',113],['cash_box_id','=',$id]])->whereBetween('entry_date', [$request->from_date, $request->to_date])->get(); // سند الصرف
        // $DailyVoucherEntries = Financial_entry::where([['trans_type_id','=',115],['cash_box_id','=',$id]])->whereBetween('entry_date', [$request->from_date, $request->to_date])->get(); // سند يومي
    

        $Entries = Financial_entry::where([['cash_box_id','=',$id],['gl_item_id','=',$gl_item_id]])
        ->leftJoin('finan_transaction_types','finan_transaction_types.id','=','financial_entries.trans_type_id')
        ->whereBetween('entry_date', [$request->from_date, $request->to_date])
        ->whereIn('trans_type_id',[102,110,112,113,115])
        ->get();

        $OldEntries = Financial_entry::select(DB::raw('ifnull(sum(ifnull(debit,0)),0) as debit , ifnull(sum(ifnull(credit,0)),0) as credit, ifnull((sum(ifnull(debit,0)) - sum(ifnull(credit,0)) ),0) as total'))
        ->where([['cash_box_id','=',$id],['entry_date','<',$request->from_date],['gl_item_id','=',$gl_item_id]])
        ->whereIn('trans_type_id',[102,110,112,113,115])
        ->first();
        
        $User = User::find(1);
        
        $data = [
            'Entries'=>$Entries,
            'OldEntries'=>$OldEntries,
            'User'=>$User,
            'CashBox'=>$CashBox,
            'Title'=>'تقرير حركة الخزينة',
            'Today'=>date('d-m-Y', strtotime(now())),
            'from'=>$request->from_date, 
            'to'=>$request->to_date,
        ];
        $pdf = PDF::loadView('Reports.CashBox.Account.report', $data ,[], [
            'orientation'=>'P',
        ]);
        $pdf->allow_charset_conversion = false;
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        return $pdf->stream('cash_box_entries.pdf');
    }
}
