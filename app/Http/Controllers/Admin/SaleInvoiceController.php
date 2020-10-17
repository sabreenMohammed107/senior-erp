<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\Invoice_item;
use App\Models\Item;
use App\Models\Items_discount;
use App\Models\Items_price;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Person;
use App\Models\Representative;
use App\Models\Sales_invoice_pay_type;
use App\Models\Stock;
use App\Models\Stock_transaction_item;
use App\Models\Stocks_items_total;
use App\Models\Stocks_transaction;
use App\User;
use Illuminate\Http\Request;
use DB;
use Log;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class SaleInvoiceController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Invoice $object)
    {


        $this->object = $object;

        $this->viewName = 'sale-invoice.';
        $this->routeName = 'sale-invoice.';

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
        $invoices = Invoice::where('branch_id', $branch_id)->get();
        $stocks = Stock::where('branch_id', $branch_id)->get();

        return view($this->viewName . 'index', compact('branches', 'row', 'invoices', 'stocks'));
    }

    /**
     * Display a listing of the resource after getting Branch.
     *
     * @return \Illuminate\Http\Response
     */
    public function branchFetch(Request $request)
    {
        $branch_id = $request->input('branch_id');
        $row = Branch::where('id', $branch_id)->first();
        $invoices = Invoice::where('branch_id', $branch_id)->get();
        $stocks = Stock::where('branch_id', $branch_id)->get();

        return view($this->viewName . 'preIndex', compact('row', 'invoices', 'stocks',))->render();
    }
    /**
     * Show the form for creating a new resource.
     *
     * 
     */
    public function creation(Request $request)
    {
        $id = $request->input('branch');

        $branch = Branch::where('id', $id)->first();
        $stocks = Stock::where('branch_id', $id)->get();
        $persons = Person::where('person_type_id', 101)->get();
        $currencies = Currency::get();
        $paytypes = Sales_invoice_pay_type::get();
        // $orders=Order::where('PERSON_ID',)->get();
        $saleCodes = Representative::where('rep_type_id', 100)->get();

        $MarktCodes = Representative::where('rep_type_id', 101)->get();
        $orderItems = [];
        $orders = [];
        return view($this->viewName . 'new', compact('stocks', 'persons', 'orders', 'branch', 'orderItems', 'saleCodes', 'MarktCodes', 'paytypes', 'currencies'));
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
        $count = $request->rowCount;

        $details = [];
        /**
         * 1-update stock-item-total
         */
        $updateTotals = [];
        $TransactionItems = [];
        $price = 1;
        $qunty = 1;
        $disc = 0;
        for ($i = 1; $i <= $count; $i++) {
            $batch = $row = Stocks_items_total::where('id', $request->get('selectBatch' . $i))->first();

            $detail = [
                'item_id' => $request->get('select' . $i),
                'item_qty' => $request->get('qty' . $i),
                'item_price' => $request->get('itemprice' . $i),
                'total_line_cost' => $request->get('qty' . $i) * $request->get('itemprice' . $i),
                'notes' => $request->get('detNote' . $i),
                'item_disc_perc' =>  $request->get('per' . $i),
                'item_disc_value' => $request->get('disval' . $i),
                'item_bonus_qty' => $request->get('itemBonas' . $i),
                'item_vat_value' => $request->get('totalvat1' . $i),
                'final_line_cost' => ($request->get('qty' . $i) * $request->get('itemprice' . $i)) - $request->get('disval' . $i),

            ];
            if ($batch) {
                $detail['batch_no'] = $batch->batch_no;
                $detail['expired_date'] = $batch->expired_date;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
                //this for updating total qty
                $totalQty = [
                    'id' => $batch->id,
                    'item_total_qty' => $batch->item_total_qty - ($request->get('qty' . $i) + $request->get('itemBonas' . $i)),
                ];
                array_push($updateTotals, $totalQty);

                //this for updating stock_transaction_items
                $TransactionItem = [
                    'item_id' => $detail['item_id'],
                    'batch_no' => $detail['batch_no'],
                    'expired_date' => $detail['expired_date'],
                    'item_qty' => $detail['item_qty'],
                    'item_price' => $detail['item_price'],
                    'total_line_cost' => $detail['total_line_cost'],
                ];
                array_push($TransactionItems, $TransactionItem);
            }
        }
        //from order item
        $counterrrr = $request->get('counter');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {



            $batch = Stocks_items_total::where('id', $request->get('upitemBatch' . $i))->first();

            $detailUpdate = [
                'item_id' => $request->get('upitemId' . $i),
                'item_qty' => $request->get('upqty' . $i),
                'item_price' => $request->get('upitemprice' . $i),
                'total_line_cost' => $request->get('upqty' . $i) * $request->get('upitemprice' . $i),
                'notes' => $request->get('detNote' . $i),
                'item_disc_perc' =>  $request->get('upper' . $i),
                'item_disc_value' => $request->get('updisval' . $i),
                'item_bonus_qty' => $request->get('upitemBonas' . $i),
                'item_vat_value' => $request->get('uptotalvat1' . $i),
                'final_line_cost' => ($request->get('upqty' . $i) * $request->get('upitemprice' . $i)) - $request->get('updisval' . $i),

            ];
            if ($batch) {
                $detailUpdate['batch_no'] = $batch->batch_no;
                $detailUpdate['expired_date'] = $batch->expired_date;
            }

            array_push($detailsUpdate, $detailUpdate);
            //this for updating total qty
            $totalQtyUp = [
                'id' => $batch->id,
                'item_total_qty' => $batch->item_total_qty - ($request->get('upqty' . $i) + $request->get('upitemBonas' . $i)),
            ];
            array_push($updateTotals, $totalQtyUp);

            //this for updating stock_transaction_items
            $TransactionItemup = [
                'item_id' => $detailUpdate['item_id'],
                'batch_no' => $detailUpdate['batch_no'],
                'expired_date' => $detailUpdate['expired_date'],
                'item_qty' => $detailUpdate['item_qty'],
                'item_price' => $detailUpdate['item_price'],
                'total_line_cost' => $detailUpdate['total_line_cost'],
            ];
            array_push($TransactionItems, $TransactionItemup);
        }
        Log::info($counterrrr);

        // Master
        $personObj = Person::where('id', $request->get('clientPerson'))->first();
        $max = Invoice::where('branch_id', $request->input('branch'))->where('invoice_type_id', 1)->latest('invoice_no')->first();

        $max = ($max != null) ? intval($max['invoice_no']) : 0;
        $max++;


        $data = [
            'pay_type_id' => $request->get('pay_type_id'),
            'invoice_no' => $max,
            'person_id' => $request->get('clientPerson'),
            'stock_id' => $request->get('stock_id'),
            'person_name' => $request->get('person_name'),
            'person_type_id' => $personObj->person_type_id ?? 0,
            'order_id' => $request->get('orderPersons'),
            'invoice_type_id' => 1,
            'notes' => $request->get('notes'),
            'currency_id' => $request->get('currency_id'),
            'sales_rep_id' => $request->get('salePerson'),
            'marketing_rep_id' => $request->get('marketPerson'),
            'invoice_date' => Carbon::parse($request->get('invoice_date')),
            'total_items_price' => $request->get('total_items_price'),
            'total_vat_value' => $request->get('total_vat_value'),
            'total_bonus_qty' => $request->get('total_bonus_qty'),
            'local_net_invoice' => $request->get('local_net_invoice'),
            'branch_id' =>  $request->get('branch'),
        ];
        if ($request->get('orderPersons')) {
            $data['stock_id'] = Order::where('id', $request->get('orderPersons'))->first()->stock_id;
        } else {
            $data['stock_id'] = $request->get('stock_id');
        }

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
                //insert row in stock-transaction
                $maxCode = Stocks_transaction::where('primary_stock_id', $data['stock_id'])->where('transaction_type_id', 103)->latest('code')->first();

                $maxCode = ($maxCode != null) ? intval($maxCode['code']) : 0;
                $maxCode++;
                $data_transaction = [
                    'code' => $maxCode,
                    'transaction_type_id' => 103,
                    'primary_stock_id' => $data['stock_id'],
                    'person_id' => $data['person_id'],
                    'person_name' => $data['person_name'],
                    'person_type_id' => $data['person_type_id'],
                    'referance_type' => $data['order_id'] ? 1 : 0,
                    'confirmed' => 1,

                ];
                $stocks_transaction = Stocks_transaction::create($data_transaction);
                //end
                //insert row in stock-transaction - items
                foreach ($TransactionItems as $Item) {

                    $Item['transaction_id'] = $stocks_transaction->id;
                    $TransactionItem = Stock_transaction_item::create($Item);
                }
                //invoice updates

                $data['stk_transaction_id'] =$stocks_transaction->id;
                $data['confirmed'] = 1;
            }
            $invoice = Invoice::create($data);
            foreach ($details as $Item) {

                $Item['invoice_id'] = $invoice->id;
                $Invoice_Item = Invoice_item::create($Item);
            }

            foreach ($detailsUpdate as $updte) {

                $updte['invoice_id'] = $invoice->id;
                $Invoice_Item = Invoice_item::create($updte);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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


    public function orderInvoice(Request $request)
    {
        if ($request->ajax()) {

            $person_id = $request->person_id;


            $data = Order::where('person_id', $person_id)->where('confirmed', 1)->get();




            $output = '<option value="" >إختر أمر البيع</option>';
            foreach ($data as $row) {
                $output .= '<option value="' . $row->id . '">' . $row->purch_order_no . '-' . $row->person_name . '</option>';
            }



            echo  $output;
        }
    }

    /**
     * order items
     */
    public function orderItemsInvoice(Request $req)
    {

        if ($req->ajax()) {
            $rowCount = $req->rowcount;
            $order_id = $req->order_id;

            //get orderItems
            Log::info($order_id);
            $orderItems = Order_item::where('order_id', $order_id)->get();

            $ajaxComponent = view('sale-invoice.allwithStock', [
                'orderItems' => $orderItems


            ]);


            return $ajaxComponent->render();
        }
    }

    /***
     * currency
     */
    public function dynamicCurrencyRate(Request $request)
    {
        if ($request->ajax()) {

            $currency_id = $request->currency;


            $data = Currency::where('id', $currency_id)->first();




            $output = $data->conversion_rate;



            echo  $output;
        }
    }
    /**
     
     * Add Row
     */
    public function AddRow(Request $req)
    {

        if ($req->ajax()) {
            $rowCount = $req->rowcount;
            $stock_id = $req->stock;
            $order = $req->order;
            if ($order) {
                $orderObj = Order::where('id', $order)->first();
                $xx = Stocks_items_total::where('stock_id', $orderObj->stock_id)->with('item')->get();
            } else {
                $xx = Stocks_items_total::where('stock_id', $stock_id)->with('item')->get();
            }
            $collection = new Collection($xx);

            // Get all unique items.
            $itemsss = $collection->unique('item_id');
            $items = [];
            foreach ($itemsss as $detail) {
                array_push($items, $detail->item);
            }
            \Log::info($req->order);
            $ajaxComponent = view('sale-invoice.ajaxAdd', [
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
            $order = $req->order;
            $out = [];

            $items = Item::where('id', $select_value)->first();


            if ($req->select_stock) {
                $data = Stocks_items_total::where('item_id', $select_value)->where('stock_id', $select_stock)->get();
            } else {
                $order = Order::where('id', $order)->first();
                $data = Stocks_items_total::where('item_id', $select_value)->where('stock_id', $order->stock_id)->get();
            }


            $output = '<option value="" selected="" disabled="">إختر الباتش</option>';
            foreach ($data as $row) {
                $date = date_create($row->expired_date);
                $output .= '<option value="' . $row->id . '">' . $row->batch_no . '-' . date_format($date, "d-m-Y") . '-' . $row->item_total_qty . '</option>';
            }



            echo json_encode(array($items->ar_name, $items->uom->ar_name ?? '', $output, $items->vat_value));
        }
    }
    /**
     * edit batch
     */
    public function editSelectBatch(Request $req)
    {

        if ($req->ajax()) {

            $select_value = $req->select_value;
            $person = $req->person;
            $Categoryprice = 0;
            $CategoryDis = 0;
            $row = Stocks_items_total::where('id', $select_value)->first();

            $personObj = Person::where('id', $person)->first();
            $date = date_create($row->expired_date);

            $disc = 0;

            $ItemPrice = Item::where('id', $row->item_id)->first();

            $Clientprice = Items_price::where('item_id', $row->item_id)->where('client_id', $person)->first();
            if ($personObj) {
                $Categoryprice = Items_price::where('item_id', $row->item_id)->where('client_category_id', $personObj->person_category_id)->first();
            }
            $outs = 0;
            if ($Clientprice) {

                $outs = $Clientprice->item_price;
            } else if ($Categoryprice) {

                $outs = $Categoryprice->item_price;
            } else {

                $outs = $ItemPrice->retail_price;
                Log::info("vv");
            }
            //discount
            Log::info($outs);

            $ClientDis = Items_discount::where('item_id', $row->item_id)->where('client_id', $person)->first();
            if ($personObj) {
                $CategoryDis = Items_discount::where('item_id', $row->item_id)->where('client_category_id', $personObj->person_category_id)->first();
            }

            if ($ClientDis) {

                $disc = $ClientDis->item_discount_price;
            } else if ($CategoryDis) {

                $disc = $CategoryDis->item_discount_price;
            } else {

                $disc = 0;
            }


            echo json_encode(array($row->batch_no,  date_format($date, "d-m-Y"), $row->item_total_qty, $outs, $disc));
        }
    }
}
