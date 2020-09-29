<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Items_price;
use App\Models\Order;
use App\Models\Person;
use App\Models\Representative;
use App\Models\Stock;
use App\Models\stocks_item_category;
use App\Models\Stocks_items_total;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
       $stocks =Stock::get();

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
        $stocks =Stock::where('branch_id', $branch_id)->get();
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

        $branch =Branch::where('id', $id)->first();
        $stocks =Stock::where('branch_id', $id)->get();
        $persons =Person::where('person_type_id', 100)->get();
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

            'CURRENCY_ID' => $request->get('CURRENCY_ID'),
            'SALES_REP_ID' => $saleCode->REP_ID ?? 0,
            'MARKETING_REP_ID' => $MarktCode->REP_ID ?? 0,
            'ORDER_DATE' => Carbon::parse($request->get('order_date')),
            'RECEIVED_DATE_SUGGESTED' => Carbon::parse($request->get('order_delev')),
            'ORDER_VALUE' => $request->get('total_items_price'),
            'TOTAL_DISC_VALUE' => $request->get('total_items_discount'),
            'TOTAL_FINAL_COST' => $request->get('LOCAL_NET_INVOICE'),
            'branch_id' =>  $request->get('branch'),
        ];
        // DB::beginTransaction();
        // try {

        $order = DB::table('orders')->insertGetId($data);
        foreach ($details as $Item) {

            $Item['ORDER_ID'] = $order;
            $Invoice_Item = DB::table('order_items')->insert($Item);
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
        $items=[];
      foreach($itemsss as $detail){
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
            \Log::info($select_value);
            $personObj = Person::where('id', $person)->first();
            $date = date_create($row->expired_date);
            $outs = 0;

            $ItemPrice = Item::where('id', $select_value)->first();

            $Clientprice = Items_price::where('item_id', $row->item_id)->where('client_id', $person)->first();

            $Categoryprice = Items_price::where('item_id', $row->item_id)->where('client_category_id', $personObj->person_category_id)->first();

            if ($Clientprice) {

                $outs = $Clientprice->item_price;

            } elseif ($Categoryprice) {

                $outs = $Categoryprice->item_price;
            } else {

                $outs = $ItemPrice->retail_price;
            }


            echo json_encode(array($row->batch_no,  date_format($date, "d-m-Y"), $row->item_total_qty, $outs));
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
            $out = [];

            $items = Item::where('id', $select_value)->first();



            $data = Stocks_items_total::where('item_id', $select_value)->get();



            $output = '<option value="" selected="" disabled="">إختر الباتش</option>';
            foreach ($data as $row) {
                $date = date_create($row->expired_date);
                $output .= '<option value="' . $row->id . '">' . $row->batch_no . '-' . date_format($date, "d-m-Y") . '-' . $row->item_total_qty . '</option>';
            }



            echo json_encode(array($items->ar_name, $items->uom->ar_name ?? '', $output));
        }
    }
}
