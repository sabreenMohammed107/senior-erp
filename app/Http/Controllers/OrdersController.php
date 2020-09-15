<?php

namespace App\Http\Controllers;

use App\Models\Admin_branch;
use App\Models\Item_category;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\Users_branch;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class OrdersController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Order $object)
    {


        $this->object = $object;
        $this->viewName = 'orders.';
        $this->routeName = 'orders.';

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
        $orders = Order::where('branch_id', $branch_id)->get();
        $stocks = DB::table('stocks')->get();

        return view($this->viewName . 'index', compact('branches', 'row', 'orders', 'stocks'));
    }
    public function branchFetch(Request $request)
    {
        $branch_id = $request->input('branch_id');
        $row = Admin_branch::where('id', $branch_id)->first();
        $orders = Order::where('branch_id', $branch_id)->get();
        $stocks = DB::table('stocks')->get();
        return view($this->viewName . 'preIndex', compact('row', 'orders', 'stocks'))->render();
    }

    public function AddRow(Request $req)
    {

        if ($req->ajax()) {
            $rowCount = $req->rowcount;
            $stock_id = $req->stock;

            //get subcategories
            $sub = DB::table('stocks_items_categories')->where('STOCK_ID', $stock_id)->pluck('ITEM_CATEGORY_ID');

            $items = DB::table('items')->whereIN('ITEM_CATEGORY_ID', $sub)->get();

            $ajaxComponent = view('orders.ajaxAdd', [
                'rowCount' => $rowCount,
                'items' => $items,

            ]);


            return $ajaxComponent->render();
        }
    }
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



            echo json_encode(array($items->ITEM_AR_NAME, $items->DEFAULT_UOM_ID, $output));
        }
    }
    public function editSelectValPerson(Request $req)
    {
        if ($req->ajax()) {

            $select_value = $req->select_value;


            $personObj = DB::table('persons')->where('PERSON_ID', $select_value)->first();

            $saleCode = DB::table('representatives')->where('REP_ID', $personObj->SALES_REP_ID)->first();

            $MarktCode = DB::table('representatives')->where('REP_ID', $personObj->MARKETING_REP_ID)->first();






            echo json_encode(array($saleCode->REP_CODE, $saleCode->REP_AR_NAME, $MarktCode->REP_CODE, $MarktCode->REP_AR_NAME, $personObj->PERSON_NAME));
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stocks = DB::table('stocks')->get();
        $persons = DB::table('persons')->where('PERSON_TYPE_ID', 1)->get();
        return view($this->viewName . 'add', compact('stocks', 'persons'));
    }

    public function creation(Request $request)
    {

        $id = $request->input('branch');

        $branch = DB::table('admin_branches')->where('id', $id)->first();
        $stocks = DB::table('stocks')->get();
        $persons = DB::table('persons')->where('PERSON_TYPE_ID', 1)->get();
        $currencies = DB::table('currency')->get();
        
        return view($this->viewName . 'new', compact('stocks', 'persons', 'branch', 'currencies'));
    }

    /*

    */
    public function ajaxStore(Request $request)
    {
        $Inv = $request->invoice;
        $Inv_items = $request->invoice_items;

        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                $Inv = $request->invoice;
                $Inv_items = $request->invoice_items;
                $data = [
                    'ORDER_DATE' => Carbon::create($Inv['order_date']),
                ];
                $Invoice = DB::table('orders')->create($Inv);
                // foreach ($Inv_items as $key => $Item) {
                //     if ($Item['is_stored'] == 'no') {
                //         $Item['store_item'] = 0;
                //     } else {
                //         $Item['store_item'] = 1;
                //     }
                //     $Item['inv_id'] = $Invoice->id;
                //     $Invoice_Item = InvoiceItem::create($Item);
                // }
                $request->session()->flash('flash_success', "تم اضافة الفاتورة رقم : $Invoice->invoice_no");
                DB::commit();

                return url('/orders');
            } catch (\Throwable $th) {
                // throw $th;
                DB::rollBack();
                $request->session()->flash('flash_danger', "حدث خطأ ما يرجي اعادة المحاولة");
                return url('/orders');
            }
        }
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
            $detail = [
                'ITEM_ID' => $request->get('select' . $i),
                'BATCH_NO' => $request->get('selectBatch' . $i),
                'ITEM_QTY' => $request->get('qty' . $i),
                'ITEM_PRICE' => $request->get('itemprice' . $i),
                'TOTAL_LINE_COST' => $price,
                'NOTES' => $request->get('detNote' . $i),
                'ITEM_DISC_PERC' =>  $request->get('per' . $i),
                'ITEM_DISC_VALUE' => $request->get('disval' . $i),
                'FINAL_LINE_COST' => $disc,

            ];
            array_push($details, $detail);

            
        }
        // Master
        $personObj = DB::table('persons')->where('PERSON_ID', $request->get('person_name'))->first();
        if ($personObj) {
            $saleCode = DB::table('representatives')->where('REP_ID', $personObj->SALES_REP_ID)->first();

            $MarktCode = DB::table('representatives')->where('REP_ID', $personObj->MARKETING_REP_ID)->first();
        }

        $data = [
            'PURCH_ORDER_NO' => 4,
            'PERSON_ID' => $request->get('person_id'),
            'STOCK_ID' => $request->get('stock_id'),
            'PERSON_NAME' => $request->get('person_name'),
            'ORDER_TYPE_ID' => 1,
            'ORDER_DESCRIPTION' => $request->get('decOrder'),


            'SALES_REP_ID' => $saleCode->REP_ID ?? '',
            'MARKETING_REP_ID' => $MarktCode->REP_ID ?? '',
            'ORDER_DATE' => Carbon::parse($request->get('order_date')),
            'RECEIVED_DATE_SUGGESTED' => Carbon::parse($request->get('order_delev')),
            'ORDER_VALUE' => $request->get('total_items_price'),
            'TOTAL_DISC_VALUE' => $request->get('total_items_discount'),
            'TOTAL_FINAL_COST' => $request->get('total_items_final'),
            'branch_id' => 1,
        ];
        DB::beginTransaction();
        try {

            $order = DB::table('orders')->insertGetId($data);
            foreach ($details as $Item) {

                $Item['ORDER_ID'] = $order;
                $Invoice_Item = DB::table('order_items')->insert($Item);
            }
            $request->session()->flash('flash_success', "تم اضافة أمر بيع :");
            DB::commit();
            //static user this will be logined
            $user = User::where('id', 1)->first();
            $branches = $user->branch;
            $row = new Admin_branch();
            $branch_id = 0;
            $orders = Order::where('branch_id', $branch_id)->get();
            $stocks = DB::table('stocks')->get();

            return view($this->viewName . 'index', compact('branches', 'row', 'orders', 'stocks'));
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            $request->session()->flash('flash_danger', "حدث خطأ ما يرجي اعادة المحاولة");
            //static user this will be logined
            $user = User::where('id', 1)->first();
            $branches = $user->branch;
            $row = new Admin_branch();
            $branch_id = 0;
            $orders = Order::where('branch_id', $branch_id)->get();
            $stocks = DB::table('stocks')->get();

            return view($this->viewName . 'index', compact('branches', 'row', 'orders', 'stocks'));
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
        $orderObj =Order::where('ORDER_ID', $id)->first();

        $orderItems = Order_items::where('ORDER_ID', $id)->get();
        $stocks = DB::table('stocks')->get();
        $persons = DB::table('persons')->where('PERSON_TYPE_ID', 1)->get();
        $currencies = DB::table('currency')->get();

        $sub = DB::table('stocks_items_categories')->where('STOCK_ID', $orderObj->STOCK_ID)->pluck('ITEM_CATEGORY_ID');
        $branch = Admin_branch::where('id', $orderObj->branch_id)->first();
        $items = DB::table('items')->whereIN('ITEM_CATEGORY_ID', $sub)->get();
        $personObj = DB::table('persons')->where('PERSON_ID', $orderObj->PERSON_ID)->first();
        $saleCode=NULL;
        $MarktCode=NULL;
        if ($personObj) {
            $saleCode = DB::table('representatives')->where('REP_ID', $personObj->SALES_REP_ID)->first();

            $MarktCode = DB::table('representatives')->where('REP_ID', $personObj->MARKETING_REP_ID)->first();
        }
        return view($this->viewName . 'edit', compact('stocks','branch', 'persons', 'orderObj','saleCode','MarktCode', 'currencies', 'items', 'orderItems'));
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
        $price = 1;
        $qunty = 1;
        $disc = 0;
        for ($i = 1; $i <= $count; $i++) {

            $price = $request->get('itemprice' . $i) * $request->get('qty' . $i);
            $qunty = $request->get('disval' . $i);
            $disc = $price - $qunty;
            $detail = [
                'ITEM_ID' => $request->get('select' . $i),
                'BATCH_NO' => $request->get('electBatch' . $i),
                'ITEM_QTY' => $request->get('qty' . $i),
                'ITEM_PRICE' => $request->get('itemprice' . $i),
                'TOTAL_LINE_COST' => $price,
                'NOTES' => $request->get('detNote' . $i),
                'ITEM_DISC_PERC' =>  $request->get('per' . $i),
                'ITEM_DISC_VALUE' => $request->get('disval' . $i),
                'FINAL_LINE_COST' => $disc,

            ];
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
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
                'ORDER_ITEM_ID' => $request->get('item_order_id' . $i),
                'ITEM_ID' => $request->get('selectup' . $i),
                'BATCH_NO' => $request->get('electBatchup' . $i),
                'ITEM_QTY' => $request->get('qtyup' . $i),
                'ITEM_PRICE' => $request->get('itempriceup' . $i),
                'TOTAL_LINE_COST' => $priceup,
                'NOTES' => $request->get('detNoteup' . $i),
                'ITEM_DISC_PERC' =>  $request->get('perup' . $i),
                'ITEM_DISC_VALUE' => $request->get('disvalup' . $i),
                'FINAL_LINE_COST' => $discup,

            ];
            array_push($detailsUpdate, $detailUpdate);
        }











        // Master
        $personObj = DB::table('persons')->where('PERSON_ID', $request->get('person_name'))->first();
        if ($personObj) {
            $saleCode = DB::table('representatives')->where('REP_ID', $personObj->SALES_REP_ID)->first();

            $MarktCode = DB::table('representatives')->where('REP_ID', $personObj->MARKETING_REP_ID)->first();
        }

        $data = [
            'PURCH_ORDER_NO' => 4,
            'PERSON_ID' => $request->get('person_id'),
            'STOCK_ID' => $request->get('stock_id'),
            'PERSON_NAME' => $request->get('person_name'),
            'ORDER_TYPE_ID' => 1,
            'ORDER_DESCRIPTION' => $request->get('decOrder'),
            'SALES_REP_ID' => $saleCode->REP_ID ?? NULL,
            'MARKETING_REP_ID' => $MarktCode->REP_ID ?? NULL,
            'ORDER_DATE' => Carbon::parse($request->get('order_date')),
            'RECEIVED_DATE_SUGGESTED' => Carbon::parse($request->get('order_delev')),
            'ORDER_VALUE' => $request->get('total_items_price'),
            'TOTAL_DISC_VALUE' => $request->get('total_items_discount'),
            'TOTAL_FINAL_COST' => $request->get('total_items_final'),
            'branch_id' => 1,
            'Notes' =>  $request->get('notes'),
        ];
        // DB::beginTransaction();
        // try {
        // $order = DB::table('orders')->where('ORDER_ID',$id)->first();

        DB::table('orders')->where('ORDER_ID', $id)->update($data);
        // $order = DB::table('orders')->insertGetId($data);
        foreach ($details as $Item) {

            $Item['ORDER_ID'] = $id;
            $order_Item = DB::table('order_items')->insert($Item);
        }


        foreach ($detailsUpdate as $updates) {


            DB::table('order_items')->where('ORDER_ITEM_ID', $updates['ORDER_ITEM_ID'])->update($updates);
        }
        $request->session()->flash('flash_success', "تم اضافة أمر بيع :");
        // DB::commit();
        //static user this will be logined
        $user = User::where('id', 1)->first();
        $branches = $user->branch;
        $row = new Admin_branch();
        $branch_id = 0;
        $orders = Order::where('branch_id', $branch_id)->get();
        $stocks = DB::table('stocks')->get();

        return view($this->viewName . 'index', compact('branches', 'row', 'orders', 'stocks'));
        // } catch (\Throwable $th) {
        //     // throw $th;
        //     DB::rollBack();
        //     $request->session()->flash('flash_danger', "حدث خطأ ما يرجي اعادة المحاولة");
        //     //static user this will be logined
        //     $user = User::where('id', 1)->first();
        //     $branches = $user->branch;
        //     $row = new Admin_branch();
        //     $branch_id = 0;
        //     $orders = Order::where('branch_id', $branch_id)->get();
        //     $stocks = DB::table('stocks')->get();

        //     return view($this->viewName . 'index', compact('branches', 'row', 'orders', 'stocks'));
        // }
    }
    public function DeleteOrderItem(Request $req)
    {


        if ($req->ajax()) {

            $obo = DB::table('order_items')->where('ORDER_ITEM_ID', $req->id)->first();

            $orderss = DB::table('orders')->where('ORDER_ID', $obo->ORDER_ID)->first();
            $ss = [
                'ORDER_VALUE' => $orderss->ORDER_VALUE - $obo->TOTAL_LINE_COST,
                'TOTAL_DISC_VALUE' => $orderss->TOTAL_DISC_VALUE - $obo->ITEM_DISC_VALUE,
                'TOTAL_FINAL_COST' => $orderss->TOTAL_FINAL_COST - $obo->FINAL_LINE_COST,
            ];

            DB::table('orders')->where('ORDER_ID', $obo->ORDER_ID)->update($ss);

            DB::table('order_items')->where('ORDER_ITEM_ID', $req->id)->delete();
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
        //
    }
}
