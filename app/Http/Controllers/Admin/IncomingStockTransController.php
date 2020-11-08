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

class IncomingStockTransController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Stocks_transaction $object)
    {


        $this->object = $object;
        $this->viewName = 'incoming-stock-trans.';
        $this->routeName = 'incoming-stock-trans.';
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
        $rows = Stocks_transaction::where('secondary_stock_id', $stock_id)->where('transaction_type_id', 105)->where('confirmed', 1)->get();
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

    public function creation(Request $request)
    {

        $id = $request->input('stock_row');

        $stockRow = Stocks_transaction::where('id', $id)->first();
        $transItems = Stock_transaction_item::where('transaction_id', $id)->get();
        $user = User::where('id', 1)->first();
        $secondStocks = $user->stock->where('id', '!=', $id);
        return view($this->viewName . 'add', compact('stockRow', 'transItems'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //update Details
        $counterrrr = $request->get('counter');
        $financeArray = [];
        $detailsUpdate = [];
        $updateTotals = [];
        for ($i = 1; $i <= $counterrrr; $i++) {
            $itemTrams = Stock_transaction_item::where('id', $request->get('transItem' . $i))->first();

            if ($itemTrams) {
                $item = Item::where('id', $itemTrams->item_id)->first();

                $detailUpdate = [
                    'item_id' => $itemTrams->item_id,
                    'item_qty' => $request->get('transItemQty' . $i),
                    'notes' => $request->get('transItemNotes' . $i),
                    'batch_no' => $itemTrams->batch_no,
                    'expired_date' => $itemTrams->expired_date,

                ];
                if ($request->get('transItemQty' . $i)) {
                    array_push($detailsUpdate, $detailUpdate);

                    //finance
                if ($item) {
                    $finance = [
                        'totalPrice' => $request->get('transItemQty' . $i) * $item->average_price,
                    ];
                    array_push($financeArray, $finance);
                }
                }
                
            }
        }
        // Master

        $max = Stocks_transaction::where('transaction_type_id', 106)->where('primary_stock_id', $request->input('stock_id'))->latest('code')->first();

        $max = ($max != null) ? intval($max['code']) : 0;
        $max++;

        $data = [
            'code' => $max,
            'transaction_type_id' => 106,
            'transaction_date' => Carbon::parse($request->get('rcvDate')),
            'parent_tranaction_id' => $request->get('parent_tranaction_id'),
            'primary_stock_id' => $request->input('stock_id'),
            'secondary_stock_id' => $request->input('secondary_stock_id'),
            'notes' => $request->get('rcvNote'),
            'confirmed' => 1,

        ];
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $trans = Stocks_transaction::create($data);
            foreach ($detailsUpdate as $Item) {
                $Item['transaction_id'] = $trans->id;
                $trans_Item = Stock_transaction_item::create($Item);
            }
            //update total
            foreach ($detailsUpdate as $Items) {
                $xx = [
                    'item_id' => $Items['item_id'],
                    'stock_id' => $trans->primary_stock_id,
                    'batch_no' => $Items['batch_no'],
                    'expired_date' => $Items['expired_date'],
                ];

                $transTotal = Stocks_items_total::where('item_id', $xx['item_id'])->where('stock_id', $xx['stock_id'])->where('expired_date', $xx['expired_date'])->where('batch_no', $xx['batch_no'])->firstOrNew($xx);

                $transTotal->item_id = $Items['item_id'];
                $transTotal->item_total_qty =  $trans->item_qty + $Items['item_qty'];
                $transTotal->stock_id = $trans->primary_stock_id;
                $transTotal->batch_no = $Items['batch_no'];
                $transTotal->expired_date = $Items['expired_date'];
                $transTotal->save();
            }
            //update OutGoing  rcvd_confirmed == 1 if all is done 
            //remaining
            $outGoing = Stocks_transaction::where('id',  $request->get('parent_tranaction_id'))->first();
            $outGoingItems = Stock_transaction_item::where('transaction_id', $request->get('parent_tranaction_id'))->get();
            $remaining = array();
            $reserved = 0;
            foreach ($outGoingItems as $transItem) {

                $reserved = 0;


                $transSelect = Stocks_transaction::where('parent_tranaction_id', $transItem->transaction_id)->pluck('id')->toArray();

                if ($transSelect) {
                    $reserved = Stock_transaction_item::where('item_id', $transItem->item_id)
                        ->where('expired_date', $transItem->expired_date)->where('batch_no', $transItem->batch_no)->whereIn('transaction_id', $transSelect)->sum('item_qty');
                }
                $remain = $transItem->item_qty - $reserved;
                if ($remain > 0) {
                    array_push($remaining, $transItem);
                }
            }
            if (!$remaining && empty($remaining)) {
                if ($outGoing) {
                    $outGoing->rcvd_confirmed = 1;
                    $outGoing->update();
                }
            }

            //Make Finance Entry

            $stockBranch = Stock::where('id', $request->input('stock_id'))->first();
            $maxF = Financial_entry::where('trans_type_id', 104)->where('branch_id', $stockBranch->branch_id)->latest('entry_serial')->first();

            $maxF = ($maxF != null) ? intval($maxF['entry_serial']) : 0;
            $maxF++;
            //sum of prices
            $PricesSum = 0.0;

            foreach ($financeArray as $finance) {

                $PricesSum += $finance['totalPrice'];
            }
            //Finance Entry add 2 records

            $firstFinance = new Financial_entry();
            $firstFinance->trans_type_id = 104;
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
            $secondFinance->trans_type_id = 104;
            $secondFinance->entry_serial = $maxF;
            $secondFinance->entry_date = Carbon::parse($request->get('transaction_date'));
            $secondFinance->stock_id =  $request->input('stock_id');
            $secondFinance->branch_id = $stockBranch->branch_id;
            $secondFinance->debit = $PricesSum;
            $secondFinance->credit =0;
            $secondFinance->gl_item_id = Financial_subsystem::where('id', 121)->first()->gl_item_id ?? 0;

            $secondFinance->save();

            //End Finance

            $request->session()->flash('flash_success', "تم اضافة حركة وارد :");
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
        $masterDetails = [];
        $row = Stocks_transaction::where('id', $id)->first();
        $transItems = Stock_transaction_item::where('transaction_id', $id)->get();
        $incomesMasters = Stocks_transaction::where('parent_tranaction_id', $id)->get();
        //get All Mostalm
        foreach ($incomesMasters as $incomesMaster) {
            $obj = new Collection();
            $obj->master = $incomesMaster;

            $obj->details = Stock_transaction_item::where('transaction_id', $incomesMaster->id)->get();

            array_push($masterDetails, $obj);
        }
        return view($this->viewName . 'view', compact('row', 'transItems', 'masterDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $masterDetails = [];
        $row = Stocks_transaction::where('id', $id)->first();
        $transItems = Stock_transaction_item::where('transaction_id', $id)->get();
        $incomesMasters = Stocks_transaction::where('parent_tranaction_id', $id)->get();
        //get All Mostalm
        foreach ($incomesMasters as $incomesMaster) {
            $obj = new Collection();
            $obj->master = $incomesMaster;

            $obj->details = Stock_transaction_item::where('transaction_id', $incomesMaster->id)->get();

            array_push($masterDetails, $obj);
        }
        return view($this->viewName . 'edit', compact('row', 'transItems', 'masterDetails'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
