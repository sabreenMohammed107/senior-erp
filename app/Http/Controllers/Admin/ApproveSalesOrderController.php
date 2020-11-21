<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Stock;
use App\Models\Person;
use App\Models\Currency;
use App\Models\Representative;
use App\Models\Stocks_items_total;
use Illuminate\Support\Collection;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ApproveSalesOrderController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Order $object)
    {


        $this->object = $object;
        $this->viewName = 'approve-sales-order.';
        $this->routeName = 'approve-sales-order.';

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
        $orders = Order::where('branch_id', $branch_id)->where('order_type_id',1)->where('confirmed',1)->get();
        $stocks = Stock::where('branch_id', $branch_id)->get();
        return view($this->viewName . 'index', compact('branches', 'row', 'orders', 'stocks'));
    }
    public function branchFetch(Request $request)
    {
        $branch_id = $request->input('branch_id');
        $row = Branch::where('id', $branch_id)->first();
        $orders = Order::where('branch_id', $branch_id)->where('order_type_id',1)->where('confirmed',1)->get();
        $stocks = Stock::where('branch_id', $branch_id)->get();
        return view($this->viewName . 'preIndex', compact('row', 'orders', 'stocks'))->render();
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
        $orderObj =Order::where('id', $id)->first();

        $orderItems = Order_item::where('order_id', $id)->get();
        $stocks = Stock::where('branch_id', $orderObj->branch_id)->get();
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
          \Log::info(['ordersitem',$orderItems]);
        return view($this->viewName . 'edit', compact('stocks','branch', 'persons', 'orderObj','saleCode','MarktCode', 'currencies', 'items', 'orderItems'));
    }
 /**
     * approveOrder
     */
    public function approveOrder(Request $request){
        $id=$request->input('approveOrder');
        $orderObj =Order::where('id', $id)->first();
        
        $data = [
            'order_decision_status_id' => 101,
           
        ];
      
        try {
            Order::where('id', $id)->update($data);

        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', $q->getMessage());
        }
        return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الموافقة بنجاح !');

    }
     /**
     * rejectOrder
     */
    public function rejectOrder(Request $request){
        $id=$request->input('rejectOrder');
        $orderObj =Order::where('id', $id)->first();
        
        $data = [
            'order_decision_status_id' => 102,
           
        ];
      
        try {
            Order::where('id', $id)->update($data);

        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', $q->getMessage());
        }
        return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم  عدم الموافقة  !');
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
}
