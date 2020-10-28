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
use Carbon\Carbon;
use Illuminate\Support\Collection;
use DB;
use Illuminate\Database\QueryException;

class ExpiredItemsController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Stock $object)
    {


        $this->object = $object;
        $this->viewName = 'expired-items.';
        $this->routeName = 'expired-items.';

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
        $rows = Stocks_transaction::where('transaction_type_id', 109)->where('primary_stock_id', $stock_id)->get();
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
        $expiredItems = [];
        return view($this->viewName . 'add', compact('stock', 'expiredItems'));
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
        /**
         * 1-update stock-item-total
         */

        $updateTotals = [];

        for ($i = 1; $i <= $count; $i++) {
            $batch = $row = Stocks_items_total::where('id', $request->get('selectBatch' . $i))->first();
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
            if ($item) {
                $detail['item_price'] = $item->average_price;
                $detail['total_line_cost'] = $request->get('qty' . $i) * $item->average_price;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
            //this for updating total qty
            $totalQtyUp = [
                'id' => $batch->id,
                'item_total_qty' => $batch->item_total_qty - $request->get('qty' . $i),
            ];
            array_push($updateTotals, $totalQtyUp);
        }
        //from expired item
        $counterrrr = $request->get('counter');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {
            $upbatch = Stocks_items_total::where('id', $request->get('upitemBatch' . $i))->first();
            $upitem = Item::where('id', $request->get('item_expired_id' . $i))->first();
            $detailUpdate = [
                'item_id' => $request->get('item_expired_id' . $i),
                'item_qty' => $request->get('upqty' . $i),
                'notes' => $request->get('updetNote' . $i),
            ];
            if ($upbatch) {
                $detailUpdate['batch_no'] = $upbatch->batch_no;
                $detailUpdate['expired_date'] = $upbatch->expired_date;
            }
            if ($upitem) {
                $detailUpdate['item_price'] = $upitem->average_price;
                $detailUpdate['total_line_cost'] = $request->get('upqty' . $i) * $upitem->average_price;
            }

            array_push($detailsUpdate, $detailUpdate);


            //this for updating total qty
            $totalQtyUp = [
                'id' => $upbatch->id,
                'item_total_qty' => $upbatch->item_total_qty - $request->get('qty' . $i),
            ];
            array_push($updateTotals, $totalQtyUp);
        }
        //insert row in stock-transaction
        $maxCode = Stocks_transaction::where('primary_stock_id',  $request->get('stock_id'))->where('transaction_type_id', 109)->latest('code')->first();

        $maxCode = ($maxCode != null) ? intval($maxCode['code']) : 0;
        $maxCode++;
        $data = [
            'code' => $maxCode,
            'transaction_type_id' => 109,
            'primary_stock_id' => $request->get('stock_id'),
            'transaction_date' => Carbon::parse($request->get("transaction_date")),
            'notes' => $request->get('notes'),

        ];
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');



            if ($request->get('action') == 'save') {
                $data['confirmed'] = 0;
            } elseif ($request->get('action') == 'confirm') {
                //in confirm
                //update total items
                foreach ($updateTotals as $updateQty) {


                    Stocks_items_total::where('id', $updateQty['id'])->update($updateQty);
                }
             
                $data['confirmed'] = 1;
            }
            $trans = Stocks_transaction::create($data);
            foreach ($details as $Item) {

                $Item['transaction_id'] = $trans->id;
                $Invoice_Item = Stock_transaction_item::create($Item);
            }

            foreach ($detailsUpdate as $updte) {

                $updte['transaction_id'] = $trans->id;
                $Invoice_Item = Stock_transaction_item::create($updte);
            }
            $request->session()->flash('flash_success', "تم اضافة فاتورة بيع :");
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
        $transObj = Stocks_transaction::where('id', $id)->first();
        $expiredItemsEditing = Stock_transaction_item::where('transaction_id', $id)->get();
        $stock = Stock::where('id', $transObj->primary_stock_id)->first();
        $expiredItems = [];
        return view($this->viewName . 'view', compact('transObj','stock', 'expiredItems','expiredItemsEditing'));
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transObj = Stocks_transaction::where('id', $id)->first();
        $expiredItemsEditing = Stock_transaction_item::where('transaction_id', $id)->get();
        $stock = Stock::where('id', $transObj->primary_stock_id)->first();
        $expiredItems = [];
        return view($this->viewName . 'edit', compact('transObj','stock', 'expiredItems','expiredItemsEditing'));
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

        $details = [];
        /**
         * 1-update stock-item-total
         */

        $updateTotals = [];

        for ($i = 1; $i <= $count; $i++) {
            \Log::info($request->get('count' . $i));
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
            if ($item) {
                $detail['item_price'] = $item->average_price;
                $detail['total_line_cost'] = $request->get('qty' . $i) * $item->average_price;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
            //this for updating total qty
            if ($batch) {
            $totalQtyUp = [
                'id' => $batch->id,
                'item_total_qty' => $batch->item_total_qty - $request->get('qty' . $i),
            ];
            array_push($updateTotals, $totalQtyUp);

        }
        }
        //from expired item
        // $counterrrr = $request->get('counter');

        // $detailsUpdate = [];

        // for ($i = 1; $i <= $counterrrr; $i++) {
        //     $upbatch = Stocks_items_total::where('id', $request->get('upitemBatch' . $i))->first();
        //     $upitem = Item::where('id', $request->get('item_expired_id' . $i))->first();
        //     $detailUpdate = [
        //         'id'=> $request->get('id' . $i),
        //         'item_id' => $request->get('item_expired_id' . $i),
        //         'item_qty' => $request->get('upqty' . $i),
        //         'notes' => $request->get('updetNote' . $i),
        //     ];
        //     if ($upbatch) {
        //         $detailUpdate['batch_no'] = $upbatch->batch_no;
        //         $detailUpdate['expired_date'] = $upbatch->expired_date;
        //     }
        //     if ($upitem) {
        //         $detailUpdate['item_price'] = $upitem->average_price;
        //         $detailUpdate['total_line_cost'] = $request->get('upqty' . $i) * $upitem->average_price;
        //     }

        //     array_push($detailsUpdate, $detailUpdate);


        //     //this for updating total qty
        //     $totalQtyUp = [
        //         'id' => $upbatch->id,
        //         'item_total_qty' => $upbatch->item_total_qty - $request->get('qty' . $i),
        //     ];
        //     array_push($updateTotals, $totalQtyUp);
        // }
        //insert row in stock-transaction
     
        $data = [
            // 'code' => $maxCode,
            // 'transaction_type_id' => 109,
            // 'primary_stock_id' => $request->get('stock_id'),
            // 'transaction_date' => Carbon::parse($request->get("transaction_date")),
            'notes' => $request->get('notes'),

        ];
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');



            if ($request->get('action') == 'save') {
                $data['confirmed'] = 0;
            } elseif ($request->get('action') == 'confirm') {
                //in confirm
                //update total items
                foreach ($updateTotals as $updateQty) {


                    Stocks_items_total::where('id', $updateQty['id'])->update($updateQty);
                }
             
                $data['confirmed'] = 1;
            }
            // $trans = Stocks_transaction::create($data);
            Stocks_transaction::where('id', $id)->update($data);
            foreach ($details as $Item) {

                $Item['transaction_id'] = $id;
                $Invoice_Item = Stock_transaction_item::create($Item);
            }

            // foreach ($detailsUpdate as $updte) {

            //     $updte['transaction_id'] = $id;
            //     $Invoice_Item = Stock_transaction_item::create($updte);
            // }
            $request->session()->flash('flash_success', "تم اضافة فاتورة بيع :");
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
     * getExpired
     */
    public function getExpired(Request $req)
    {
        if ($req->ajax()) {

            $dateExpired = $req->dateExpired;
            $stock = $req->stock;
            $expiredItems = [];
            if ($dateExpired) {

                $expiredItems = Stocks_items_total::where('stock_id', $stock)->where('expired_date', '<=', Carbon::parse($req->get("dateExpired")))->with('item')->get();
            }

            $ajaxComponent = view('expired-items.expiredAjax', [

                'expiredItems' => $expiredItems,

            ]);


            return $ajaxComponent->render();
        }
    }
    /**
     * Add Row
     */
    public function AddRow(Request $req)
    {

        if ($req->ajax()) {
            $rowCount = $req->rowcount;
            $stock = $req->stock;
            $xx = Stocks_items_total::where('stock_id', $stock)->with('item')->get();

            $collection = new Collection($xx);

            // Get all unique items.
            $itemsss = $collection->unique('item_id');
            $items = [];
            foreach ($itemsss as $detail) {
                array_push($items, $detail->item);
            }
            $ajaxComponent = view('expired-items.addAjax', [
                'rowCount' => $rowCount,
                'items' => $items,

            ]);


            return $ajaxComponent->render();
        }
    }

    /**
     * edit row values
     */
    public function editSelectVal(Request $req)
    {



        if ($req->ajax()) {

            $select_value = $req->select_value;
            $select_stock = $req->select_stock;

            $out = [];

            $items = Item::where('id', $select_value)->first();


            if ($req->select_stock) {
                $data = Stocks_items_total::where('item_id', $select_value)->where('stock_id', $select_stock)->get();
            }


            $output = '<option value="" selected="" disabled="">إختر الباتش</option>';
            foreach ($data as $row) {
                $date = date_create($row->expired_date);
                $output .= '<option value="' . $row->id . '">' . $row->batch_no . '-' . date_format($date, "d-m-Y") . '-' . $row->item_total_qty . '</option>';
            }



            echo json_encode(array($items->ar_name, $items->uom->ar_name ?? '', $output));
        }
    }
    /**
     * edit batch
     */
    public function editSelectBatch(Request $req)
    {

        if ($req->ajax()) {

            $select_value = $req->select_value;

            $row = Stocks_items_total::where('id', $select_value)->first();

            $date = date_create($row->expired_date);

            echo json_encode(array($row->batch_no,  date_format($date, "d-m-Y"), $row->item_total_qty,));
        }
    }

     /***
     * Del
     */
    public function DeleteItem(Request $req)
    {


        if ($req->ajax()) {

            // $obo = Invoice_item::where('id', $req->id)->first();
            $obo = Stock_transaction_item::where('id', $req->id)->first();

            
            $obo->delete();
        }
    }
}
