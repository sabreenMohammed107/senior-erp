<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Stock_transaction_item;
use App\Models\stocks_item_category;
use App\Models\Stocks_items_total;
use App\Models\Stocks_transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as PDF;

class StockEntryController extends Controller
{
    // -- /Reports/Stock/Transactions/Create
    public function index()
    {
        $Stocks = Stock::all();

        return view('Reports.Stock.Transactions.index',[
            'Stocks'=>$Stocks,
        ]);
    }

    // -- /Reports/Stock/Transactions/Fetch
    // http-request[POST]
    public function FetchEntries(Request $request)
    {
        $Transactions = Stocks_transaction::where([['primary_stock_id','=',$request->stock_id],['confirmed','=',1]])
        ->whereBetween('transaction_date', [$request->from_date, $request->to_date])->get();
        $Transaction_Batches = Stocks_items_total::where('stock_id','=',$request->stock_id)->get();
        $Transaction_Items = DB::table('stocks_items_totals')
        ->select(DB::raw('items.ar_name,stock_id, item_id,sum(stocks_items_totals.item_total_qty) as item_total_qty,sum(item_qty_unconfirmed) as item_qty_unconfirmed,items.average_price,sum(items.average_price*stocks_items_totals.item_total_qty) as total_item_price'))
        ->join('items','items.id','=','stocks_items_totals.item_id')
        ->where('stock_id','=',$request->stock_id)
        ->groupBy('stock_id','item_id','items.average_price','items.ar_name')->get();
        // return $Transaction_Items;
        $Stock = Stock::find($request->stock_id);
        $User = User::find(1);
        $data = [
            'Transactions'=>$Transactions,
            'Transaction_Batches'=>$Transaction_Batches,
            'Transaction_Items'=>$Transaction_Items,
            'User'=>$User,
            'Title'=>'قيود المخزن',
            'Today'=>date('d-m-Y', strtotime(now())),
            'from'=>date('d-m-Y', strtotime($request->from_date)),
            'to'=>date('d-m-Y', strtotime($request->to_date)),
            'Stock'=>$Stock,
        ];
        $pdf = PDF::loadView('Reports.Stock.Transactions.report', $data);
        $pdf->allow_charset_conversion = false;
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        return $pdf->stream('stock_entries.pdf');
    }
}
