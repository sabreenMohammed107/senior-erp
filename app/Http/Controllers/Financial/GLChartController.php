<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Glchart_account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Handler;
use App\Http\Controllers\Financial\Handlers\LevelsHandler;
use App\Models\Financial_entry;
use PhpParser\Node\Expr\AssignOp\Concat;
use stdClass;

class GLChartController extends Controller
{
    // -- /Financial/GLChart
    public function index()
    {
        return view('Financial.GLChart.index');
    }

    // -- /Financial/GLChart/Fetch
    // http-request[get->ajax]
    public function FetchTree()
    {
        $Tree = GLChartController::GetNodeChildren();
        return $Tree;
    }

    // -- /Financial/GLChart/Add
    public function Add(Request $request)
    { 
        $parent_id = $request->id;  
        if ($parent_id == 0) {
            $parent_id = null;
            $parent = new stdClass();
            $parent->gl_item_level = 0;
            $parent->ar_name = "شجرة الحسابات";
            $parent->en_name = "Accounts tree";
            $parent->id  = null;
            $parent->code = '';
        }else{
            $parent = Glchart_account::find($parent_id);
        }
        if ($parent->gl_item_level == 6) {
            return redirect('/Financial/GLChart')->with('flash_info','لا يمكن تجاوز المستوى السادس في شجرة الحسابات');
        }
        $itemsCount = Glchart_account::where('parent_id','=',$parent_id)->count();
        $ChildCode = LevelsHandler::CodeGeneration(($parent->gl_item_level + 1),$itemsCount);
        $FullCode = $parent->code . "" . $ChildCode;
        return view('Financial.GLChart.add', [
            'parent'=>$parent,
            'FullCode'=>$FullCode
        ]);
    }
    
    // -- /Financial/GLChart/Edit
    public function Edit(Request $request)
    {
        if($request->id == 0){
            return redirect('/Financial/GLChart')->with('flash_info','لا يمكن تعديل شجرة الحسابات');
        }
        $id = $request->id;  
        $node = Glchart_account::find($id);
        return view('Financial.GLChart.edit', [
            'node'=>$node,
        ]);
    }

    // -- /Financial/GLChart/Create
    // http-request[POST]
    public function Create(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->merge([
                'system_item'=>0,
            ]);
            $Account = Glchart_account::create($request->all());
            $EntryData = [
                'entry_serial' => -1,
                'trans_type_id' => 102,
                'entry_date' => $request->open_balance_date,
                'gl_item_id' => $Account->id,
            ]; 

            if ($request->balance_type == 0) {
                $EntryData['debit'] = $request->open_balance;
                $EntryData['credit'] = 0;
            }else{
                $EntryData['credit'] = $request->open_balance;
                $EntryData['debit'] = 0;
            }

            $Entry = Financial_entry::create($EntryData);
            DB::commit();
            return redirect('/Financial/GLChart')->with('flash_success','تم حفظ بيانات الحساب بنجاح');
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return redirect('/Financial/GLChart')->with('flash_danger','لم يتم حفظ بيانات الحساب .. حاول مرة أخرى');
        }
    }

    // -- /Financial/GLChart/Update
    // http-request[POST]
    public function Update(Request $request)
    {
        $id = $request->id;
        $Node = Glchart_account::find($id);
        $Account = $Node->update($request->all());

        return redirect('/Financial/GLChart')->with('flash_success','تم تعديل بيانات الحساب بنجاح');

    }

    // -- /Financial/GLChart/Delete/{id}
    public function Delete(int $id)
    {
        $Node = Glchart_account::find($id);
        
        //First check
        $EntryCounter = Financial_entry::where([['gl_item_id','=',$id],['trans_type_id','<>',102]])->count();
        //Second check
        $SubAccountsCounter = Glchart_account::where('parent_id','=',$id)->count();

        if($EntryCounter == 0 && $SubAccountsCounter == 0){
            DB::beginTransaction();
            try {
                $Entry = Financial_entry::where('gl_item_id','=',$id)->delete();
                $Node->delete();
                DB::commit();
                return redirect('/Financial/GLChart')->with('flash_success','تم حذف بيانات الحساب بنجاح');

            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return redirect('/Financial/GLChart')->with('flash_danger','لم يتم حذف بيانات الحساب لوجود خطأ ما ');
            }
        }else{
            return redirect('/Financial/GLChart')->with('flash_danger','لم يتم حذف بيانات الحساب لوجود عمليات تمت على هذا الحساب ');
        }
    }

    static public function GetNodeChildren(int $parent_id = null)
    {
        
        $GLChart = Glchart_account::where('parent_id','=',$parent_id)->get();
        $Tree = array();
        foreach ($GLChart as $i => $acc) {
            $node = $acc;
            $node->text = $acc->ar_name;
            if(Glchart_account::where('parent_id','=',$acc->id)->count()){
            $node->items = GLChartController::GetNodeChildren($acc->id);
            }
            $Tree[] = $node;
        }
        return $Tree;
    }
}
