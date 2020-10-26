<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additive_item;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\Inv_additive_item;
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
use App\Models\stocks_item_category;
use App\Models\Stocks_items_total;
use App\Models\Stocks_transaction;
use App\User;
use Illuminate\Http\Request;
use DB;
use Log;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class PurchInvoiceController extends Controller
{

    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Invoice $object)
    {


        $this->object = $object;

        $this->viewName = 'purch-invoice.';
        $this->routeName = 'purch-invoice.';
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
        $invoices = Invoice::where('branch_id', $branch_id)->where('invoice_type_id', 2)->get();
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
        $invoices = Invoice::where('branch_id', $branch_id)->where('invoice_type_id', 2)->get();
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
        $persons = Person::where('person_type_id', 100)->get();
        $currencies = Currency::get();
        $orderItems = [];
        $transactionsItems = [];
        $stocks_transactions = Stocks_transaction::where('transaction_type_id', 101)->where('confirmed', 1)->get();
        return view($this->viewName . 'new', compact('stocks', 'persons', 'stocks_transactions', 'orderItems', 'branch', 'transactionsItems', 'currencies'));
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
        $itemsTotals = [];

        for ($i = 1; $i <= $count; $i++) {
            $batch = $row = Stocks_items_total::where('id', $request->get('selectBatch' . $i))->first();

            $detail = [
                'item_id' => $request->get('select' . $i),
                'item_qty' => $request->get('qty' . $i),
                'item_price' => $request->get('itemprice' . $i),
                'batch_no' => $request->get('Batch' . $i),
                'total_line_cost' =>$request->get('qty' . $i)*$request->get('itemprice' . $i),
                'expired_date' => Carbon::parse($request->get('exDate' . $i)),
                'notes' => $request->get('detNote' . $i),

            ];

            if ($request->get('qty' . $i)) {
                array_push($details, $detail);

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

            $updateTotal = [
                'item_id' => $detail['item_id'],
                'batch_no' => $detail['batch_no'],
                'expired_date' => $detail['expired_date'],
                'item_qty_unconfirmed' => $detail['item_qty'],
            ];
            if ($request->get('transaction_id')) {
                $updateTotal['stock_id'] = Stocks_transaction::where('id', $request->get('transaction_id'))->first()->primary_stock_id;
            } else {
                $updateTotal['stock_id'] = $request->get('stock_id');
            }
            array_push($updateTotals, $updateTotal);
        }
        //from order item
        $counterrrr = $request->get('counter');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {

            
            $batch = $row = Stocks_items_total::where('id', $request->get('upitemBatch' . $i))->first();


            $detailUpdate = [
                'item_id' => $request->get('upitemId' . $i),
                'item_qty' => $request->get('upqty' . $i),
               
                'item_price' => $request->get('upitemprice' . $i),
                'total_line_cost' =>$request->get('upqty' . $i)*$request->get('upitemprice' . $i),

                'notes' => $request->get('updetNote' . $i),

            ];
            if ($batch) {
                $detailUpdate['batch_no'] = $batch->batch_no;
                $detailUpdate['expired_date'] = $batch->expired_date;
            }

            array_push($detailsUpdate, $detailUpdate);
            \Log::info($detailsUpdate);

            $updateTotal = [
                'item_id' => $detailUpdate['item_id'],
                'batch_no' => $detailUpdate['batch_no'],
                'expired_date' => $detailUpdate['expired_date'],
                'item_qty_unconfirmed' => $detailUpdate['item_qty'],
            ];
            if ($request->get('transaction_id')) {
                $updateTotal['stock_id'] = Stocks_transaction::where('id', $request->get('transaction_id'))->first()->primary_stock_id;
            } else {
                $updateTotal['stock_id'] = $request->get('stock_id');
            }
            array_push($updateTotals, $updateTotal);
        }
        //Locals
        $localCounter = $request->get('rowCountt');

        $locals = [];

        for ($i = 1; $i <= $localCounter; $i++) {




            $local = [
                'additive_item_id' => $request->get('select_add' . $i),
                'additive_item_value' => $request->get('localVal' . $i),


            ];


            array_push($locals, $local);
            \Log::info($locals);
        }
        // Master
        $personObj = Person::where('id', $request->get('person_id'))->first();
        $max = Invoice::where('branch_id', $request->input('branch'))->where('invoice_type_id', 2)->latest('invoice_no')->first();

        $max = ($max != null) ? intval($max['invoice_no']) : 0;
        $max++;


        $data = [

            'invoice_no' => $max,
            'invoice_serial' => $request->get('invoice_serial'),
            'person_id' => $request->get('person_id'),
            'stock_id' => $request->get('stock_id'),
            'person_name' => $personObj->name ?? '',
            'person_type_id' => $personObj->person_type_id ?? 0,
            'stk_transaction_id' => $request->get('transaction_id'),
            'invoice_type_id' => 2,
            'notes' => $request->get('notes'),
            'currency_id' => $request->get('currency_id'),
            'invoice_date' => Carbon::parse($request->get('invoice_date')),
            'total_items_price' => $request->get('total_items_price'),
            'total_invoice_additive' => $request->get('local_total'),
            'local_net_invoice' => $request->get('local_net_invoice'),
            'branch_id' =>  $request->get('branch'),
        ];
        if ($request->get('optionsRadios1') == 'option1') {
            $data['purch_invoice_reference'] = 1 ;
        } else {
            $data['purch_invoice_reference'] = 0;
        }
        if ($request->get('transaction_id')) {
            $data['stock_id'] = Stocks_transaction::where('id', $request->get('transaction_id'))->first()->primary_stock_id;
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
                foreach ($updateTotals as $updateTotal) {
                    $tot = [
                        'item_id' => $updateTotal['item_id'],
                        'stock_id' => $updateTotal['stock_id'],
                        'batch_no' => $updateTotal['batch_no'],
                        'expired_date' => $updateTotal['expired_date'],
                    ];
                    \Log::info(['message', $updateTotal]);
                    $trans = Stocks_items_total::where('item_id', $tot['item_id'])->where('stock_id', $tot['stock_id'])->where('expired_date', $tot['expired_date'])->where('batch_no', $tot['batch_no'])->first();
                    if ($trans) {
                        $trans->item_qty_unconfirmed =  $trans->item_qty_unconfirmed - $updateTotal['item_qty_unconfirmed'];
                        $trans->item_total_qty =  $trans->item_total_qty + $updateTotal['item_qty_unconfirmed'];

                        $trans->update();
                    }
                }
            }
            if ($details) {
                //insert row in stock-transaction
                $maxCode = Stocks_transaction::where('primary_stock_id', $data['stock_id'])->where('transaction_type_id', 103)->latest('code')->first();

                $maxCode = ($maxCode != null) ? intval($maxCode['code']) : 0;
                $maxCode++;
                $data_transaction = [
                    'code' => $maxCode,
                    'transaction_type_id' => 101,
                    'primary_stock_id' => $data['stock_id'],
                    'person_id' => $data['person_id'],
                    'person_name' => $data['person_name'],
                    'person_type_id' => $data['person_type_id'],
                    'referance_type' => 0,
                    'confirmed' => 0,

                ];
                $stocks_transaction = Stocks_transaction::create($data_transaction);
                //end
                //insert row in stock-transaction - items
                foreach ($TransactionItems as $Item) {

                    $Item['transaction_id'] = $stocks_transaction->id;
                    $TransactionItem = Stock_transaction_item::create($Item);
                }

                foreach ($TransactionItems as $Items) {
                    $xx = [
                        'item_id' => $Items['item_id'],
                        'stock_id' => $Items['stock_id'],
                        'batch_no' => $Items['batch_no'],
                        'expired_date' => $Items['expired_date'],
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
                //invoice updates

                $data['stk_transaction_id'] = $stocks_transaction->id;
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
            //locals
            if ($locals) {

                $invoice->additive()->sync($locals);
            } else {
                $invoice->additive()->detach();
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
        $invObj = Invoice::where('id', $id)->first();
        $invItems = Invoice_item::where('invoice_id', $id)->get();
        $branch = Branch::where('id', $invObj->branch_id)->first();
        $stocks = Stock::where('branch_id', $invObj->branch_id)->get();
        $persons = Person::where('person_type_id', 100)->get();
        $currencies = Currency::get();
        $currencyRate = Currency::where('id', $invObj->currency_id)->first();
        $stocks_transactions = Stocks_transaction::where('transaction_type_id', 101)->where('confirmed', 1)->get();
        $transactionsItems = Stock_transaction_item::where('transaction_id', $id)->get();
        $locals = Additive_item::all();
        $localsItems =Inv_additive_item::where('invoice_id', $id)->get();
        return view($this->viewName . 'view', compact('invObj', 'invItems','locals','localsItems', 'stocks', 'persons', 'stocks_transactions', 'branch', 'transactionsItems', 'currencies'));
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invObj = Invoice::where('id', $id)->first();
        $invItems = Invoice_item::where('invoice_id', $id)->get();
        $branch = Branch::where('id', $invObj->branch_id)->first();
        $stocks = Stock::where('branch_id', $invObj->branch_id)->get();
        $persons = Person::where('person_type_id', 100)->get();
        $currencies = Currency::get();
        $currencyRate = Currency::where('id', $invObj->currency_id)->first();
        $stocks_transactions = Stocks_transaction::where('transaction_type_id', 101)->where('confirmed', 1)->get();
        $transactionsItems = Stock_transaction_item::where('transaction_id', $id)->get();
        $locals = Additive_item::all();
        $localsItems =Inv_additive_item::where('invoice_id', $id)->get();
        return view($this->viewName . 'edit', compact('invObj', 'invItems','locals','localsItems', 'stocks', 'persons', 'stocks_transactions', 'branch', 'transactionsItems', 'currencies'));
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
        $TransactionItems = [];
        $itemsTotals = [];

        for ($i = 1; $i <= $count; $i++) {
            $batch = $row = Stocks_items_total::where('id', $request->get('selectBatch' . $i))->first();

            $detail = [

                'item_id' => $request->get('select' . $i),
                'item_qty' => $request->get('qty' . $i),
                'item_price' => $request->get('itemprice' . $i),
                'batch_no' => $request->get('Batch' . $i),
                'expired_date' => Carbon::parse($request->get('exDate' . $i)),
                'notes' => $request->get('detNote' . $i),

            ];

            if ($request->get('qty' . $i)) {
                array_push($details, $detail);

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

            $updateTotal = [
                'item_id' => $detail['item_id'],
                'batch_no' => $detail['batch_no'],
                'expired_date' => $detail['expired_date'],
                'item_qty_unconfirmed' => $detail['item_qty'],
            ];
            if ($request->get('transaction_id')) {
                $updateTotal['stock_id'] = Stocks_transaction::where('id', $request->get('transaction_id'))->first()->primary_stock_id;
            } else {
                $updateTotal['stock_id'] = $request->get('stock_id');
            }
            array_push($updateTotals, $updateTotal);
        }
        //from order item
        $counterrrr = $request->get('counter');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {

            
            $batch = $row = Stocks_items_total::where('id', $request->get('upitemBatch' . $i))->first();


            $detailUpdate = [
                'id' => $request->get('item_inv_id' . $i),
                'item_id' => $request->get('upitemId' . $i),
                'item_qty' => $request->get('upqty' . $i),
            
                'item_price' => $request->get('upitemprice' . $i),
               
                'notes' => $request->get('updetNote' . $i),

            ];
            if ($batch) {
                $detailUpdate['batch_no'] = $batch->batch_no;
                $detailUpdate['expired_date'] = $batch->expired_date;
            }

            array_push($detailsUpdate, $detailUpdate);
            \Log::info($detailsUpdate);

            // $updateTotal = [
            //     'item_id' => $detailUpdate['item_id'],
            //     'batch_no' => $detailUpdate['batch_no'],
            //     'expired_date' => $detailUpdate['expired_date'],
            //     'item_qty_unconfirmed' => $detailUpdate['item_qty'],
            // ];
            // if ($request->get('transaction_id')) {
            //     $updateTotal['stock_id'] = Stocks_transaction::where('id', $request->get('transaction_id'))->first()->primary_stock_id;
            // } else {
            //     $updateTotal['stock_id'] = $request->get('stock_id');
            // }
            // array_push($updateTotals, $updateTotal);
        }
        //Locals
        $localCounter = $request->get('rowCountt');

        $locals = [];

        for ($i = 1; $i <= $localCounter; $i++) {




            $local = [
                'additive_item_id' => $request->get('select_add' . $i),
                'additive_item_value' => $request->get('localVal' . $i),


            ];


            array_push($locals, $local);
            \Log::info($locals);
        }
        // Master
        $personObj = Person::where('id', $request->get('person_id'))->first();
      


        $data = [

           
            'invoice_serial' => $request->get('invoice_serial'),
           
            'notes' => $request->get('notes'),
           
            'invoice_date' => Carbon::parse($request->get('invoice_date')),
            'total_items_price' => $request->get('total_items_price'),
            'total_invoice_additive' => $request->get('local_total'),
            'local_net_invoice' => $request->get('local_net_invoice'),
            
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
                $data['confirmed'] = 1;
                foreach ($updateTotals as $updateTotal) {
                    $tot = [
                        'item_id' => $updateTotal['item_id'],
                        'stock_id' => $updateTotal['stock_id'],
                        'batch_no' => $updateTotal['batch_no'],
                        'expired_date' => $updateTotal['expired_date'],
                    ];
                    \Log::info(['message', $updateTotal]);
                    $trans = Stocks_items_total::where('item_id', $tot['item_id'])->where('stock_id', $tot['stock_id'])->where('expired_date', $tot['expired_date'])->where('batch_no', $tot['batch_no'])->first();
                    if ($trans) {
                        $trans->item_qty_unconfirmed =  $trans->item_qty_unconfirmed - $updateTotal['item_qty_unconfirmed'];
                        $trans->item_total_qty =  $trans->item_total_qty + $updateTotal['item_qty_unconfirmed'];

                        $trans->update();
                    }
                }
            }
            if ($details) {
                //insert row in stock-transaction
                $maxCode = Stocks_transaction::where('primary_stock_id', Invoice::where('id',$id)->first()->primary_stock_id)->where('transaction_type_id', 103)->latest('code')->first();

                $maxCode = ($maxCode != null) ? intval($maxCode['code']) : 0;
                $maxCode++;
                $data_transaction = [
                    'code' => $maxCode,
                    'transaction_type_id' => 101,
                    'primary_stock_id' =>Invoice::where('id',$id)->first()->primary_stock_id ?? '',
                    'person_id' => Invoice::where('id',$id)->first()->person_id ?? '',
                    'person_name' => Invoice::where('id',$id)->first()->person_name ?? '',
                    'person_type_id' =>Invoice::where('id',$id)->first()->person_type_id ?? '',
                    'referance_type' => 0,
                    'confirmed' => 0,

                ];
                $stocks_transaction = Stocks_transaction::create($data_transaction);
                //end
                //insert row in stock-transaction - items
                foreach ($TransactionItems as $Item) {

                    $Item['transaction_id'] = $stocks_transaction->id;
                    $TransactionItem = Stock_transaction_item::create($Item);
                }

                foreach ($TransactionItems as $Items) {
                    $xx = [
                        'item_id' => $Items['item_id'],
                        'stock_id' => $Items['stock_id'],
                        'batch_no' => $Items['batch_no'],
                        'expired_date' => $Items['expired_date'],
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
                //invoice updates

                $data['stk_transaction_id'] = $stocks_transaction->id;
            }
            Invoice::where('id', $id)->update($data);

            foreach ($details as $Item) {

                $Item['invoice_id'] = $id;
                $Item['total_line_cost'] =$Item['item_qty']*$Item['item_price'];
                $Invoice_Item = Invoice_item::create($Item);
            }

            foreach ($detailsUpdate as $updte) {

                $updte['invoice_id'] = $id;
                $updte['total_line_cost'] = $updte['item_qty']*$updte['item_price'];
                Invoice_item::where('id', $updte['id'])->update($updte);
            }
            //locals
            $invoice=Invoice::where('id',$id)->first();

            if ($locals) {
                $invoice->additive()->sync($locals);
            } else {
                $invoice->additive()->detach();
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Invoice::where('id', $id)->first();
        // Delete File ..


        try {
            $row->item()->delete();
            $row->delete();
        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', $q->getMessage());
        }
        return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');
   
    }


    /**
     
     * Add Row
     */
    public function AddRow(Request $req)
    {

        if ($req->ajax()) {
            $rowCount = $req->rowcount;
            $stock_id = $req->stock;
            $supplier = $req->person;
            $sub = stocks_item_category::where('stock_id', $stock_id)->pluck('id');

            $items = Item::where('person_id', $supplier)->orWhereNull('person_id')->whereIN('item_category_id', $sub)->get();

            $ajaxComponent = view('purch-invoice.ajaxAdd', [
                'rowCount' => $rowCount,
                'items' => $items,

            ]);


            return $ajaxComponent->render();
        }
    }

    public function addRowLocal(Request $req)
    {

        if ($req->ajax()) {
            $rowCount = $req->rowcount;

            \Log::info(['no of rows', $rowCount]);


            $locals = Additive_item::all();
            $ajaxComponent = view('purch-invoice.local', [
                'rowCountt' => $rowCount,
                'locals' => $locals,

            ]);


            return $ajaxComponent->render();
        }
    }

    /***
     * itemsInvoice
     */
    public function itemsInvoice(Request $req)
    {

        if ($req->ajax()) {
            $transaction_id = $req->transaction_id;
            \Log::info($transaction_id);

            //get orderItems
            $transactionsItems = Stock_transaction_item::where('transaction_id', $transaction_id)->get();
            $ajaxComponent = view('purch-invoice.allwithStock', [
                'transactionsItems' => $transactionsItems


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


     /***
     * Del
     */
    public function DeleteLocalItem(Request $req)
    {


        if ($req->ajax()) {

            $obo = Invoice_item::where('id', $req->id)->first();

            $invoices = Invoice::where('id', $obo->invoice_id)->first();

            
            $ss = [
                'total_invoice_additive' => $invoices->total_items_price - $obo->total_invoice_additive,
                'local_net_invoice' =>  $invoices->local_net_invoice - $obo->total_invoice_additive,
               
            ];
            Invoice::where('id', $obo->invoice_id)->update($ss);
            $invoices->additive()->detach();
            Invoice_item::where('id', $req->id)->delete();

        }
    }
}
