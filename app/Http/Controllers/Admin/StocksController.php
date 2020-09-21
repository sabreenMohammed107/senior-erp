<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Item_category;
use App\Models\Stock;
use App\Models\Stocks_items_total;
use App\Models\Transaction_type;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class StocksController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Stock $object)
    {

        $this->object = $object;
        $this->viewName = 'stocks.';
        $this->routeName = 'stocks.';

        $this->message = 'تم حفظ البيانات';
        $this->errormessage =  "لم يتم حفظها بسبب خطأ ما حاول مرة أخرى و تأكد من البيانات المدخله";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //static user this will be logined
        $user = User::where('id', 1)->first();
        $branches = $user->branch;
        $row = new Branch();
        $branch_id = 0;
        $stocks = Stock::where('branch_id', $branch_id)->get();

        return view($this->viewName . 'index', compact('branches', 'row', 'stocks'));
    }
    /*

*/
    public function branchFetch(Request $request)
    {
        $branch_id = $request->input('branch_id');
        $row = Branch::where('id', $branch_id)->first();
        $stocks = Stock::where('branch_id', $branch_id)->get();

        return view($this->viewName . 'preIndex', compact('row', 'stocks'))->render();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function creation(Request $request)
    {

        $id = $request->input('branch');

        $branch = Branch::where('id', $id)->first();

        return view($this->viewName . 'add', compact('branch'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $max = Stock::where('branch_id', $request->input('branch_id'))->latest('code')->first();

        $max = ($max != null) ? intval($max['code']) : 0;
        $max++;

        $data = [
            'code' => $max,
            'ar_name' => $request->input('ar_name'),
            'en_name' => $request->input('en_name'),
            'open_balance_date' => Carbon::parse($request->get('open_balance_date')),
            'notes' => $request->input('notes'),
            'branch_id' => $request->input('branch_id'),
        ];
        try {
            $this->object::create($data);
        } catch (QueryException $q) {

            return redirect()->route($this->routeName . 'index')->with('flash_danger', $this->errormessage);
        }


        return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Stock::where('id', $id)->first();

        $branch = Branch::where('id', $row->branch_id)->first();

        return view($this->viewName . 'view', compact('branch', 'row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Stock::where('id', $id)->first();

        $branch = Branch::where('id', $row->branch_id)->first();
        $exception = $row->category->pluck('id')->toArray();
        $typ = $row->type->pluck('id')->toArray();



        $subCats = Item_category::whereNotNull('parent_id')->whereNotIn('id',$exception)->get();
        $transactionTypes=Transaction_type::whereNotIn('id', $typ)->get();
        $totals=Stocks_items_total::where('stock_id',$id)->get();
        return view($this->viewName . 'edit', compact('branch', 'row', 'subCats','transactionTypes','totals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [
            'ar_name' => $request->input('ar_name'),
            'en_name' => $request->input('en_name'),
            'open_balance_date' => Carbon::parse($request->get('open_balance_date')),
            'notes' => $request->input('notes'),
            'branch_id' => $request->input('branch_id'),
        ];
        try {
            $this->object::findOrFail($id)->update($data);
        } catch (QueryException $q) {

            return redirect()->route($this->routeName . 'index')->with('flash_danger', $this->errormessage);
        }


        return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Stock::where('id', $id)->first();
        // Delete File ..


        try {
            $row->delete();
        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'هذا الجدول مرتبط ببيانات أخرى');
        }
        return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');
    }
    
    /**
     * 
     */
    public function stockCategory(Request $request)
    {
        // users_stocks
        $stockId = $request->input('stockCat');
        $categories = $request->input('categories');
        $row = Stock::where('id', '=', $stockId)->first();
        if ($categories) {

            $row->category()->sync($categories);
        } else {
            $row->category()->detach();
        }

        return redirect()->back()->with('flash_success', 'تم التعديل بنجاح !');
    }

    /**
     * 
     */
    public function stockTransaction(Request $request)
    {
        // users_stocks
        $stockId = $request->input('stockTrans');
        $types = $request->input('types');
        $row = Stock::where('id', '=', $stockId)->first();
        if ($types) {

            $row->type()->sync($types);
        } else {
            $row->type()->detach();
        }

        return redirect()->back()->with('flash_success', 'تم التعديل بنجاح !');
    }
}
