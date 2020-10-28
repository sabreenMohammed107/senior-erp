<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Financial_entry;
use App\Models\Glchart_account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BanksController extends Controller
{
    // -- /Financial/Banks
    public function index()
    {
        $Banks = Bank::all();
        return View('Financial.Banks.index',[
            'Banks'=>$Banks,
        ]);
    }

    // -- /Financial/Banks/Add
    public function Add()
    {
        $GLItems = Glchart_account::where('gl_item_level','=',6)->get();
        return view('Financial.Banks.add',[
            'GLItems'=>$GLItems,
        ]);
    }

    // http-request[POST]
    // -- /Financial/Banks/Create
    public function Create(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->merge([
                'current_balance' => $request->open_balance,
            ]);
            $Bank = Bank::create($request->except('_token'));
            $FinancialEntryData = [
                'trans_type_id' => '102',
                'entry_serial'=> '-1',
                'entry_date' => $Bank->balance_start_date,
                'debit' => $Bank->open_balance,
                'gl_item_id' => $Bank->gl_item_id,
                'bank_id' => $Bank->id,
                'entry_statment' => $Bank->notes
            ];
            $Entry = Financial_entry::create($FinancialEntryData);
            DB::commit();
            return redirect('/Financial/Banks')->with('flash_success','تم اضافة البنك بنجاح');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect('/Financial/Banks')->with('flash_danger','لم يتم اضافة البنك');
        }
    }

    // -- /Financial/Banks/Edit/$bank_id
    public function Edit(int $bank_id)
    {
        $Bank = Bank::find($bank_id);
        $GLItems = Glchart_account::where('gl_item_level','=',6)->get();
        return view('Financial.Banks.edit',[
            'GLItems'=>$GLItems,
            'Bank'=>$Bank,
        ]);
    }

    // http-request[POST]
    // -- /Financial/Banks/Update
    public function Update(Request $request)
    {
        $Bank = Bank::find($request->id);
        $Bank->Update($request->except('id'));
        return redirect('/Financial/Banks')->with('flash_success','تم تعديل بيانات البنك بنجاح');
    }

    // -- /Financial/Banks/View/$bank_id
    public function View(int $bank_id)
    {
        $Bank = DB::table('banks')
        ->select(DB::raw('banks.id as id , banks.code as code, banks.current_balance as current_balance ,banks.ar_name,banks.en_name,banks.branch_address,banks.branch_phone,banks.branch_fax,banks.open_balance,banks.balance_start_date,banks.notes,gl_item_level,glchart_accounts.ar_name as gl_name , glchart_accounts.code as gl_code'))
        ->leftjoin('glchart_accounts','glchart_accounts.id','=','banks.gl_item_id')
        ->where('banks.id','=',$bank_id)->first();
        // return $Bank;
        return view('Financial.Banks.view',[
            'Bank'=>$Bank,
        ]);
    }

    // http-request[POST]
    // -- /Financial/Banks/Delete
    public function Delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;
            $Bank = Bank::find($id);
            $Entry = Financial_entry::where([['bank_id','=',$id],['trans_type_id','=',102],['gl_item_id','=',$Bank->gl_item_id]])->delete();
            $Bank->delete();
            DB::commit();
            return redirect('/Financial/Banks')->with('flash_success','تم حذف بيانات البنك بنجاح');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect('/Financial/Banks')->with('flash_success','لم يتم حذف بيانات البنك');
        }

    }
}
