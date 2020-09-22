<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Item;
use App\Models\Item_category;
use App\Models\Person;
use App\Models\Stock;
use App\Models\Stock_transaction_item;
use App\Models\Stocks_items_total;
use App\Models\Stocks_transaction;
use App\Models\Transaction_type;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
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
            DB::transaction(function () use ($data,  $request) {
                $user = User::where('id', 1)->first();

               $stock= $this->object::create($data);
               $user->stock()->attach($stock);
              

            });
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
        $subCats = Item_category::whereNotNull('parent_id')->whereNotIn('id', $exception)->get();
        $transactionTypes = Transaction_type::whereNotIn('id', $typ)->get();
        $totals = Stocks_items_total::where('stock_id', $id)->get();
        return view($this->viewName . 'edit', compact('branch', 'row', 'subCats', 'transactionTypes', 'totals'));
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


    /***
     * openBalance
     */
    public function openBalance($id)
    {
        $row = Stock::where('id', $id)->first();
        $persons = Person::where('person_type_id', 100)->get();
        $exception = $row->category->pluck('id')->toArray();
        $items = Item_category::whereNotNull('parent_id')->whereIn('id', $exception)->get();
        $transItems = [];
        $confirmed = 0;
        $stockTran = Stocks_transaction::where('primary_stock_id', $id)->first();
        if ($stockTran) {
            $confirmed = $stockTran->confirmed;
            $transItems = Stock_transaction_item::where('transaction_id', $stockTran->id)->get();
        }
        return view($this->viewName . 'openBalance', compact('row', 'persons', 'items', 'stockTran', 'transItems', 'confirmed'));
    }
    /***
     * 
     */

    public function AddRow(Request $req)
    {

        if ($req->ajax()) {
            $id = $req->id;
            $rowCount = $req->rowcount;
            $row = Stock::where('id', $id)->first();
            $exception = $row->category->pluck('id')->toArray();
            $items_cat = Item_category::whereNotNull('parent_id')->whereIn('id', $exception)->pluck('id')->toArray();
            $items = Item::whereIn('item_category_id', $items_cat)->whereNull('person_id')->get();
            if (!empty($req->person_id)) {

                $items = Item::whereIn('item_category_id', $items_cat)->where('person_id',  $req->person_id)->orwhereNull('person_id')->get();
            }
            $ajaxComponent = view('stocks.ajaxAdd', [
                'rowCount' => $rowCount,
                'items' => $items,

            ]);


            return $ajaxComponent->render();
        }
    }
    /***
     * 
     */

    public function editSelectVal(Request $req)
    {

        if ($req->ajax()) {

            $select_value = $req->select_value;

            $items = Item::where('id', $select_value)->first();
            $noBatch = "No Batch";
            if ($items->uom) {
                $noBatch = $items->uom->ar_name;
            }
            echo json_encode(array($items->ar_name, $noBatch));
        }
    }

    public function storeOpenBalance(Request $request)
    {
        $count = $request->get('rowCount');

        $details = [];
        for ($i = 1; $i <= $count; $i++) {


            $detail = [
                'item_id' => $request->get('select' . $i),
                'expired_date' => $request->get('batchDate' . $i),
                'batch_no' => $request->get('batchNum' . $i),
                'item_qty' => $request->get('qty' . $i),
                'item_price' => $request->get('itemprice' . $i),
                'total_line_cost' => $request->get('itemprice' . $i) * $request->get('qty' . $i),
                'notes' => $request->get('notes' . $i),

            ];


            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
        }

        //update Details
        $counterrrr = $request->get('qqq');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {



            $detailUpdate = [
                'item_trans_id' => $request->get('item_trans_id' . $i),
                'item_id' => $request->get('selectup' . $i),
                'expired_date' => $request->get('batchDateup' . $i),
                'batch_no' => $request->get('batchNumup' . $i),
                'item_qty' => $request->get('qtyup' . $i),
                'item_price' => $request->get('itempriceup' . $i),
                'total_line_cost' => $request->get('itempriceup' . $i) * $request->get('qtyup' . $i),
                'notes' => $request->get('notesup' . $i),

            ];
            array_push($detailsUpdate, $detailUpdate);
        }
        if ($request->get('action') == 'save') {



            DB::beginTransaction();
            try {

                //save stock-transaction
                $data = [
                    'code' => 1,
                    'transaction_date' => $request->get('transaction_date'),
                    'primary_stock_id' => $request->get('primary_stock_id'),
                ];
                $trans = Stocks_transaction::where('primary_stock_id', $request->get('primary_stock_id'))->firstOrNew($data);
                $trans->confirmed = 0;
                $trans->notes = $request->get('transNote');
                $trans->transaction_date = Carbon::parse($request->get('transaction_date'));
                $trans->save();


                foreach ($details as $Item) {

                    $Item['transaction_id'] = $trans->id;
                    Stock_transaction_item::create($Item);
                }

                foreach ($detailsUpdate as $updates) {
                    $itm = Stock_transaction_item::where('id', $updates['item_trans_id'])->first();

                    $itm->update($updates);
                }
                DB::commit();
                return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم  إضافة رصيد أفتتاحى بنجاح !');
            } catch (\Throwable $th) {
                // throw $th;
                DB::rollBack();

                return redirect()->back()->with('flash_success', 'حدث خطأ ما يرجي اعادة المحاولة!');
            }
        } elseif ($request->get('action') == 'confirm') {

            DB::beginTransaction();
            try {


                //save stock-transaction
                $data = [

                    'primary_stock_id' => $request->get('primary_stock_id'),

                ];
                $trans = Stocks_transaction::where('primary_stock_id', $request->get('primary_stock_id'))->firstOrNew($data);
                $trans->confirmed = 1;
                $trans->notes = $request->get('transNote');
                $trans->transaction_date = Carbon::parse($request->get('transaction_date'));
                $trans->save();

                foreach ($details as $Item) {

                    $Item['transaction_id'] = $trans->id;
                    Stock_transaction_item::create($Item);
                }

                foreach ($detailsUpdate as $updates) {
                    $itm = Stock_transaction_item::where('id', $updates['item_trans_id'])->first();

                    $itm->update($updates);
                }
                $itemsUpdates = Stock_transaction_item::where('transaction_id', $trans->id)->get();
                foreach ($itemsUpdates as $itemsUpdate) {
                    $itmUp = [
                        'stock_id' => $itemsUpdate->transaction->primary_stock_id,
                        'item_id' => $itemsUpdate->item_id,
                        'batch_no' => $itemsUpdate->batch_no,
                        'expired_date' => $itemsUpdate->expired_date,
                        'item_total_qty' => $itemsUpdate->item_total_qty,
                        'notes' => $itemsUpdate->notes,
                    ];

                    Stocks_items_total::create($itmUp);
                }

                DB::commit();
                return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم  إضافة رصيد أفتتاحى بنجاح !');
            } catch (\Throwable $th) {
                // throw $th;
                DB::rollBack();

                return redirect()->back()->with('flash_success', 'حدث خطأ ما يرجي اعادة المحاولة!');
            }
        }
    }
    public function approveOpenBalance(Request $req)
    {
    }
}
