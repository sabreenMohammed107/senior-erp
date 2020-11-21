<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Financial_entry;
use App\Models\Financial_subsystem;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Stock_transaction_item;
use App\Models\Stocks_items_total;
use App\Models\Stocks_transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Log;
use Carbon\Carbon;
use DB;
use Illuminate\Database\QueryException;

class OutgingStockTransController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Stocks_transaction $object)
    {


        $this->object = $object;
        $this->viewName = 'outging-stock-trans.';
        $this->routeName = 'outging-stock-trans.';
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
        $stocks = $user->stock;
        $row = new Stock();
        $rows = [];
        return view($this->viewName . 'index', compact('row', 'rows', 'stocks'));
    }

    /**
     * Display a table  of the branch.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockFetch(Request $request)
    {
        $stock_id = $request->input('stock_id');
        $row = Stock::where('id', $stock_id)->first();
        $rows = Stocks_transaction::where('primary_stock_id', $stock_id)->where('transaction_type_id', 105)->get();
        return view($this->viewName . 'preIndex', compact('row', 'rows'))->render();
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
    /**
     * Show the form for creating a new resource with request.
     *
     * @return \Illuminate\Http\Response
     */
    public function creation(Request $request)
    {

        $id = $request->input('stock');

        $stock = Stock::where('id', $id)->first();
        $user = User::where('id', 1)->first();
        $secondStocks = $user->stock->where('id', '!=', $id);
        return view($this->viewName . 'add', compact('stock', 'secondStocks'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = $request->rowCount;

        $details = [];
        $updateTotals = [];
        $financeArray = [];
        $itemsTableUpdates = [];
        for ($i = 1; $i <= $count; $i++) {
            $batch = Stocks_items_total::where('id', $request->get('selectBatch' . $i))->first();
            $item = Item::where('id', $request->get('select' . $i))->first();
            $detail = [
                'item_id' => $request->get('select' . $i),
                'item_qty' => $request->get('qty' . $i),
                'notes' => $request->get('detNote' . $i),

            ];
            if ($batch) {
                $detail['batch_no'] = $batch->batch_no;
                $detail['expired_date'] = $batch->expired_date;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }

            if ($batch) {
                $totalQtyUp = [
                    'id' => $batch->id,
                    'item_total_qty' => $request->get('itemRemain' . $i),
                ];
                array_push($updateTotals, $totalQtyUp);
            }

            //finance
            if ($item) {
                $finance = [
                    'totalPrice' => $request->get('qty' . $i) * $item->average_price,
                ];
                array_push($financeArray, $finance);
            }


            //update items table
            $detailItem = [

                'item_id' => $detail['item_id'],

                'item_total_qty' => $detail['item_qty'],


            ];
            array_push($itemsTableUpdates, $detailItem);
        }

        //udate items table array 
        $table_items = array();
        $all = 0;
        foreach ($itemsTableUpdates as $item) {

            if (isset($table_items[$item['item_id']])) {

                $table_items[$item['item_id']]['item_total_qty'] += $item['item_total_qty'];
            } else {
                $table_items[$item['item_id']] = $item;
            }
        }

        \Log::info(['order_products', $table_items]);
        // Master
        \Log::info(['financeArray :', $financeArray]);
        $max = Stocks_transaction::where('transaction_type_id', 105)->where('primary_stock_id', $request->input('stock_id'))->latest('code')->first();

        $max = ($max != null) ? intval($max['code']) : 0;
        $max++;
        $data = [
            'code' => $max,
            'transaction_date' => Carbon::parse($request->get('transaction_date')),
            'transaction_type_id' => 105,
            'primary_stock_id' => $request->input('stock_id'),
            'secondary_stock_id' => $request->input('secondary_stock_id'),
            'notes' => $request->get('notes'),

        ];
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');



            if ($request->get('action') == 'save') {
                $data['confirmed'] = 0;
            } elseif ($request->get('action') == 'confirm') {
                $data['confirmed'] = 1;
                //update total
                foreach ($updateTotals as $total) {
                    Stocks_items_total::where('id', $total['id'])->update($total);
                }


                //update item table
                foreach ($table_items as $table_item) {
                    $itmUpdate = Item::where('id', $table_item['item_id'])->first();
                    $itmUpdate->item_total_qty = $itmUpdate->item_total_qty - $table_item['item_total_qty'];
                    $itmUpdate->item_total_cost = $itmUpdate->item_total_qty * $itmUpdate->average_price;
                    $itmUpdate->update();
                }

                //Make Finance Entry

                $stockBranch = Stock::where('id', $request->input('stock_id'))->first();
                $maxF = Financial_entry::where('trans_type_id', 103)->where('branch_id', $stockBranch->branch_id)->latest('entry_serial')->first();

                $maxF = ($maxF != null) ? intval($maxF['entry_serial']) : 0;
                $maxF++;
                //sum of prices
                $PricesSum = 0.0;

                foreach ($financeArray as $finance) {

                    $PricesSum += $finance['totalPrice'];
                }
                //Finance Entry add 2 records

                $firstFinance = new Financial_entry();
                $firstFinance->trans_type_id = 103;
                $firstFinance->entry_serial = $maxF;
                $firstFinance->entry_date = Carbon::parse($request->get('transaction_date'));
                $firstFinance->stock_id =  $request->input('stock_id');
                $firstFinance->branch_id = $stockBranch->branch_id;
                $firstFinance->credit = $PricesSum;
                $firstFinance->debit = 0;
                $firstFinance->gl_item_id = $stockBranch->gl_item_id;

                $firstFinance->save();
                //second row
                $secondFinance = new Financial_entry();
                $secondFinance->trans_type_id = 103;
                $secondFinance->entry_serial = $maxF;
                $secondFinance->entry_date = Carbon::parse($request->get('transaction_date'));
                $secondFinance->stock_id =  $request->input('stock_id');
                $secondFinance->branch_id = $stockBranch->branch_id;
                $secondFinance->debit = $PricesSum;
                $secondFinance->credit = 0;
                $secondFinance->gl_item_id = Financial_subsystem::where('id', 102)->first()->gl_item_id ?? 0;

                $secondFinance->save();
            }
            //End Finance
            // Master
            $trans = Stocks_transaction::create($data);
            foreach ($details as $Item) {
                $Item['transaction_id'] = $trans->id;
                $trans_Item = Stock_transaction_item::create($Item);
            }
            $request->session()->flash('flash_success', "تم اضافة حركة صادر :");
            DB::commit();
            // Enable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
        } catch (\Throwable $e) {
            // throw $th;
            DB::rollback();

            return redirect()->back()->withInput()->with('flash_danger', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Stocks_transaction::where('id', $id)->first();
        $transItems = Stock_transaction_item::where('transaction_id', $id)->get();
        $stock = Stock::where('id', $row->primary_stock_id)->first();
        $user = User::where('id', 1)->first();
        $secondStocks = $user->stock;
        return view($this->viewName . 'view', compact('row', 'transItems', 'stock', 'secondStocks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Stocks_transaction::where('id', $id)->first();
        $transItems = Stock_transaction_item::where('transaction_id', $id)->get();
        $stock = Stock::where('id', $row->primary_stock_id)->first();
        $user = User::where('id', 1)->first();
        $secondStocks = $user->stock;
        return view($this->viewName . 'edit', compact('row', 'transItems', 'stock', 'secondStocks'));
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
        $count = $request->rowCount;
        $financeArray = [];
        $details = [];
        $updateTotals = [];
        $itemsTableUpdates = [];
        for ($i = 1; $i <= $count; $i++) {
            $batch = Stocks_items_total::where('id', $request->get('selectBatch' . $i))->first();
            $item = Item::where('id', $request->get('select' . $i))->first();

            $detail = [
                'item_id' => $request->get('select' . $i),
                'item_qty' => $request->get('qty' . $i),
                'notes' => $request->get('detNote' . $i),

            ];
            if ($batch) {
                $detail['batch_no'] = $batch->batch_no;
                $detail['expired_date'] = $batch->expired_date;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }

            if ($batch) {
                $totalQtyUp = [
                    'id' => $batch->id,
                    'item_total_qty' => $request->get('itemRemain' . $i),
                ];
                array_push($updateTotals, $totalQtyUp);
            }
            //finance
            if ($item) {
                $finance = [
                    'totalPrice' => $request->get('qty' . $i) * $item->average_price,
                ];
                array_push($financeArray, $finance);
            }

            //update items table
            $detailItem = [

                'item_id' => $detail['item_id'],

                'item_total_qty' => $detail['item_qty'],


            ];
            array_push($itemsTableUpdates, $detailItem);
        }

        //update Details
        $counterrrr = $request->get('counter');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {
            $batchup = Stocks_items_total::where('id', $request->get('itemBatchSelect' . $i))->first();
            $itemup = Item::where('id', $request->get('itemSelect' . $i))->first();

            $detailUpdate = [
                'id' => $request->get('item_trans_id' . $i),
                'item_id' => $request->get('itemSelect' . $i),
                'item_qty' => $request->get('upqty' . $i),
                'notes' => $request->get('updetNote' . $i),

            ];
            if ($batchup) {
                $detailUpdate['batch_no'] = $batchup->batch_no;
                $detailUpdate['expired_date'] = $batchup->expired_date;
            }
            \Log::info([$batchup, $request->get('upitemRemain' . $i)]);
            array_push($detailsUpdate, $detailUpdate);

            if ($batchup) {
                $totalQtyUp2 = [
                    'id' => $batchup->id,
                    'item_total_qty' => $request->get('upitemRemain' . $i),
                ];
                array_push($updateTotals, $totalQtyUp2);
            }

            //finance
            if ($itemup) {
                $finance = [
                    'totalPrice' => $request->get('upqty' . $i) * $itemup->average_price,
                ];
                array_push($financeArray, $finance);
            }
            //update item table
            $detailUpdateItem = [

                'item_id' => $detailUpdate['item_id'],
                'item_total_qty' => $detailUpdate['item_qty'],

            ];
            array_push($itemsTableUpdates, $detailUpdateItem);
        }

        //udate items table array 
        $table_items = array();
        $all = 0;
        foreach ($itemsTableUpdates as $item) {

            if (isset($table_items[$item['item_id']])) {

                $table_items[$item['item_id']]['item_total_qty'] += $item['item_total_qty'];
            } else {
                $table_items[$item['item_id']] = $item;
            }
        }

        \Log::info(['order_products', $table_items]);
        // Master


        $data = [

            'transaction_date' => Carbon::parse($request->get('transaction_date')),


            'notes' => $request->get('notes'),

        ];
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');



            if ($request->get('action') == 'save') {
                $data['confirmed'] = 0;
            } elseif ($request->get('action') == 'confirm') {

                $data['confirmed'] = 1;
                //update total
                foreach ($updateTotals as $total) {
                    Stocks_items_total::where('id', $total['id'])->update($total);
                }



                //update item table
                foreach ($table_items as $table_item) {
                    $itmUpdate = Item::where('id', $table_item['item_id'])->first();
                    $itmUpdate->item_total_qty = $itmUpdate->item_total_qty - $table_item['item_total_qty'];
                    $itmUpdate->item_total_cost = $itmUpdate->item_total_qty * $itmUpdate->average_price;
                    $itmUpdate->update();
                }





                //Make Finance Entry

                $stockBranch = Stock::where('id', $request->input('stock_id'))->first();
                $maxF = Financial_entry::where('trans_type_id', 103)->where('branch_id', $stockBranch->branch_id)->latest('entry_serial')->first();

                $maxF = ($maxF != null) ? intval($maxF['entry_serial']) : 0;
                $maxF++;
                //sum of prices
                $PricesSum = 0.0;

                foreach ($financeArray as $finance) {

                    $PricesSum += $finance['totalPrice'];
                }
                //Finance Entry add 2 records

                $firstFinance = new Financial_entry();
                $firstFinance->trans_type_id = 103;
                $firstFinance->entry_serial = $maxF;
                $firstFinance->entry_date = Carbon::parse($request->get('transaction_date'));
                $firstFinance->stock_id =  $request->input('stock_id');
                $firstFinance->branch_id = $stockBranch->branch_id;
                $firstFinance->credit = $PricesSum;
                $firstFinance->gl_item_id = $stockBranch->gl_item_id;

                $firstFinance->save();
                //second row
                $secondFinance = new Financial_entry();
                $secondFinance->trans_type_id = 103;
                $secondFinance->entry_serial = $maxF;
                $secondFinance->entry_date = Carbon::parse($request->get('transaction_date'));
                $secondFinance->stock_id =  $request->input('stock_id');
                $secondFinance->branch_id = $stockBranch->branch_id;
                $secondFinance->debit = $PricesSum;
                $secondFinance->gl_item_id = Financial_subsystem::where('id', 102)->first()->gl_item_id ?? 0;

                $secondFinance->save();

                //End Finance
            }
            Stocks_transaction::where('id', $id)->update($data);
            foreach ($details as $Item) {
                $Item['transaction_id'] = $id;
                $trans_Item = Stock_transaction_item::create($Item);
            }

            foreach ($detailsUpdate as $updates) {
                Stock_transaction_item::where('id', $updates['id'])->update($updates);
            }
            $request->session()->flash('flash_success', "تم اضافة حركة صادر :");
            DB::commit();
            // Enable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
        } catch (\Throwable $e) {
            // throw $th;
            DB::rollback();

            return redirect()->back()->withInput()->with('flash_danger', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Stocks_transaction::where('id', $id)->first();
        // Delete File ..


        try {
            $row->item()->delete();
            $row->delete();
        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', $q->getMessage());
        }
        return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');
    }
    /***
     * 
     */
    public function AddRow(Request $req)
    {

        if ($req->ajax()) {
            $rowCount = $req->rowcount;
            $stock_id = $req->stock;


            $xx = Stocks_items_total::where('stock_id', $stock_id)->with('item')->get();


            $collection = new Collection($xx);

            // Get all unique items.
            $itemsss = $collection->unique('item_id');
            $items = [];
            foreach ($itemsss as $detail) {
                array_push($items, $detail->item);
            }
            \Log::info($items);
            $ajaxComponent = view('outging-stock-trans.addAjax', [
                'rowCount' => $rowCount,
                'items' => $items,

            ]);


            return $ajaxComponent->render();
        }
    }

    /**
     * 
     */
    public function editSelectVal(Request $req)
    {

        if ($req->ajax()) {

            $select_value = $req->select_value;
            $select_stock = $req->select_stock;
            $out = [];

            $items = Item::where('id', $select_value)->first();



            $data = Stocks_items_total::where('item_id', $select_value)->where('stock_id', $select_stock)->get();



            $output = '<option value="" selected="" disabled="">إختر الباتش</option>';
            foreach ($data as $row) {
                $date = date_create($row->expired_date);
                $output .= '<option value="' . $row->id . '">' . $row->batch_no . '-' . date_format($date, "d-m-Y") . '-' . $row->item_total_qty . '</option>';
            }



            echo json_encode(array($items->ar_name, $items->uom->ar_name ?? '', $output));
        }
    }

    /**
     * 
     */
    public function editSelectBatch(Request $req)
    {

        if ($req->ajax()) {

            $select_value = $req->select_value;
            $person = $req->person;
            $row = Stocks_items_total::where('id', $select_value)->first();


            $date = date_create($row->expired_date);




            echo json_encode(array($row->batch_no,  date_format($date, "d-m-Y"), $row->item_total_qty));
        }
    }


    public function DeletevirtualItem(Request $req)
    {

        if ($req->ajax()) {



            $id = $req->id;



            Stock_transaction_item::where('id', $req->id)->delete();
        }
    }
}
