<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Items_discount;
use App\Models\Items_price;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Person;
use App\Models\Representative;
use App\Models\Stock;
use App\Models\stocks_item_category;
use App\Models\Stocks_items_total;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Log;
use Carbon\Carbon;
use DB;
use Illuminate\Database\QueryException;

class SaleOrderController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Order $object)
    {


        $this->object = $object;

        $this->viewName = 'sales-order.';
        $this->routeName = 'sales-order.';

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
        $orders = Order::where('branch_id', $branch_id)->get();
        $stocks = Stock::get();

        return view($this->viewName . 'index', compact('branches', 'row', 'orders', 'stocks'));
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
        $orders = Order::where('branch_id', $branch_id)->get();
        $stocks = Stock::where('branch_id', $branch_id)->get();
        return view($this->viewName . 'preIndex', compact('row', 'orders', 'stocks'))->render();
    }
    /**
     * Show the form for creating with request a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function creation(Request $request)
    {

        $id = $request->input('branch');

        $branch = Branch::where('id', $id)->first();
        $stocks = Stock::where('branch_id', $id)->get();
        $persons = Person::where('person_type_id', 101)->get();
        $currencies = Currency::get();

        return view($this->viewName . 'new', compact('stocks', 'persons', 'branch', 'currencies'));
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
                'final_line_cost' => ($request->get('qty' . $i) * $request->get('itemprice' . $i)) - $request->get('disval' . $i),

            ];
            if ($batch) {
                $detail['batch_no'] = $batch->batch_no;
                $detail['expired_date'] = $batch->expired_date;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
        }
        // Master
        $personObj = Person::where('id', $request->get('person_id'))->first();
        if ($personObj) {
            $saleCode = Representative::where('id', $personObj->sales_rep_id)->first();

            $MarktCode = Representative::where('id', $personObj->marketing_rep_id)->first();
        }

        $data = [
            'purch_order_no' => 4,
            'person_id' => $request->get('person_id'),
            'stock_id' => $request->get('stock_id'),
            'person_name' => $request->get('person_name'),
            'order_type_id' => 1,
            'order_description' => $request->get('order_description'),

            'currency_id' => $request->get('currency_id'),
            'sales_rep_id' => $saleCode->id ?? 0,
            'marketing_rep_id' => $MarktCode->id ?? 0,
            'order_date' => Carbon::parse($request->get('order_date')),
            'received_date_suggested' => Carbon::parse($request->get('received_date_suggested')),
            'order_value' => $request->get('order_value'),
            'total_disc_value' => $request->get('total_disc_value'),
            'total_final_cost' => $request->get('total_final_cost'),
            'branch_id' =>  $request->get('branch'),
        ];
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $order = Order::create($data);
            foreach ($details as $Item) {

                $Item['order_id'] = $order->id;
                $Invoice_Item = Order_item::create($Item);
            }
            $request->session()->flash('flash_success', "تم اضافة أمر بيع :");
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
        $orderObj = Order::where('id', $id)->first();

        $orderItems = Order_item::where('order_id', $id)->get();
        $stocks =  $stocks = Stock::where('branch_id', $orderObj->branch_id)->get();
        $persons = Person::where('person_type_id', 101)->get();
        $currencies = Currency::get();

        $xx = Stocks_items_total::where('stock_id', $orderObj->stock_id)->with('item')->get();
        $collection = new Collection($xx);
        $itemsss = $collection->unique('item_id');
        $items = [];
        foreach ($itemsss as $detail) {
            array_push($items, $detail->item);
        }
        $branch = Branch::where('id', $orderObj->branch_id)->first();
        $personObj = Person::where('id', $orderObj->person_id)->first();
        $saleCode = NULL;
        $MarktCode = NULL;
        if ($personObj) {
            $saleCode = Representative::where('id', $personObj->sales_rep_id)->first();

            $MarktCode = Representative::where('id', $personObj->marketing_rep_id)->first();
        }
        return view($this->viewName . 'view', compact('stocks', 'branch', 'persons', 'orderObj', 'saleCode', 'MarktCode', 'currencies', 'items', 'orderItems'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orderObj = Order::where('id', $id)->first();

        $orderItems = Order_item::where('order_id', $id)->get();
        $stocks =  $stocks = Stock::where('branch_id', $orderObj->branch_id)->get();
        $persons = Person::where('person_type_id', 100)->get();
        $currencies = Currency::get();

        $xx = Stocks_items_total::where('stock_id', $orderObj->stock_id)->with('item')->get();
        $collection = new Collection($xx);
        $itemsss = $collection->unique('item_id');
        $items = [];
        foreach ($itemsss as $detail) {
            array_push($items, $detail->item);
        }
        $branch = Branch::where('id', $orderObj->branch_id)->first();
        $personObj = Person::where('id', $orderObj->person_id)->first();
        $saleCode = NULL;
        $MarktCode = NULL;
        if ($personObj) {
            $saleCode = Representative::where('id', $personObj->sales_rep_id)->first();

            $MarktCode = Representative::where('id', $personObj->marketing_rep_id)->first();
        }
        return view($this->viewName . 'edit', compact('stocks', 'branch', 'persons', 'orderObj', 'saleCode', 'MarktCode', 'currencies', 'items', 'orderItems'));
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
            $batch = $row = Stocks_items_total::where('id', $request->get('selectBatch' . $i))->first();

            $detail = [
                'item_id' => $request->get('select' . $i),
                'item_qty' => $request->get('qty' . $i),
                'item_price' => $request->get('itemprice' . $i),
                'total_line_cost' => $request->get('qty' . $i) * $request->get('itemprice' . $i),
                'notes' => $request->get('detNote' . $i),
                'item_disc_perc' =>  $request->get('per' . $i),
                'item_disc_value' => $request->get('disval' . $i),
                'final_line_cost' => ($request->get('qty' . $i) * $request->get('itemprice' . $i)) - $request->get('disval' . $i),

            ];
            if ($batch) {
                $detail['batch_no'] = $batch->batch_no;
                $detail['expired_date'] = $batch->expired_date;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
        }

        //update Details
        $counterrrr = $request->get('qqq');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {


            $detailUpdate = [
                'id' => $request->get('item_order_id' . $i),
                'item_qty' => $request->get('upqty' . $i),
                'item_price' => $request->get('upitemprice' . $i),
                'total_line_cost' => $request->get('upqty' . $i) * $request->get('upitemprice' . $i),
                'notes' => $request->get('updetNote' . $i),
                'item_disc_perc' =>  $request->get('upper' . $i),
                'item_disc_value' => $request->get('updisval' . $i),
                'final_line_cost' => ($request->get('upqty' . $i) * $request->get('upitemprice' . $i)) - $request->get('updisval' . $i),

            ];
            array_push($detailsUpdate, $detailUpdate);
        }
        // Master
        $personObj = Person::where('id', $request->get('person_id'))->first();
        if ($personObj) {
            $saleCode = Representative::where('id', $personObj->sales_rep_id)->first();

            $MarktCode = Representative::where('id', $personObj->marketing_rep_id)->first();
        }

        $data = [
            'purch_order_no' => 4,
            'person_id' => $request->get('person_id'),
            'stock_id' => $request->get('stock_id'),
            'person_name' => $request->get('person_name'),
            'order_type_id' => 1,
            'order_description' => $request->get('order_description'),

            'currency_id' => $request->get('currency_id'),
            'sales_rep_id' => $saleCode->id ?? 0,
            'marketing_rep_id' => $MarktCode->id ?? 0,
            'order_date' => Carbon::parse($request->get('order_date')),
            'received_date_suggested' => Carbon::parse($request->get('received_date_suggested')),
            'order_value' => $request->get('order_value'),
            'total_disc_value' => $request->get('total_disc_value'),
            'total_final_cost' => $request->get('total_final_cost'),
            'branch_id' =>  $request->get('branch'),
        ];
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Order::where('id', $id)->update($data);
            foreach ($details as $Item) {

                $Item['order_id'] = $id;
                $Invoice_Item = Order_item::create($Item);
            }
            foreach ($detailsUpdate as $updates) {


                Order_item::where('id', $updates['id'])->update($updates);
            }
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
        $row = Order::where('id', $id)->first();
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

            //get subcategories
            // $sub = stocks_item_category::where('stock_id', $stock_id)->pluck('item_category_id');

            // $items = Item::whereIN('item_category_id', $sub)->get();
            $xx = Stocks_items_total::where('stock_id', $stock_id)->with('item')->get();


            $collection = new Collection($xx);

            // Get all unique items.
            $itemsss = $collection->unique('item_id');
            $items = [];
            foreach ($itemsss as $detail) {
                array_push($items, $detail->item);
            }
            \Log::info($items);
            $ajaxComponent = view('sales-order.ajaxAdd', [
                'rowCount' => $rowCount,
                'items' => $items,

            ]);


            return $ajaxComponent->render();
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
           
            $personObj = Person::where('id', $person)->first();
            $date = date_create($row->expired_date);
            $outs = 0;
            $disc = 0;

            $ItemPrice = Item::where('id', $select_value)->first();

            $Clientprice = Items_price::where('item_id', $row->item_id)->where('client_id', $person)->first();

            $Categoryprice = Items_price::where('item_id', $row->item_id)->where('client_category_id', $personObj->person_category_id)->first();
            if ($Clientprice) {

                $outs = $Clientprice->item_price;
                $outs = 1;  
            } elseif ($Categoryprice) {

                $outs = $Categoryprice->item_price;
                $outs = 2;
            } else {

                $outs = $ItemPrice->retail_price;
                $outs = 3;
            }
            //discount

            $ClientDis = Items_discount::where('item_id', $row->item_id)->where('client_id', $person)->first();

            $CategoryDis = Items_discount::where('item_id', $row->item_id)->where('client_category_id', $personObj->person_category_id)->first();
            if ($ClientDis) {

                $disc = $ClientDis->item_discount_price;
            } elseif ($CategoryDis) {

                $disc = $CategoryDis->item_discount_price;
            } else {

                $disc = 0;
            }


            echo json_encode(array($row->batch_no,  date_format($date, "d-m-Y"), $row->item_total_qty, $outs ,$disc));
        }
    }

    /***
     * 
     */
    public function editSelectValPerson(Request $req)
    {
        if ($req->ajax()) {

            $select_value = $req->select_value;


            $personObj = Person::where('id', $select_value)->first();

            $saleCode = Representative::where('id', $personObj->sales_rep_id)->first();

            $MarktCode = Representative::where('id', $personObj->marketing_rep_id)->first();






            echo json_encode(array($saleCode->code, $saleCode->ar_name, $MarktCode->code, $MarktCode->ar_name, $personObj->name));
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

            Log::info($select_stock);

            $output = '<option value="" selected="" disabled="">إختر الباتش</option>';
            foreach ($data as $row) {
                $date = date_create($row->expired_date);
                $output .= '<option value="' . $row->id . '">' . $row->batch_no . '-' . date_format($date, "d-m-Y") . '-' . $row->item_total_qty . '</option>';
            }



            echo json_encode(array($items->ar_name, $items->uom->ar_name ?? '', $output));
        }
    }

    /***
     * Del
     */
    public function DeleteOrderItem(Request $req)
    {


        if ($req->ajax()) {

            $obo = Order_item::where('id', $req->id)->first();

            $orderss = Order::where('id', $obo->order_id)->first();
            $ss = [
                'order_value' => $orderss->order_value - $obo->total_line_cost,
                'total_disc_value' => $orderss->total_disc_value - $obo->item_disc_value,
                'total_final_cost' => $orderss->total_final_cost - $obo->final_line_cost,
            ];

            Order::where('id', $obo->order_id)->update($ss);

            Order_item::where('id', $req->id)->delete();
        }
    }
}
