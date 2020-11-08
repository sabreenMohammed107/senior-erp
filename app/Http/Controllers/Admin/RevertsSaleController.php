<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Invoice;
use App\Models\Invoice_item;
use App\Models\Item;
use App\Models\Person;
use App\Models\Stock;
use App\Models\Stock_transaction_item;
use App\Models\Stocks_items_total;
use App\Models\Stocks_transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Log;
use Carbon\Carbon;
use DB;
use Illuminate\Database\QueryException;

class RevertsSaleController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Invoice $object)
    {


        $this->object = $object;

        $this->viewName = 'sale-invoice.';
        $this->routeName = 'sale-invoice.';
        $this->message = 'تم حفظ البيانات';
        $this->errormessage =  "لم يتم حفظها بسبب خطأ ما حاول مرة أخرى و تأكد من البيانات المدخله";
    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $masterDetails = [];
        $row = Invoice::where('id', $id)->first();
        $invoiceItems = Invoice_item::where('invoice_id', $id)->get();
        $revertMasters = Stocks_transaction::where('invoice_id', $id)->get();
        //get All Mostalm
        foreach ($revertMasters as $revertMaster) {
            $obj = new Collection();
            $obj->master = $revertMaster;

            $obj->details = Stock_transaction_item::where('transaction_id', $revertMaster->id)->get();

            array_push($masterDetails, $obj);
        }
        return view($this->viewName . 'viewRevert', compact('row', 'invoiceItems', 'masterDetails'));
    }

    public function creation(Request $request)
    {

        $id = $request->input('invoice_row');

        $invoiceRow = Invoice::where('id', $id)->first();
        $invoiceItems = Invoice_item::where('invoice_id', $id)->get();
        $branch = Branch::where('id', $invoiceRow->branch_id)->first();
        $stocks = Stock::where('branch_id', $branch->id)->get();
        $persons = Person::where('person_type_id', 101)->get();
        return view($this->viewName . 'addRevert', compact('invoiceRow', 'invoiceRow', 'stocks', 'persons'));
    }

 /***
     * 
     */
    public function AddRow(Request $req)
    {

        if ($req->ajax()) {
            $rowCount = $req->rowcount;
            $invoice_id = $req->invoice_id;

            $xx = Invoice_item::where('invoice_id', $invoice_id)->with('item')->get();


            $collection = new Collection($xx);

            // Get all unique items.
            $itemsss = $collection;
            $items = [];
            foreach ($itemsss as $detail) {
                array_push($items, $detail->item);
            }

            $ajaxComponent = view('sale-invoice.ajaxAddRevert', [
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
            $invoice_id = $req->invoice_id;
            $invoice = Invoice::where('id', $invoice_id)->first();
            $out = [];

            $items = Item::where('id', $select_value)->first();



            $data = Stocks_items_total::where('item_id', $select_value)->where('stock_id', $invoice->stock_id ?? 0)->get();


            $output = '<option value="" selected="" disabled="">إختر الباتش</option>';
            foreach ($data as $row) {
                $date = date_create($row->expired_date);
                $output .= '<option value="' . $row->id . '">' . $row->batch_no . '-' . date_format($date, "d-m-Y") . '-' . $row->item_total_qty . '</option>';
            }



            echo json_encode(array($items->ar_name, $items->uom->ar_name ?? '', $output,$items->vat_value));
        }
    }

    public function editSelectBatch(Request $req)
    {

        if ($req->ajax()) {

            $select_value = $req->select_value;
            $item = $req->item;
            $invoice_id = $req->invoice_id;
            $row = Stocks_items_total::where('id', $select_value)->first();


            $date = date_create($row->expired_date);



            $outs = 0;
            $qty = 0;
            $itemInvoice = Invoice_item::where('batch_no', $row->batch_no)->where('item_id', $item)->where('expired_date', $row->expired_date)
                ->where('invoice_id', $invoice_id)->first();


            $reserved = 0;
            $remain = 0;

            $transSelect = Stocks_transaction::where('invoice_id', $invoice_id)->pluck('id')->toArray();
            if ($transSelect) {
                $reserved = Stock_transaction_item::where('item_id', $item)
                    ->where('expired_date', $row->expired_date)->where('batch_no', $row->batch_no)->whereIn('transaction_id', $transSelect)->sum('item_qty');
            }





            if ($itemInvoice) {
                $outs = $itemInvoice->item_price;
                // $qty = $itemInvoice->item_qty;
                $remain = $itemInvoice->item_qty - $reserved;
            }

            echo json_encode(array($row->batch_no,  date_format($date, "d-m-Y"), $remain, $outs,$itemInvoice));
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
            $batch = Stocks_items_total::where('id', $request->get('selectBatch' . $i))->first();

            $detail = [
                'item_id' => $request->get('select' . $i),
                'item_qty' => $request->get('qty' . $i),
                'item_price' => $request->get('itemprice' . $i),
                'total_line_cost' => $request->get('qty' . $i) * $request->get('itemprice' . $i),
                'item_disc_perc' =>  $request->get('per' . $i),
                'item_disc_value' => $request->get('disval' . $i),
                'item_bonus_qty' => $request->get('itemBonas' . $i),
                'item_vat_value' => $request->get('totalvat1' . $i),
                'final_line_cost' => ($request->get('qty' . $i) * $request->get('itemprice' . $i)) - $request->get('disval' . $i),

     

            ];
            if ($batch) {
                $detail['batch_no'] = $batch->batch_no;
                $detail['expired_date'] = $batch->expired_date;
            }
            if ($request->get('qty' . $i) > 0) {
                array_push($details, $detail);
            }
        }
        // Master
        $InvScreen = Invoice::where('id', $request->input('invoice_id'))->first();
        $max = Stocks_transaction::where('transaction_type_id', 104)->where('primary_stock_id',  $request->input('revertStock'))->latest('code')->first();

        $max = ($max != null) ? intval($max['code']) : 0;
        $max++;

        $data = [
            'code' => $max,
            'transaction_type_id' => 104,
            'transaction_date' => Carbon::parse($request->get('revertDate')),
            'invoice_id' => $request->get('invoice_id'),
            'primary_stock_id' => $request->input('revertStock'),
            'person_id' => $request->input('revertPerson'),
            'total_items_price'=> $request->input('total_items_price'),
            'person_name' => Person::where('id', $request->input('revertPerson'))->first()->name ?? '',
            'notes' => $request->get('revertNotes'),
            'confirmed' => 1,

        ];
        DB::beginTransaction();
        try {
            if ($details && !empty($details)) {
                // Disable foreign key checks!
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                $trans = Stocks_transaction::create($data);
                foreach ($details as $Item) {
                    $Item['transaction_id'] = $trans->id;
                    $trans_Item = Stock_transaction_item::create($Item);
                }
                //update total
                foreach ($details as $Items) {
                    $xx = [
                        'item_id' => $Items['item_id'],
                        'stock_id' => $trans->primary_stock_id,
                        'batch_no' => $Items['batch_no'],
                        'expired_date' => $Items['expired_date'],
                    ];

                    $transTotal = Stocks_items_total::where('item_id', $xx['item_id'])->where('stock_id', $xx['stock_id'])->where('expired_date', $xx['expired_date'])->where('batch_no', $xx['batch_no'])->firstOrNew($xx);

                    $transTotal->item_id = $Items['item_id'];
                    $transTotal->item_total_qty =  $trans->item_qty + $Items['item_qty'];
                    $transTotal->stock_id = $trans->primary_stock_id;
                    $transTotal->batch_no = $Items['batch_no'];
                    $transTotal->expired_date = $Items['expired_date'];
                    $transTotal->save();
                }




                //Make Finance Entry

                // $stockBranch = Stock::where('id', $request->input('stock_id'))->first();
                // $maxF = Financial_entry::where('trans_type_id', 104)->where('branch_id', $stockBranch->branch_id)->latest('entry_serial')->first();

                // $maxF = ($maxF != null) ? intval($maxF['entry_serial']) : 0;
                // $maxF++;
                // //sum of prices
                // $PricesSum = 0.0;

                // foreach ($financeArray as $finance) {

                //     $PricesSum += $finance['totalPrice'];
                // }
                // //Finance Entry add 2 records

                // $firstFinance = new Financial_entry();
                // $firstFinance->trans_type_id = 104;
                // $firstFinance->entry_serial = $maxF;
                // $firstFinance->entry_date = Carbon::parse($request->get('transaction_date'));
                // $firstFinance->stock_id =  $request->input('stock_id');
                // $firstFinance->branch_id = $stockBranch->branch_id;
                // $firstFinance->credit = $PricesSum;
                // $firstFinance->debit = 0;
                // $firstFinance->gl_item_id = $stockBranch->gl_item_id;

                // $firstFinance->save();
                // //second row
                // $secondFinance = new Financial_entry();
                // $secondFinance->trans_type_id = 104;
                // $secondFinance->entry_serial = $maxF;
                // $secondFinance->entry_date = Carbon::parse($request->get('transaction_date'));
                // $secondFinance->stock_id =  $request->input('stock_id');
                // $secondFinance->branch_id = $stockBranch->branch_id;
                // $secondFinance->debit = $PricesSum;
                // $secondFinance->credit =0;
                // $secondFinance->gl_item_id = Financial_subsystem::where('id', 121)->first()->gl_item_id ?? 0;

                // $secondFinance->save();

                //End Finance

                $request->session()->flash('flash_success', "تم اضافة حركة مرتجع :");
                DB::commit();
                // Enable foreign key checks!
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                return redirect()->route('revert-sale.show', $InvScreen->id)->with('flash_success', $this->message);
            } else {
                return redirect()->back()->withInput()->with('flash_danger', "هذا المرتجع لا يحتوى على أصناف مرتجعه");
            }
        } catch (\Throwable $e) {
            // throw $th;
            DB::rollback();

            return redirect()->back()->withInput()->with('flash_danger', $e->getMessage());
        }
    }
}

