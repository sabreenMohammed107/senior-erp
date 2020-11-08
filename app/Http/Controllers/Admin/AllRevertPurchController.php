<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Stock_transaction_item;
use App\Models\Stocks_transaction;
use App\User;
use Illuminate\Http\Request;

class AllRevertPurchController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Stocks_transaction $object)
    {


        $this->object = $object;
        $this->viewName = 'all-revert-purch.';
        $this->routeName = 'all-revert-purch.';

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
         $reverts =Stocks_transaction::join('invoices', function ($join)use ($branch_id) {
            $join->on('invoices.id', '=', 'stocks_transactions.invoice_id')
                 ->where('invoices.branch_id', '=',$branch_id);
        })->where('transaction_type_id',102)
        ->select('*','stocks_transactions.id')->get();

         return view($this->viewName . 'index', compact('branches', 'row', 'reverts', ));
    }

    /*
    *
    */
    /**
     * Display a listing of the resource after getting Branch.
     *
     * @return \Illuminate\Http\Response
     */
    public function branchFetch(Request $request)
    {
        $branch_id = $request->input('branch_id');
        $row = Branch::where('id', $branch_id)->first();
        $reverts =Stocks_transaction::join('invoices', function ($join)use ($branch_id) {
            $join->on('invoices.id', '=', 'stocks_transactions.invoice_id')
                 ->where('invoices.branch_id', '=',$branch_id);
        })->where('transaction_type_id',102)
        ->select('*','stocks_transactions.id')->get();
        return view($this->viewName . 'preIndex', compact('row', 'reverts', ))->render();
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
        $transObj = Stocks_transaction::where('id', $id)->first();
        $transItems = Stock_transaction_item::where('transaction_id', $id)->get();
           return view($this->viewName . 'view', compact('transObj', 'transItems'));
 
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
}
