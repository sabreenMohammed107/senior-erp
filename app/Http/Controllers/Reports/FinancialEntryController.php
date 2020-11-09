<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Finan_transaction_type;
use App\Models\Person;
use App\Models\Stock;
use App\Models\Transaction_type;
use App\Models\Users_branch;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as PDF;

class FinancialEntryController extends Controller
{
    // -- /Reports/Financial/Transactions/Create
    public function index()
    {
        $Persons = Person::all();
        $UserBranches = DB::table('users_branches')
        ->join('branches','branches.id','=','users_branches.branch_id')
        ->where('user_id','=',1)->get();
        $Stocks = Stock::all();
        $Transactions_Types = Finan_transaction_type::all();

        return view('Reports.Financial.Transactions.index',[
            'Persons'=>$Persons,
            'Branches'=>$UserBranches,
            'Stocks'=>$Stocks,
            'Transactions_Types'=>$Transactions_Types,
        ]);
    }

    // -- /Reports/Financial/Transactions/Fetch
    // http-request[POST]
    public function FetchEntries(Request $request)
    {
        $Transactions = DB::table('financial_entries')
        ->select(DB::raw('finan_transaction_types.name as trans_name,entry_serial,entry_date,glchart_accounts.code as gl_code,
                glchart_accounts.ar_name as gl_name,debit,credit,persons.code as person_code,persons.name as person_name,
                cash_boxes.code as cash_code, cash_boxes.ar_name as cash_name,stocks.ar_name as stock_name, stocks.code as stock_code,
                branches.code as branch_code,branches.ar_name as branch_name,entry_statment
        '))
        ->whereBetween('entry_date', [$request->from_date, $request->to_date]);
        if(!empty($request->transaction_type_id)){
            $Transactions->where('trans_type_id','=',$request->transaction_type_id);
        }
        if(!empty($request->branch_id)){
            $Transactions->where('financial_entries.branch_id','=',$request->branch_id);
        }
        if(!empty($request->stock_id)){
            $Transactions->where('stock_id','=',$request->stock_id);
        }
        if(!empty($request->person_id)){
            $Transactions->where('person_id','=',$request->person_id);
        }
        $Transactions
        ->leftJoin('glchart_accounts','glchart_accounts.id','=','financial_entries.gl_item_id')
        ->leftJoin('cash_boxes','cash_boxes.id','=','financial_entries.cash_box_id')
        ->leftJoin('finan_transaction_types','finan_transaction_types.id','=','financial_entries.trans_type_id')
        ->leftJoin('branches','branches.id','=','financial_entries.branch_id')
        ->leftJoin('stocks','stocks.id','=','financial_entries.stock_id')
        ->leftJoin('persons','persons.id','=','financial_entries.person_id');
        $Entries = $Transactions->get();
        $User = User::find(1);
        
        $data = [
            'Entries'=>$Entries,
            'User'=>$User,
            'Title'=>'القيود المحاسبية',
            'Today'=>date('d-m-Y', strtotime(now())),
            'from'=>$request->from_date, 
            'to'=>$request->to_date,
        ];
        $pdf = PDF::loadView('Reports.Financial.Transactions.report', $data ,[], [
            'orientation'=>'L',
        ]);
        $pdf->allow_charset_conversion = false;
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        return $pdf->stream('finan_entries.pdf');
    }
}
