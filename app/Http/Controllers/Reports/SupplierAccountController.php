<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Financial_entry;
use App\Models\Financial_subsystem;
use App\Models\Person;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as PDF;

class SupplierAccountController extends Controller
{
    // -- /Reports/Supplier/Account/Create
    public function index()
    {
        $Suppliers = Person::where('person_type_id','=',100)->get();

        return view('Reports.Supplier.Account.index',[
            'Suppliers'=>$Suppliers,
        ]);
    }

    // -- /Reports/Supplier/Account/Fetch
    // http-request[POST]
    public function FetchEntries(Request $request)
    {
        $id = $request->id;
        $Supplier = Person::find($id);
        $gl_item_110 = Financial_subsystem::find(110);
        $gl_item_id_110 = $gl_item_110->gl_item_id;
        $gl_item_107 = Financial_subsystem::find(107);
        $gl_item_id_107 = $gl_item_107->gl_item_id;

        $Entries = Financial_entry::leftJoin('finan_transaction_types','finan_transaction_types.id','=','financial_entries.trans_type_id')
        ->where('person_id','=',$id)
        ->where(function (Builder $query) use ($gl_item_id_110, $gl_item_id_107){
            $query->where('trans_type_id','=',102)
            ->orWhere([['trans_type_id', '=', 101],['gl_item_id','=',$gl_item_id_110]])
            ->orWhere([['trans_type_id', '=', 113],['gl_item_id','=',$gl_item_id_110]])
            ->orWhere([['trans_type_id', '=', 108],['gl_item_id','=',$gl_item_id_107]])
            ->orWhere([['trans_type_id', '=', 115],['gl_item_id','=',$gl_item_id_110]]);
        })
        ->whereBetween('entry_date', [$request->from_date, $request->to_date])
        ->get();

        $OldEntries = Financial_entry::select(DB::raw('ifnull(sum(ifnull(debit,0)),0) as debit , ifnull(sum(ifnull(credit,0)),0) as credit, ifnull((sum(ifnull(debit,0)) - sum(ifnull(credit,0)) ),0) as total'))
        ->where([['person_id','=',$id],['entry_date','<',$request->from_date]])
        ->where(function (Builder $query) use ($gl_item_110, $gl_item_107){
            $query->where('trans_type_id','=',102)
            ->orWhere([['trans_type_id', '=', 101],['gl_item_id','=',$gl_item_110]])
            ->orWhere([['trans_type_id', '=', 113],['gl_item_id','=',$gl_item_110]])
            ->orWhere([['trans_type_id', '=', 108],['gl_item_id','=',$gl_item_107]])
            ->orWhere([['trans_type_id', '=', 115],['gl_item_id','=',$gl_item_110]]);
        })
        ->first();
        
        $User = User::find(1);
        
        $data = [
            'Entries'=>$Entries,
            'OldEntries'=>$OldEntries,
            'User'=>$User,
            'Supplier'=>$Supplier,
            'Title'=>'تقرير حركات مورد',
            'Today'=>date('d-m-Y', strtotime(now())),
            'from'=>$request->from_date, 
            'to'=>$request->to_date,
        ];
        $pdf = PDF::loadView('Reports.Supplier.Account.report', $data ,[], [
            'orientation'=>'P',
        ]);
        $pdf->allow_charset_conversion = false;
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        return $pdf->stream('supplier_transactions.pdf');
    }
}
