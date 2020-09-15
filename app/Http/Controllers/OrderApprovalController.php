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
use Illuminate\Database\QueryException;

class OrderApprovalController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Order $object)
    {


        $this->object = $object;
        $this->viewName = 'approve-order.';
        $this->routeName = 'approve-order.';

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
     * approveOrder
     */
    public function approveOrder(Request $request){
        $id=$request->input('approveOrder');
        $orderObj =Order::where('ORDER_ID', $id)->first();
        
        $data = [
            'ORDER_DECISION_STATUS_ID' => 2,
           
        ];
      
        try {
            DB::table('orders')->where('ORDER_ID', $id)->update($data);

        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'لا يمكن الموافقه');
        }
        return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الموافقة بنجاح !');

    }
     /**
     * rejectOrder
     */
    public function rejectOrder(Request $request){
        $id=$request->input('rejectOrder');
        $orderObj =Order::where('ORDER_ID', $id)->first();
        
        $data = [
            'ORDER_DECISION_STATUS_ID' => 3,
           
        ];
      
        try {
            DB::table('orders')->where('ORDER_ID', $id)->update($data);

        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'لا يمكن الموافقه');
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
