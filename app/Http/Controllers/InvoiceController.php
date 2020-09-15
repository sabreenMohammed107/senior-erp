<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Admin_branch;
use App\Models\Item_category;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\Users_branch;
use App\User;
use Carbon\Carbon;
use App\Mail\MyTestMail;
use DB;

class InvoiceController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Invoice $object)
    {


        $this->object = $object;
        $this->viewName = 'invoice.';
        $this->routeName = 'invoice.';

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
        $row = new Admin_branch();
        $branch_id = 0;
        $invoices = Invoice::where('branch_id', $branch_id)->get();
        $stocks = DB::table('stocks')->get();

        return view($this->viewName . 'index', compact('branches', 'row', 'invoices', 'stocks'));
    }


    public function branchFetch(Request $request)
    {
        $branch_id = $request->input('branch_id');
        $row = Admin_branch::where('id', $branch_id)->first();
        $invoices = Invoice::where('branch_id', $branch_id)->get();
        $stocks = DB::table('stocks')->get();
        return view($this->viewName . 'preIndex', compact('row', 'invoices', 'stocks'))->render();
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

        $branch = DB::table('admin_branches')->where('id', $id)->first();
        $stocks = DB::table('stocks')->get();
        $persons = DB::table('persons')->where('PERSON_TYPE_ID', 1)->get();
        $currencies = DB::table('currency')->get();
        $paytypes = DB::table('sales_invoice_pay_type')->get();
        // $orders=Order::where('PERSON_ID',)->get();
        $orderItems = [];
        $orders = [];
        return view($this->viewName . 'new', compact('stocks', 'persons', 'orders', 'branch', 'orderItems', 'paytypes', 'currencies'));
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
        $price = 1;
        $qunty = 1;
        $disc = 0;
        for ($i = 1; $i <= $count; $i++) {

            $price = $request->get('itemprice' . $i) * $request->get('qty' . $i);
            $qunty = $request->get('disval' . $i);

            $disc = $price - $qunty;
            $itemData = DB::table('stocks_items_total')->where('ITEM_ID',  $request->get('select' . $i))->first();

            $detail = [
                'ITEM_ID' => $request->get('select' . $i),
                'BATCH_NO' => $request->get('batchNum1' . $i),
                'ITEM_QTY' => $request->get('qty' . $i),
                'EXPIRED_DATE' => Carbon::parse($request->get('batchDate1' . $i)),
                'ITEM_PRICE' => $request->get('itemprice' . $i),
                'TOTAL_LINE_COST' => ($request->get('itemprice' . $i)) * ($request->get('qty' . $i)),
                'NOTES' => $request->get('detNote' . $i),
                'ITEM_DISC_PERC' =>  $request->get('per' . $i),
                'ITEM_DISC_VALUE' => $request->get('disval' . $i),
                'FINAL_LINE_COST' => $disc,
                'ITEM_BONUS_QTY' => $request->get('bonas' . $i),
                'ITEM_VAT_VALUE' => $request->get('totalvat1' . $i),
                'ITEM_VAT_PERC' => $request->get('totalcit1' . $i),

            ];

            array_push($details, $detail);
        }

        //update Details
        $counterrrr = $request->get('qqq');
        $detailsUpdate = [];
        $priceup = 1;
        $quntyup = 1;
        $discup = 0;
        for ($i = 1; $i <= $counterrrr; $i++) {

            $priceup = $request->get('itempriceup' . $i) * $request->get('qtyup' . $i);
            $quntyup = $request->get('disvalup' . $i);
            $discup = $price - $qunty;

            $detailUpdate = [
                'ITEM_ID' => $request->get('selectup' . $i),
                'BATCH_NO' => $request->get('batchNum1' . $i),
                'ITEM_QTY' => $request->get('qtyup' . $i),
                'EXPIRED_DATE' => Carbon::parse($request->get('batchDate1up' . $i)),
                'ITEM_PRICE' => $request->get('itempriceup' . $i),
                'TOTAL_LINE_COST' => $price,
                'NOTES' => $request->get('detNoteup' . $i),
                'ITEM_DISC_PERC' =>  $request->get('perup' . $i),
                'ITEM_DISC_VALUE' => $request->get('disvalup' . $i),
                'FINAL_LINE_COST' => $disc,
                'ITEM_BONUS_QTY' => $request->get('bonasup' . $i),
                'ITEM_VAT_VALUE' => $request->get('totalvat1' . $i),
                'ITEM_VAT_PERC' => $request->get('totalcit1' . $i),


            ];
            array_push($detailsUpdate, $detailUpdate);
        }
        // Master

        $max = Invoice::latest('INVOICE_NO')->where('branch_id', $request->get('branch'))->first();

        // $max = ($max != null && $max != 0) ? $max : 0;
        $max = ($max != null) ? intval($max['INVOICE_NO']) : 0;
        $max++;
        $data = [
            'INVOICE_DATE' => Carbon::parse($request->get('invoice_date')),
            'INVOICE_NO' => $max,
            'INVOICE_TYPE_ID' => 102,
            'PERSON_ID' => $request->get('clientPerson'),
            'STOCK_ID' => $request->get('stock_id'),
            'PERSON_NAME' => $request->get('person_name'),
            'PERSON_TYPE_ID' => 1,
            'ORDER_ID' => $request->get('orderPersons'),
            'TOTAL_ITEMS_PRICE' => $request->get('total_items_price'),
            'LOCAL_NET_INVOICE' => $request->get('LOCAL_NET_INVOICE'),
            'TOTAL_DISC_VALUE' => $request->get('total_items_discount'),
            'TOTAL_VAT_VALUE' => $request->get('total_vat_value'),
            'PAY_TYPE_ID' => $request->get('pay_type_id'),
            'branch_id' => $request->get('branch'),
            'NOTES' => $request->get('notes')
        ];
        // DB::beginTransaction();
        //  try {

        $invoice = DB::table('invoices')->insertGetId($data);
        $invMail = DB::table('invoices')->where('INVOICE_ID', $invoice)->first();
        $emails = ['senior.steps.info@gmail.com'];
        \Mail::to($emails)->send(new MyTestMail($invMail));

        if ($request->get('optionsRadios') == 'option1') {

            foreach ($details as $Item) {

                $Item['INVOICE_ID'] = $invoice;

                $Invoice_Item = DB::table('invoice_items')->insert($Item);
            }
        } else {
            foreach ($detailsUpdate as $Item) {

                $Item['INVOICE_ID'] = $invoice;

                $Invoice_Item = DB::table('invoice_items')->insert($Item);
            }
        }

        // DB::commit();
        //static user this will be logined
        $user = User::where('id', 1)->first();
        $branches = $user->branch;
        $row = new Admin_branch();
        $branch_id = 0;
        $invoices = Invoice::where('branch_id', $branch_id)->get();
        $stocks = DB::table('stocks')->get();
        return redirect()->route($this->routeName . 'index', compact('branches', 'row', 'invoices', 'stocks'))->with('flash_success', "تم اضافة أمر بيع :");

        // } catch (\Throwable $th) {
        //     // throw $th;
        //     DB::rollBack();
        //     //static user this will be logined
        //     $user = User::where('id', 1)->first();
        //     $branches = $user->branch;
        //     $row = new Admin_branch();
        //     $branch_id = 0;
        //     $invoices = Invoice::where('branch_id', $branch_id)->get();
        //     $stocks = DB::table('stocks')->get();
        //     return redirect()->route($this->routeName . 'index', compact('branches', 'row', 'invoices', 'stocks'))->with('flash_danger', "حدث خطأ ما يرجي اعادة المحاولة");

        // }
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


            $data = Order::where('PERSON_ID', $person_id)->get();




            $output = '<option value="" >إختر أمر البيع</option>';
            foreach ($data as $row) {
                $output .= '<option value="' . $row->ORDER_ID . '">' . $row->ORDER_SERIAL . '-' . $row->PERSON_NAME . '</option>';
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

            //get subcategories

            $orderItems = Order_items::where('ORDER_ID', $order_id)->get();

            $ajaxComponent = view('invoice.allwithStock', [
                'orderItems' => $orderItems


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
            $rowCount = $req->rowCount;
            $order_id = $req->order;
            $stock_id = $req->stock;

            //get subcategories

            //get subcategories
            $sub = DB::table('stocks_items_categories')->where('STOCK_ID', $stock_id)->pluck('ITEM_CATEGORY_ID');

            $items = DB::table('items')->whereIN('ITEM_CATEGORY_ID', $sub)->get();

            $ajaxComponent = view('invoice.ajaxAdd', [
                'rowCount' => $rowCount,
                'items' => $items


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
            $out = [];

            $items = DB::table('items')->where('ITEM_ID', $select_value)->first();



            $data = DB::table('stocks_items_total')->where('ITEM_ID', $select_value)->get();



            $output = '<option value="" selected="" disabled="">إختر الباتش</option>';
            foreach ($data as $row) {
                $date = date_create($row->EXPIRED_DATE);
                $output .= '<option value="' . $row->STOCK_ITEMS_ID . '">' . $row->BATCH_NO . '-' . date_format($date, "d-m-Y") . '-' . $row->ITEM_TOTAL_QTY . '</option>';
            }



            echo json_encode(array($items->ITEM_AR_NAME, $items->DEFAULT_UOM_ID, $output, $items->VAT_VALUE));
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

            $row = DB::table('stocks_items_total')->where('STOCK_ITEMS_ID', $select_value)->first();
            $personObj = DB::table('persons')->where('PERSON_ID', $person)->first();
            $date = date_create($row->EXPIRED_DATE);
            $outs = 0;
            $ItemPrice = DB::table('items')->where('ITEM_ID', $select_value)->first();
            $Clientprice = DB::table('items_prices')->where('ITEM_ID', $select_value)->where('CLIENT_ID', $person)->first();
            $Categoryprice = DB::table('items_prices')->where('ITEM_ID', $select_value)->where('CLIENT_CATEGORY_ID', $personObj->PERSON_CATEGORY_ID)->first();

            if ($Clientprice) {

                $outs = $Clientprice->ITEM_PRICE;
            } elseif ($Categoryprice) {

                $outs = $Categoryprice->ITEM_PRICE;
            } else {

                $outs = $ItemPrice->RETAIL_PRICE;
            }


            echo json_encode(array($row->BATCH_NO,  date_format($date, "d-m-Y"), $row->ITEM_TOTAL_QTY, $outs));
        }
    }
}
