<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Financial_entry;
use App\Models\Financial_subsystem;
use App\Models\Item;
use App\Models\Person;
use App\Models\Stock;
use App\Models\Stock_taking;
use App\Models\Stock_taking_item;
use App\Models\Stock_transaction_item;
use App\Models\Stocks_items_total;
use App\Models\Stocks_transaction;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use DB;
use Illuminate\Database\QueryException;

class StockTakingController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Stock_taking $object)
    {

        $this->object = $object;
        $this->viewName = 'stock-taking.';
        $this->routeName = 'stock-taking.';

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
        $stocks = $user->stock;
        $row = new Stock();
        $rows = [];
        return view($this->viewName . 'index', compact('row', 'rows', 'stocks'));
    }
    /**
     * Display a table  of the branch.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockFetch(Request $request)
    {
        $stock_id = $request->input('stock_id');
        $row = Stock::where('id', $stock_id)->first();
        $rows = Stock_taking::get();
        return view($this->viewName . 'preIndex', compact('row', 'rows'))->render();
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
     * Show the form for creating a new resource with request.
     *
     * @return \Illuminate\Http\Response
     */
    public function creation(Request $request)
    {

        $id = $request->input('stock');

        $stock = Stock::where('id', $id)->first();
        $persons = Person::where('person_type_id', 100)->get();

        return view($this->viewName . 'add', compact('stock', 'persons'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'taking_no' => $request->get('taking_no'),
            'taking_date' => Carbon::parse($request->get('taking_date')),
            'person_id' => $request->get('person_id'),
            'stock_id' => $request->get('stock_id'),
            'stock_taking_status_id' => 101,

        ];

        $stock = $request->get('stock_id');
        $person = $request->get('person_id');
        $xx = Stocks_items_total::where('stock_id', $stock)->with('item')->get();

        $collection = new Collection($xx);
        // Get all unique items.
        $itemsss = $collection->unique('item_id');
        $items = [];
        foreach ($itemsss as $detail) {
            \Log::info([$detail->item->person_id]);

            if ($detail->item->person_id == $person) {
                array_push($items, $detail);
            }
        }

        //save Start Firstly
        DB::beginTransaction();
        try {

            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $taking = Stock_taking::create($data);
            foreach ($items as $Item) {
                $takItem = [
                    'stock_taking_id' => $taking->id,
                    'item_id' => $Item['item_id'],
                    'batch_no' => $Item['batch_no'],
                    'expired_date' => $Item['expired_date'],
                    'system_qty' => $Item['item_total_qty'],
                    'physical_qty' => $Item['item_total_qty'],

                ];

                Stock_taking_item::create($takItem);
            }

            DB::commit();
            // Enable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->route($this->routeName . 'edit', $taking->id)->with('flash_success', $this->message);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Stock_taking::where('id', $id)->first();
        $takingItem = Stock_taking_item::where('stock_taking_id', $id)->get();

        $stock = Stock::where('id', $row->stock_id)->first();
        $persons = Person::where('person_type_id', 100)->get();

        return view($this->viewName . 'startEdit', compact('row', 'takingItem', 'stock', 'persons'));
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
        $data = [
            'taking_no' => $request->get('taking_no'),
            'taking_date' => Carbon::parse($request->get('taking_date')),

            'stock_taking_status_id' => 101,

        ];


        $count = $request->counter;

        $details = [];
        $additaves = [];
        $subtractives = [];
        $updateTotals = [];
        $financeArrayAdditive = [];
        $financeArraySubstractive = [];
        for ($i = 1; $i <= $count; $i++) {
            $item = Item::where('id', $request->get('selectItem' . $i))->first();

            $detail = [
                'id' => $request->get('take_item_id' . $i),
                'physical_qty' => $request->get('physical_qty' . $i),
                'additive_qty' => $request->get('additive_qty' . $i),
                'subtractive_qty' => $request->get('subtractive_qty' . $i),


            ];
            if (($request->get('physical_qty' . $i) - $request->get('system_qty' . $i)) > 0) {
                $detail['additive_qty'] = ($request->get('physical_qty' . $i) - $request->get('system_qty' . $i));
            } else {
                $detail['subtractive_qty'] = ($request->get('system_qty' . $i) - $request->get('physical_qty' . $i));
            }
            if ($item) {
                \Log::info($item->average_price);
                $detail['additive_cost'] = $detail['additive_qty'] * $item->average_price;
                $detail['subtractive_cost'] = $detail['subtractive_qty'] * $item->average_price;
            }

            array_push($details, $detail);

            if ($detail['additive_qty'] > 0) {

                $TransItemsAdditive = [
                    'item_id' => $item->id,
                    'batch_no' => $request->get('batchno' . $i),
                    'expired_date' => $request->get('expired' . $i),
                    'item_qty' =>  $detail['additive_qty'],
                    'item_price' =>  $item->average_price,
                    'total_line_cost' => $detail['additive_cost'],


                ];
                array_push($additaves, $TransItemsAdditive);
                $totalQtyUp = [
                    'id' => $request->get('take_item_id' . $i),
                    'item_total_qty' => $request->get('physical_qty' . $i),
                ];
                array_push($updateTotals, $totalQtyUp);

                //finance
                if ($item) {
                    $financeAdd = [
                        'totalPrice' => $detail['additive_qty'] * $item->average_price,
                    ];
                    array_push($financeArrayAdditive, $financeAdd);
                }
            }


            if ($detail['subtractive_qty'] > 0) {
                $TransItemssub = [
                    'item_id' => $item->id,
                    'batch_no' => $request->get('batchno' . $i),
                    'expired_date' => $request->get('expired' . $i),
                    'item_qty' => $detail['subtractive_qty'],
                    'item_price' => $item->average_price,
                    'total_line_cost' => $detail['subtractive_cost'],


                ];
                array_push($subtractives, $TransItemssub);

                //finance
                if ($item) {
                    $financeSub = [
                        'totalPrice' => $detail['subtractive_qty'] * $item->average_price,
                    ];
                    array_push($financeArraySubstractive, $financeSub);
                }
            }
            $item = new Item();
        }

        //save Start Firstly
        DB::beginTransaction();
        try {

            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            if ($request->get('action') == 'save') {
                $data['stock_taking_status_id'] = 101;
                Stock_taking::where('id', $id)->update($data);
                foreach ($details as $updates) {
                    $updateItem = [

                        'physical_qty' => $updates['physical_qty'],

                    ];
                    Stock_taking_item::where('id', $updates['id'])->update($updateItem);
                }
            } elseif ($request->get('action') == 'confirm') {
                $data['stock_taking_status_id'] = 103;
                Stock_taking::where('id', $id)->update($data);
                foreach ($details as $updates) {

                    Stock_taking_item::where('id', $updates['id'])->update($updates);
                }
            } elseif ($request->get('action') == 'settlement') {
                $data['stock_taking_status_id'] = 105;
                Stock_taking::where('id', $id)->update($data);
                foreach ($details as $updates) {
                    $updates['settlement_done'] = 1;
                    Stock_taking_item::where('id', $updates['id'])->update($updates);
                }

                //additive loop
                foreach ($details as $updates) {
                    // adding value to physical 107
                    \Log::info(['updates', $updates]);
                    if ($updates['additive_qty'] > 0) {
                        //saving in stock_transaction & stock_transaction_items

                        $maxCode = Stocks_transaction::where('primary_stock_id',  $request->get('stock_id'))->where('transaction_type_id', 107)->latest('code')->first();

                        $maxCode = ($maxCode != null) ? intval($maxCode['code']) : 0;
                        $maxCode++;
                        $Transdata = [
                            'code' => $maxCode,
                            'transaction_type_id' => 107,
                            'primary_stock_id' => Stock_taking::where('id', $id)->first()->stock_id ?? '',
                            'person_id' => Stock_taking::where('id', $id)->first()->person_id ?? '',
                            'person_name' => Person::where('id', Stock_taking::where('id', $id)->first()->person_id)->first()->name ?? '',
                            'person_type_id' => 100,
                            'transaction_date' => Stock_taking::where('id', $id)->first()->taking_date ?? '',
                            'notes' => Stock_taking::where('id', $id)->first()->notes ?? '',
                            'confirmed' => 1,

                        ];
                        $trans = Stocks_transaction::create($Transdata);
                        //Make Finance Entry

                        $stockBranch = Stock::where('id', $trans->primary_stock_id)->first();
                        $maxF = Financial_entry::where('trans_type_id', 106)->where('branch_id', $stockBranch->branch_id)->latest('entry_serial')->first();

                        $maxF = ($maxF != null) ? intval($maxF['entry_serial']) : 0;
                        $maxF++;
                        //sum of prices
                        $PricesSum = 0.0;

                        foreach ($financeArrayAdditive as $finance) {

                            $PricesSum += $finance['totalPrice'];
                        }
                        //Finance Entry add 2 records

                        $firstFinance = new Financial_entry();
                        $firstFinance->trans_type_id = 106;
                        $firstFinance->entry_serial = $maxF;
                        $firstFinance->entry_date = $trans->transaction_date;
                        $firstFinance->stock_id = $trans->primary_stock_id;
                        $firstFinance->branch_id = $stockBranch->branch_id;
                        $firstFinance->credit = $PricesSum;
                        $firstFinance->debit = 0;
                        $firstFinance->gl_item_id = $stockBranch->gl_item_id;

                        $firstFinance->save();
                        //second row
                        $secondFinance = new Financial_entry();
                        $secondFinance->trans_type_id = 106;
                        $secondFinance->entry_serial = $maxF;
                        $secondFinance->entry_date = $trans->transaction_date;
                        $secondFinance->stock_id =  $trans->primary_stock_id;
                        $secondFinance->branch_id = $stockBranch->branch_id;
                        $secondFinance->debit = $PricesSum;
                        $secondFinance->credit = 0;
                        $secondFinance->gl_item_id = Financial_subsystem::where('id', 105)->first()->gl_item_id ?? 0;

                        $secondFinance->save();

                        //End Finance
                        foreach ($additaves as $adds) {

                            $adds['transaction_id'] = $trans->id;
                            Stock_transaction_item::create($adds);
                            //update Total
                            $xxitems_total = Stocks_items_total::where('stock_id', $trans->primary_stock_id)->where('item_id', $adds['item_id'])->where('batch_no', $adds['batch_no'])->where('expired_date', $adds['expired_date'])->first();
                            if ($xxitems_total) {
                                $xxitems_total->item_total_qty = $xxitems_total->item_total_qty + $adds['item_qty'];
                                $xxitems_total->update();
                            }
                        }
                        break;
                    }
                }
                //subtractive loop
                foreach ($details as $updates) {

                    // sub value to physical 108
                    if ($updates['subtractive_qty'] > 0) {
                        $maxCode = Stocks_transaction::where('primary_stock_id',  $request->get('stock_id'))->where('transaction_type_id', 108)->latest('code')->first();

                        $maxCode = ($maxCode != null) ? intval($maxCode['code']) : 0;
                        $maxCode++;
                        $Transdata = [
                            'code' => $maxCode,
                            'transaction_type_id' => 108,
                            'primary_stock_id' => Stock_taking::where('id', $id)->first()->stock_id ?? '',
                            'person_id' => Stock_taking::where('id', $id)->first()->person_id ?? '',
                            'person_name' => Person::where('id', Stock_taking::where('id', $id)->first()->person_id)->first()->name ?? '',
                            'person_type_id' => 100,
                            'transaction_date' => Stock_taking::where('id', $id)->first()->taking_date ?? '',
                            'notes' => Stock_taking::where('id', $id)->first()->notes ?? '',
                            'confirmed' => 1,

                        ];
                        $trans = Stocks_transaction::create($Transdata);

                        //Make Finance Entry

                        $stockBranch = Stock::where('id', $trans->primary_stock_id)->first();
                        $maxF = Financial_entry::where('trans_type_id', 107)->where('branch_id', $stockBranch->branch_id)->latest('entry_serial')->first();

                        $maxF = ($maxF != null) ? intval($maxF['entry_serial']) : 0;
                        $maxF++;
                        //sum of prices
                        $PricesSum = 0.0;

                        foreach ($financeArraySubstractive as $finance) {

                            $PricesSum += $finance['totalPrice'];
                        }
                        //Finance Entry add 2 records

                        $firstFinance = new Financial_entry();
                        $firstFinance->trans_type_id = 107;
                        $firstFinance->entry_serial = $maxF;
                        $firstFinance->entry_date = $trans->transaction_date;
                        $firstFinance->stock_id = $trans->primary_stock_id;
                        $firstFinance->branch_id = $stockBranch->branch_id;
                        $firstFinance->credit = $PricesSum;
                        $firstFinance->debit = 0;
                        $firstFinance->gl_item_id = $stockBranch->gl_item_id;

                        $firstFinance->save();
                        //second row
                        $secondFinance = new Financial_entry();
                        $secondFinance->trans_type_id = 107;
                        $secondFinance->entry_serial = $maxF;
                        $secondFinance->entry_date = $trans->transaction_date;
                        $secondFinance->stock_id =  $trans->primary_stock_id;
                        $secondFinance->branch_id = $stockBranch->branch_id;
                        $secondFinance->debit = $PricesSum;
                        $secondFinance->credit = 0;
                        $secondFinance->gl_item_id = Financial_subsystem::where('id', 104)->first()->gl_item_id ?? 0;

                        $secondFinance->save();

                        //End Finance
                        foreach ($subtractives as $subs) {

                            $subs['transaction_id'] = $trans->id;
                            Stock_transaction_item::create($subs);
                            //update Total
                            $xxitems_total = Stocks_items_total::where('stock_id', $trans->primary_stock_id)->where('item_id', $subs['item_id'])->where('batch_no', $subs['batch_no'])->where('expired_date', $subs['expired_date'])->first();
                            if ($xxitems_total) {
                                $xxitems_total->item_total_qty = $xxitems_total->item_total_qty - $subs['item_qty'];
                                $xxitems_total->update();
                            }
                        }
                        break;
                    }
                }
            }

            DB::commit();
            // Enable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->route($this->routeName . 'edit', $id)->with('flash_success', $this->message);
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
        //
    }


    public function FetchData(Request $req)
    {

        if ($req->ajax()) {
            $rowCount = $req->rowcount;
            $stock = $req->stock_id;
            $person = $req->person;
            $xx = Stocks_items_total::where('stock_id', $stock)->with('item')->get();
            //     $xx = Stocks_items_total::where('stock_id', $stock)->where(['item' => function($q) use ($person) {
            //         $q->where('person_id','=', $person);
            //    }])->get();
            $collection = new Collection($xx);
            // Get all unique items.
            $itemsss = $collection->unique('item_id');
            $items = [];
            foreach ($itemsss as $detail) {
                \Log::info([$detail->item->person_id]);

                if ($detail->item->person_id == $person) {
                    array_push($items, $detail);
                }
            }

            $ajaxComponent = view('stock-taking.addAjax', [
                'rowCount' => $rowCount,
                'items' => $items,

            ]);


            return $ajaxComponent->render();
        }
    }
}
