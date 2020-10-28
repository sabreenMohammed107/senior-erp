<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Cash_box;
use App\Models\Financial_entry;
use App\Models\Glchart_account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashBoxController extends Controller
{
    // -- /Financial/CashBox
    public function index()
    {
        $CashBoxes = Cash_box::all();
        return view('Financial.CashBox.index',[
            'CashBoxes'=>$CashBoxes,
        ]);
    }

    // -- /Financial/CashBox/Add
    public function Add()
    {
        $GLItems = Glchart_account::where('gl_item_level','=',6)->get();
        $User = User::find(1);
        if(empty($User)){
            return 'check default user id (1)!';
        }
        $UserBranches = $User->branch;
        return view('Financial.CashBox.add',[
            'UserBranches'=>$UserBranches,
            'GLItems'=>$GLItems,
        ]);
    }

    // http-request[POST]
    // -- /Financial/CashBox/Create
    public function Create(Request $request)
    {
        DB::beginTransaction();
        try {
            $Box = Cash_box::create($request->except('_token'));
            $FinancialEntryData = [
                'trans_type_id' => '102',
                'entry_serial'=> '-1',
                'entry_date' => $Box->balance_start_date,
                'branch_id'=>$Box->branch_id,
                'debit' => $Box->open_balance,
                'gl_item_id' => $Box->gl_item_id,
                'cash_box_id' => $Box->id,
                'entry_statment' => $Box->notes
            ];
            $Entry = Financial_entry::create($FinancialEntryData);
            DB::commit();
            return redirect('/Financial/CashBox')->with('flash_success','تم اضافة الخزينة بنجاح');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect('/Financial/CashBox')->with('flash_danger','لم يتم اضافة الخزينة');
        }
    }

    // -- /Financial/CashBox/Edit/$cash_box_id
    public function Edit(int $cash_box_id)
    {
        $CashBox = Cash_box::find($cash_box_id);
        $GLItems = Glchart_account::where('gl_item_level','=',6)->get();
        $User = User::find(1);
        $UserBranches = $User->branch;
        return view('Financial.CashBox.edit',[
            'UserBranches'=>$UserBranches,
            'GLItems'=>$GLItems,
            'CashBox'=>$CashBox,
        ]);
    }

    // http-request[POST]
    // -- /Financial/CashBox/Update
    public function Update(Request $request)
    {
        $Box = Cash_box::find($request->id);
        $Box->Update($request->except('id'));
        return redirect('/Financial/CashBox')->with('flash_success','تم تعديل بيانات الخزينة بنجاح');
    }

    // -- /Financial/CashBox/View
    public function View($cash_box_id)
    {
        $CashBox = Cash_box::find($cash_box_id);
        return view('Financial.CashBox.view',[
            'CashBox'=>$CashBox,
        ]);
    }

    // http-request[POST]
    // -- /Financial/CashBox/Delete
    public function Delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;
            $Box = Cash_box::find($id);
            $Entry = Financial_entry::where([['cash_box_id','=',$id],['trans_type_id','=',102],['gl_item_id','=',$Box->gl_item_id]])->delete();
            $Box->delete();
            DB::commit();
            return redirect('/Financial/CashBox')->with('flash_success','تم حذف بيانات الخزينة بنجاح');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect('/Financial/CashBox')->with('flash_success','لم يتم حذف بيانات الخزينة');
        }
    }
}
