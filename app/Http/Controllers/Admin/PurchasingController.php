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

class PurchasingController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Order $object)
    {


        $this->object = $object;

        $this->viewName = 'purch-order.';
        $this->routeName = 'purch-order.';

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
        $orders = Order::where('branch_id', $branch_id)->where('order_type_id', 2)->get();
        $stocks = Stock::where('branch_id', $branch_id)->get();
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
        $orders = Order::where('branch_id', $branch_id)->where('order_type_id', 2)->get();

        return view($this->viewName . 'preIndex', compact('row', 'orders',))->render();
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
        $persons = Person::where('person_type_id', 100)->get();
        $currencies = Currency::get();

        return view($this->viewName . 'new', compact('persons', 'branch', 'currencies'));
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

            $detail = [
                'item_id' => $request->get('select' . $i),
                'item_qty' => $request->get('qty' . $i),
                'item_price' => $request->get('itemprice' . $i),
                'total_line_cost' => $request->get('qty' . $i) * $request->get('itemprice' . $i),
                'notes' => $request->get('detNote' . $i),

            ];

            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
        }
        // Master
        $max = Order::where('branch_id', $request->input('branch'))->where('order_type_id', 2)->latest('purch_order_no')->first();

        $max = ($max != null) ? intval($max['purch_order_no']) : 0;
        $max++;
        $data = [
            'purch_order_no' => $max,
            'order_decision_status_id'=>100,
            'person_id' => $request->get('person_id'),
            'person_name' => $request->get('person_name'),
            'order_type_id' => 2,
            'order_description' => $request->get('order_description'),
            'person_type_id' => 100,
            'currency_id' => $request->get('currency_id'),
            'order_date' => Carbon::parse($request->get('order_date')),
            'received_date_suggested' => Carbon::parse($request->get('received_date_suggested')),
            'order_value' => $request->get('order_value'),
            'notes' => $request->get('notes'),
            'branch_id' =>  $request->get('branch'),
        ];
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');



            if ($request->get('action') == 'save') {
                $data['confirmed'] = 0;
            } elseif ($request->get('action') == 'confirm') {
                $data['confirmed'] = 1;
            }
            $order = Order::create($data);
            foreach ($details as $Item) {

                $Item['order_id'] = $order->id;
                $order_Item = Order_item::create($Item);
            }
            $request->session()->flash('flash_success', "تم اضافة أمر شراء :");
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
        $persons = Person::where('person_type_id', 100)->get();
        $currencies = Currency::get();
        $items = Item::where('person_id', $orderObj->person_id)->orWhereNull('person_id')->get();
        $branch = Branch::where('id', $orderObj->branch_id)->first();

        return view($this->viewName . 'view', compact('branch', 'persons', 'orderObj', 'currencies', 'items', 'orderItems'));
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
        $persons = Person::where('person_type_id', 100)->get();
        $currencies = Currency::get();
        $items = Item::where('person_id', $orderObj->person_id)->orWhereNull('person_id')->get();
        $branch = Branch::where('id', $orderObj->branch_id)->first();

        return view($this->viewName . 'edit', compact('branch', 'persons', 'orderObj', 'currencies', 'items', 'orderItems'));
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

        for ($i = 1; $i <= $count; $i++) {

            $detail = [
                'item_id' => $request->get('select' . $i),
                'item_qty' => $request->get('qty' . $i),
                'item_price' => $request->get('itemprice' . $i),
                'total_line_cost' => $request->get('qty' . $i) * $request->get('itemprice' . $i),
                'notes' => $request->get('detNote' . $i),

            ];

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

            ];
            array_push($detailsUpdate, $detailUpdate);
        }
        // Master


        $data = [

            'person_id' => $request->get('person_id'),

            'person_name' => $request->get('person_name'),

            'order_description' => $request->get('order_description'),

            'currency_id' => $request->get('currency_id'),

            'order_date' => Carbon::parse($request->get('order_date')),
            'received_date_suggested' => Carbon::parse($request->get('received_date_suggested')),
            'order_value' => $request->get('order_value'),
            'notes' => $request->get('notes'),
            'branch_id' =>  $request->get('branch'),
        ];
        DB::beginTransaction();
        try {
            if ($request->get('action') == 'save') {
                $data['confirmed'] = 0;
            } elseif ($request->get('action') == 'confirm') {
                $data['confirmed'] = 1;
            }
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
            $supplier = $req->supplier;


            $items = Item::where('person_id', $supplier)->orWhereNull('person_id')->get();

            $ajaxComponent = view('purch-order.ajaxAdd', [
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

            echo json_encode(array($items->ar_name, $items->uom->ar_name ?? '', $items->retail_price, $items->request_limit));
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

            ];

            Order::where('id', $obo->order_id)->update($ss);

            Order_item::where('id', $req->id)->delete();
        }
    }

    
}
