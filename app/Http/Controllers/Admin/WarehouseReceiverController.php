<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Item;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Person;
use App\Models\Stock;
use App\Models\Stock_transaction_item;
use App\Models\Stocks_items_total;
use App\Models\Stocks_transaction;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Database\QueryException;

class WarehouseReceiverController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Order $object)
    {


        $this->object = $object;
        $this->viewName = 'warehouse-receiver.';
        $this->routeName = 'warehouse-receiver.';
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
        $stock = new Stock();
        $branch_id = 0;
        $stocks = Stock::whereIn('branch_id', $branches)->get();
        $rows = [];
        return view($this->viewName . 'index', compact('branches', 'stock', 'stocks', 'rows'));
    }


    public function branchFetch(Request $request)
    {
        $stock_id = $request->input('stock_id');
        $stock = Stock::where('id', $stock_id)->first();
        $rows = Stocks_transaction::where('primary_stock_id', $stock_id)->get();
        return view($this->viewName . 'preIndex', compact('stock', 'rows'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function creation(Request $request)
    {
        $stock_id = $request->get('stock');

        $persons = Person::where('person_type_id', 100)->get();
        $purchItems = [];
        $orders = Order::where('stock_id', $stock_id)->where('order_type_id', 2)->where('confirmed', 1)->get();

        return view($this->viewName . 'create', compact('stock_id', 'purchItems', 'persons', 'orders'))->render();
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
        $TransactionItems = [];

        for ($i = 1; $i <= $count; $i++) {

            $detail = [
                'item_id' => $request->get('select' . $i),
                'item_qty' => $request->get('qty' . $i),
                'batch_no' => $request->get('Batch' . $i),
                'expired_date' => Carbon::parse($request->get('exDate' . $i)),
                'notes' => $request->get('detNote' . $i),

            ];

            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
            \Log::info($details);
            //this for updating stock_transaction_items
            $TransactionItem = [
                'item_id' => $detail['item_id'],
                'batch_no' => $detail['batch_no'],
                'expired_date' => $detail['expired_date'],
                'item_qty_unconfirmed' => $detail['item_qty'],
                'stock_id' => $request->input('stock'),
            ];
            array_push($TransactionItems, $TransactionItem);
        }
        //from order item
        $counterrrr = $request->get('counter');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {




            $detailUpdate = [
                'item_id' => $request->get('selectup' . $i),
                'item_qty' => $request->get('orqty' . $i),
                'batch_no' => $request->get('orBatch' . $i),
                'expired_date' => Carbon::parse($request->get('orDate' . $i)),
                'notes' => $request->get('notesup' . $i),

            ];


            array_push($detailsUpdate, $detailUpdate);
            \Log::info($detailsUpdate);
            //this for updating stock_transaction_items
            $TransactionItem = [
                'item_id' => $detailUpdate['item_id'],
                'batch_no' => $detailUpdate['batch_no'],
                'expired_date' => $detailUpdate['expired_date'],
                'item_qty_unconfirmed' => $detailUpdate['item_qty'],
                'stock_id' => $request->input('stock'),
            ];
            array_push($TransactionItems, $TransactionItem);
        }
        // Master
        $max = Stocks_transaction::where('primary_stock_id', $request->input('stock'))->latest('code')->first();

        $max = ($max != null) ? intval($max['code']) : 0;
        $max++;
        $data = [
            'code' => $max,
            'transaction_date' => Carbon::parse($request->get('transaction_date')),
            'transaction_type_id' => 101,
            'referance_type' => 0,
            'order_id' => $request->get('purchOrder'),
            'person_id' => $request->get('person_id'),
            'person_name' => Person::where('id', $request->get('person_id'))->first()->name ?? '',
            'primary_stock_id' => $request->input('stock'),
            'order_description' => $request->get('order_description'),
            'person_type_id' => 100,

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
                //saving or update total items

                foreach ($TransactionItems as $Items) {
                    $xx=[
                        'item_id'=>$Items['item_id'],
                        'stock_id'=>$Items['stock_id'],
                        'batch_no'=>$Items['batch_no'],
                        'expired_date'=>$Items['expired_date'],
                    ];
                    \Log::info(['message', $Items]);
                    $trans = Stocks_items_total::where('item_id', $xx['item_id'])->where('stock_id', $xx['stock_id'])->where('expired_date', $xx['expired_date'])->where('batch_no', $xx['batch_no'])->firstOrNew($xx);
                    \Log::info(['message', $trans]);
                    $trans->item_id = $Items['item_id'];
                    $trans->item_qty_unconfirmed =  $trans->item_qty_unconfirmed + $Items['item_qty_unconfirmed'];
                    $trans->stock_id = $Items['stock_id'];
                    $trans->batch_no = $Items['batch_no'];
                    $trans->expired_date = $Items['expired_date'];
                    $trans->save();
                }
            }
            $trans = Stocks_transaction::create($data);
            foreach ($details as $Item) {

                $Item['transaction_id'] = $trans->id;
                $order_Item = Stock_transaction_item::create($Item);
            }
            foreach ($detailsUpdate as $updte) {

                $updte['transaction_id'] = $trans->id;
                $Invoice_Item = Stock_transaction_item::create($updte);
            }
            $request->session()->flash('flash_success', "تمت حركة المخزن :");
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
        $persons = Person::where('person_type_id', 100)->get();
        $purchItems = [];
        $orders = Order::where('stock_id', $row->primary_stock_id)->where('order_type_id', 2)->where('confirmed', 1)->get();

        return view($this->viewName . 'view', compact('row', 'transItems', 'persons', 'purchItems', 'orders'));
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
        $persons = Person::where('person_type_id', 100)->get();
        $purchItems = [];
        $orders = Order::where('stock_id', $row->primary_stock_id)->where('order_type_id', 2)->where('confirmed', 1)->get();

        return view($this->viewName . 'edit', compact('row', 'transItems', 'persons', 'purchItems', 'orders'));
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
        $TransactionObj = Stocks_transaction::where('id', $id)->first();
        $count = $request->rowCount;

        $details = [];
        $TransactionItems = [];
        for ($i = 1; $i <= $count; $i++) {

            $detail = [
                'item_id' => $request->get('select' . $i),
                'item_qty' => $request->get('qty' . $i),
                'batch_no' => $request->get('Batch' . $i),
                'expired_date' => Carbon::parse($request->get('exDate' . $i)),
                'notes' => $request->get('detNote' . $i),

            ];

            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
            //this for updating stock_transaction_items
            $TransactionItem = [
                'item_id' => $detail['item_id'],
                'batch_no' => $detail['batch_no'],
                'expired_date' => $detail['expired_date'],
                'item_qty_unconfirmed' => $detail['item_qty'],
                'stock_id' => $TransactionObj->primary_stock_id,
            ];
            array_push($TransactionItems, $TransactionItem);
        }
        //from order item
        $counterrrr = $request->get('counter');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {




            $detailUpdate = [
                'id' => $request->get('item_trans_id' . $i),
                'transaction_id' => $request->get('transaction_id'),
                'item_id' => $request->get('selectup' . $i),
                'item_qty' => $request->get('orqty' . $i),
                'batch_no' => $request->get('orBatch' . $i),
                'expired_date' => Carbon::parse($request->get('orDate' . $i)),
                'notes' => $request->get('notesup' . $i),

            ];


            array_push($detailsUpdate, $detailUpdate);
            \Log::info($detailsUpdate);
            //this for updating stock_transaction_items
            $TransactionItem = [
                'item_id' => $detailUpdate['item_id'],
                'batch_no' => $detailUpdate['batch_no'],
                'expired_date' => $detailUpdate['expired_date'],
                'item_qty_unconfirmed' => $detailUpdate['item_qty'],
                'stock_id' => $TransactionObj->primary_stock_id,
            ];
            array_push($TransactionItems, $TransactionItem);
        }
        // Master

        $data = [

            'transaction_date' => Carbon::parse($request->get('transaction_date')),
            'order_description' => $request->get('order_description'),
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
                //saving or update total items
                foreach ($TransactionItems as $Items) {
                    $xx=[
                        'item_id'=>$Items['item_id'],
                        'stock_id'=>$Items['stock_id'],
                        'batch_no'=>$Items['batch_no'],
                        'expired_date'=>$Items['expired_date'],
                    ];
                    \Log::info(['message', $Items]);
                    $trans = Stocks_items_total::where('item_id', $xx['item_id'])->where('stock_id', $xx['stock_id'])->where('expired_date', $xx['expired_date'])->where('batch_no', $xx['batch_no'])->firstOrNew($xx);
                   \Log::info(['message', $trans]);
                    $trans->item_id = $Items['item_id'];
                    $trans->item_qty_unconfirmed =  $trans->item_qty_unconfirmed + $Items['item_qty_unconfirmed'];
                    $trans->stock_id = $Items['stock_id'];
                    $trans->batch_no = $Items['batch_no'];
                    $trans->expired_date = $Items['expired_date'];
                    $trans->save();
                }
            }
            Stocks_transaction::where('id', $id)->update($data);
            foreach ($details as $Item) {

                $Item['transaction_id'] = $id;
                $order_Item = Stock_transaction_item::create($Item);
            }
            foreach ($detailsUpdate as $updte) {

                Stock_transaction_item::where('id', $updte['id'])->update($updte);
            }
            $request->session()->flash('flash_success', "تمت حركة المخزن :");
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

    public function fetchOrdersItem(Request $req)
    {
        if ($req->ajax()) {
            $order_id = $req->select_value;

            //get orderItems

            $purchItems = Order_item::where('order_id', $order_id)->get();

            $ajaxComponent = view('warehouse-receiver.fromOrder', [
                'purchItems' => $purchItems
            ]);


            return $ajaxComponent->render();
        }
    }


    /***
     * 
     */
    public function AddRow(Request $req)
    {

        if ($req->ajax()) {
            $rowCount = $req->rowCount;
            $order = $req->order;
            $supplier = $req->person;

            $items = Item::where('person_id', $supplier)->orWhereNull('person_id')->get();

            $ajaxComponent = view('warehouse-receiver.ajaxAdd', [
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

            $items = Item::where('id', $select_value)->first();

            echo json_encode(array($items->ar_name, $items->uom->ar_name ?? ''));
        }
    }

    public function DeletevirtualItem(Request $req){

        if ($req->ajax()) {


            $order_id = $req->order;
            $id = $req->id;

            //get orderItems

         
            Stock_transaction_item::where('id', $req->id)->delete();
        }
    }
}
