<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

class ClosingStockTransController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Stocks_transaction $object)
    {


        $this->object = $object;
        $this->viewName = 'closing-stock-trans.';
        $this->routeName = 'closing-stock-trans.';
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

        $detailsUpdate = [];
        $updateTotals = [];
        for ($i = 1; $i <= $counterrrr; $i++) {
            $itemTrams = Stock_transaction_item::where('id', $request->get('transItem' . $i))->first();
            if ($itemTrams) {
                $detailUpdate = [
                    'item_id' => $itemTrams->item_id,
                    'item_qty' => $request->get('remain' . $i),
                    'notes' => $request->get('transItemNotes' . $i),
                    'batch_no' => $itemTrams->batch_no,
                    'expired_date' => $itemTrams->expired_date,

                ];
                if ($request->get('remain' . $i)) {
                    array_push($detailsUpdate, $detailUpdate);
                }
            }
        }
        // Master

        $max = Stocks_transaction::where('transaction_type_id', 110)->where('primary_stock_id', $request->input('stock_id'))->latest('code')->first();

        $max = ($max != null) ? intval($max['code']) : 0;
        $max++;

        $data = [
            'code' => $max,
            'transaction_type_id' => 110,
            'transaction_date' => Carbon::parse($request->get('closeDate')),
            'parent_tranaction_id' => $request->get('parent_tranaction_id'),
            'primary_stock_id' => $request->input('stock_id'),
            'secondary_stock_id' => $request->input('secondary_stock_id'),
            'notes' => $request->get('closeNote'),
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
            //update outgoing rcvd_confirmed == 2 
            $outgo = Stocks_transaction::where('id', $request->get('parent_tranaction_id'))->first();
            if ($outgo) {
                $outgo->rcvd_confirmed = 2;
                $outgo->update();
            }

            $request->session()->flash('flash_success', "تم اضافة حركة إغلاق :");
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

        //remaining
        $remaining = array();
        $reserved = 0;
        foreach ($transItems as $transItem) {

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
        return view($this->viewName . 'edit', compact('row', 'transItems', 'masterDetails', 'remaining'));
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
