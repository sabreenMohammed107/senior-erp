<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Items_price;
use App\Models\Person;
use App\Models\Person_catrgory;
use App\Models\Pric_disc_type;
use Illuminate\Http\Request;
use DB;
use Log;

class ItemPricingController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Items_price $object)
    {


        $this->object = $object;

        $this->viewName = 'item-price.';
        $this->routeName = 'item-price.';

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
        $rows = Items_price::orderBy('created_at', 'Desc')->get();

        return view($this->viewName . 'index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::all();
        $cats = Person_catrgory::where('category_type','=',1)->get();
        $clients = Person::where('person_type_id', 101)->orderBy('created_at', 'Desc')->get();

        return view($this->viewName . 'add', compact('items', 'cats', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = $request->get('rowCountStore');

        $details = [];
        for ($i = 1; $i <= $count; $i++) {


            $detail = [

                'client_category_id' => $request->get('selectCat' . $i),
                'client_id' => $request->get('selectClient' . $i),
                'item_price' => $request->get('item_price' . $i),


            ];
            if ($request->get('optionsRadios' . $i) == 1) {
                $detail['item_pricing_type_id'] = 101;
            } else {
                $detail['item_pricing_type_id'] = 100;
            }

            if ($request->get('item_price' . $i)) {
                array_push($details, $detail);
            }
        }
        \Log::info($detail);
        $counterrrr = $request->get('counterStore');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {



            $detailUpdate = [
                'id' => $request->get('item_price_id' . $i),

                'item_price' => $request->get('item_priceup' . $i),

            ];
            array_push($detailsUpdate, $detailUpdate);
        }
        DB::beginTransaction();
        try {

            foreach ($details as $Item) {

                $Item['item_id'] = $request->get('item_id');
                Items_price::create($Item);
            }
            foreach ($detailsUpdate as $updates) {
                $itm = Items_price::where('id', $updates['id'])->first();

                Items_price::where('id', $updates['id'])->update($updates);
            }
            DB::commit();

            return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم  إضافة سعر للصنف !');
        } catch (\Throwable $e) {
            // throw $th;
            DB::rollBack();

            return redirect()->back()->with('flash_success',  $e->getMessage());
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
        $row = Item::where('id', $id)->first();
        $items = Item::all();
        $priceItems = Items_price::where('item_id', $id)->get();
        $cats = Person_catrgory::where('category_type','=',1)->get();
        $clients = Person::where('person_type_id', 101)->orderBy('created_at', 'Desc')->get();
        return view($this->viewName . 'view', compact('priceItems', 'cats', 'items', 'clients', 'row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Item::where('id', $id)->first();
        $items = Item::all();
        $priceItems = Items_price::where('item_id', $id)->get();
        $cats = Person_catrgory::where('category_type','=',1)->get();
        $clients = Person::where('person_type_id', 101)->orderBy('created_at', 'Desc')->get();
        return view($this->viewName . 'edit', compact('priceItems', 'cats', 'items', 'clients', 'row'));
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
        $count = $request->get('rowCountStore');

        $details = [];
        for ($i = 1; $i <= $count; $i++) {


            $detail = [

                'client_category_id' => $request->get('selectCat' . $i),
                'client_id' => $request->get('selectClient' . $i),
                'item_price' => $request->get('item_price' . $i),


            ];
            if ($request->get('optionsRadios' . $i) == 'no') {
                $detail['item_pricing_type_id'] = 101;
            } else {
                $detail['item_pricing_type_id'] = 100;
            }

            if ($request->get('item_price' . $i)) {
                array_push($details, $detail);
            }
        }




        \Log::info($detail);

        $counterrrr = $request->get('counterStore');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {



            $detailUpdate = [
                'id' => $request->get('item_price_id' . $i),

                'item_price' => $request->get('item_priceup' . $i),

            ];
            array_push($detailsUpdate, $detailUpdate);
        }
        DB::beginTransaction();
        try {

            foreach ($details as $Item) {

                $Item['item_id'] = $id;
                Items_price::create($Item);
            }


            foreach ($detailsUpdate as $updates) {
                $itm = Items_price::where('id', $updates['id'])->first();

                Items_price::where('id', $updates['id'])->update($updates);
            }
            DB::commit();

            return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم  إضافة سعر للصنف !');
        } catch (\Throwable $e) {
            // throw $th;
            DB::rollBack();

            return redirect()->back()->with('flash_success',  $e->getMessage());
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

    /***
     * 
     */

    public function AddRow(Request $req)
    {

        if ($req->ajax()) {
            $id = $req->id;
            $rowCount = $req->rowcount;
            $cats = Person_catrgory::where('category_type','=',1)->get();
            $clients = Person::where('person_type_id', 101)->orderBy('created_at', 'Desc')->get();

            $ajaxComponent = view('item-price.ajaxAdd', [
                'rowCount' => $rowCount,
                'cats' => $cats,
                'clients' => $clients,

            ]);

            // echo json_encode($items);
            return $ajaxComponent->render();
        }
    }

    public function DeletePriceItem(Request $req)
    {


        if ($req->ajax()) {

            $item = Items_price::where('id', $req->id)->first();


            $item->delete();
        }
    }

    public function itemPrices(Request $req)
    {

        if ($req->ajax()) {
            $id = $req->item_id;
            $priceItems = Items_price::where('item_id', $id)->get();
            $cats = Person_catrgory::where('category_type','=',1)->get();
            $clients = Person::where('person_type_id', 101)->orderBy('created_at', 'Desc')->get();
            $ajaxComponent = view('item-price.ajaxEdit', [
                'priceItems' => $priceItems,
                'clients' => $clients,
                'cats' => $cats,

            ]);


            return $ajaxComponent->render();
        }
    }
}
