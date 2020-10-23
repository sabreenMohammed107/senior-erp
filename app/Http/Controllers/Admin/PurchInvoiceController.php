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
        $invoices = Invoice::where('branch_id', $branch_id)->where('invoice_type_id',2)->get();
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
        $invoices = Invoice::where('branch_id', $branch_id)->where('invoice_type_id',2)->get();
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
        $orderItems=[]; 
        $transactionsItems = [];
        $stocks_transactions =Stocks_transaction::where('transaction_type_id',101)->where('confirmed',1)->get();
        return view($this->viewName . 'new', compact('stocks', 'persons', 'stocks_transactions','orderItems', 'branch', 'transactionsItems', 'currencies'));
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
        //
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

            $ajaxComponent = view('sale-invoice.ajaxAdd', [
                'rowCount' => $rowCount,
                'items' => $items,

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
}
