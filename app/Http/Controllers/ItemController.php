<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use DB;
use Log;
use File;

class ItemController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Item $object)
    {


        $this->object = $object;
        $this->viewName = 'items.';
        $this->routeName = 'items.';

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
        $rows = Item::paginate(8);
        return view($this->viewName . 'index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rows = Item::paginate(8);
        $persons =  DB::table('persons')->where('PERSON_TYPE_ID', 2)->get();
        $category = DB::table('item_categories')->whereNotNull('PARENT_ID')->get();
        $uoms = DB::table('unit_measure')->get();

        return view($this->viewName . 'add', compact('persons', 'uoms', 'category'));
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
            'ITEM_CATEGORY_ID' => $request->input('ITEM_CATEGORY_ID'),
            'ITEM_AR_NAME' => $request->input('ITEM_AR_NAME'),
            'ITEM_EN_NAME' => $request->input('ITEM_EN_NAME'),
            'VAT_VALUE' => $request->input('VAT_VALUE'),

            'STORAGE_UOM_ID' => $request->input('STORAGE_UOM_ID'),

            'MIN_LIMIT' => $request->input('MIN_LIMIT'),
            'MAX_LIMIT' => $request->input('MAX_LIMIT'),
            'REQUEST_LIMIT' => $request->input('REQUEST_LIMIT'),
            'HAS_BARCODE' => $request->input('HAS_BARCODE'),
            'ITEM_BARCODE' => $request->input('ITEM_BARCODE'),
            'ITEM_AR_DESCRIPTION' => $request->input('ITEM_AR_DESCRIPTION'),
            'ITEM_EN_DESCRIPTION' => $request->input('ITEM_EN_DESCRIPTION'),


            'DEFAULT_UOM_ID' => $request->input('DEFAULT_UOM_ID'),
            'AVERAGE_PRICE' => $request->input('AVERAGE_PRICE'),

            'WHOLESALE_PRICE' => $request->input('WHOLESALE_PRICE'),
            'RETAIL_PRICE' => $request->input('RETAIL_PRICE'),
            'PERSON_ID' => $request->input('PERSON_ID'),


            'ITEM_TOTAL_QTY' => $request->input('ITEM_TOTAL_QTY'),
            'ITEM_TOTAL_COST' => $request->input('ITEM_TOTAL_COST'),
            'NOTES' => $request->input('NOTES'),


        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $data['image'] = $this->UplaodImage($image);
        }


        if ($request->input('ALLOW_SELLING_COMMISSIONS')) {


            $data['ALLOW_SELLING_COMMISSIONS'] = 1;
        } else {
            $data['ALLOW_SELLING_COMMISSIONS'] = 0;
        }



        if ($request->input('HAS_BATCH')) {


            $data['HAS_BATCH'] = 1;
        } else {
            $data['HAS_BATCH'] = 0;
        }

        
        if ($request->input('ALLOWED_SERIAL')) {


            $data['ALLOWED_SERIAL'] = 1;
        } else {
            $data['ALLOWED_SERIAL'] = 0;
        }
        if ($request->input('HAS_EXPIRED_DATE')) {


            $data['HAS_EXPIRED_DATE'] = 1;
        } else {
            $data['HAS_EXPIRED_DATE'] = 0;
        }

        if ($request->input('HAS_BARCODE')) {


            $data['HAS_BARCODE'] = 1;
        } else {
            $data['HAS_BARCODE'] = 0;
        }

        if ($request->input('ALLOW_FREE_SAMPLES')) {


            $data['ALLOW_FREE_SAMPLES'] = 1;
        } else {
            $data['ALLOW_FREE_SAMPLES'] = 0;
        }

        if ($request->input('ALLOW_SELLING_COMMISSIONS')) {


            $data['ALLOW_SELLING_COMMISSIONS'] = 1;
        } else {
            $data['ALLOW_SELLING_COMMISSIONS'] = 0;
        }

        if ($request->input('ALLOW_DISCOUNTS')) {


            $data['ALLOW_DISCOUNTS'] = 1;
        } else {
            $data['ALLOW_DISCOUNTS'] = 0;
        }



        try {
            $item = DB::table('items')->insertGetId($data);
        } catch (QueryException $q) {

            return redirect()->route($this->routeName . 'index')->with('flash_danger', $this->errormessage);
        }


        return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
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
        $row = DB::table('items')->where('ITEM_ID', $id)->first();

        $persons =  DB::table('persons')->where('PERSON_TYPE_ID', 2)->get();
        $category = DB::table('item_categories')->whereNotNull('PARENT_ID')->get();
        $uoms = DB::table('unit_measure')->get();

        return view($this->viewName . 'edit', compact('persons', 'uoms', 'category', 'row'));
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
        //  DB::table('orders')->where('ORDER_ID', $id)->update($data);
        $data = [
            'ITEM_CATEGORY_ID' => $request->input('ITEM_CATEGORY_ID'),
            'ITEM_AR_NAME' => $request->input('ITEM_AR_NAME'),
            'ITEM_EN_NAME' => $request->input('ITEM_EN_NAME'),
            'VAT_VALUE' => $request->input('VAT_VALUE'),

            'STORAGE_UOM_ID' => $request->input('STORAGE_UOM_ID'),

            'MIN_LIMIT' => $request->input('MIN_LIMIT'),
            'MAX_LIMIT' => $request->input('MAX_LIMIT'),
            'REQUEST_LIMIT' => $request->input('REQUEST_LIMIT'),
            'HAS_BARCODE' => $request->input('HAS_BARCODE'),
            'ITEM_BARCODE' => $request->input('ITEM_BARCODE'),
            'ITEM_AR_DESCRIPTION' => $request->input('ITEM_AR_DESCRIPTION'),

            'ITEM_EN_DESCRIPTION' => $request->input('ITEM_EN_DESCRIPTION'),
            'DEFAULT_UOM_ID' => $request->input('DEFAULT_UOM_ID'),
            'AVERAGE_PRICE' => $request->input('AVERAGE_PRICE'),

            'WHOLESALE_PRICE' => $request->input('WHOLESALE_PRICE'),
            'RETAIL_PRICE' => $request->input('RETAIL_PRICE'),
            'PERSON_ID' => $request->input('PERSON_ID'),


            'ITEM_TOTAL_QTY' => $request->input('ITEM_TOTAL_QTY'),
            'ITEM_TOTAL_COST' => $request->input('ITEM_TOTAL_COST'),
            'NOTES' => $request->input('NOTES'),



        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $data['image'] = $this->UplaodImage($image);
        }


        if ($request->input('ALLOW_SELLING_COMMISSIONS')) {


            $data['ALLOW_SELLING_COMMISSIONS'] = 1;
        } else {
            $data['ALLOW_SELLING_COMMISSIONS'] = 0;
        }



        if ($request->input('HAS_BATCH')) {


            $data['HAS_BATCH'] = 1;
        } else {
            $data['HAS_BATCH'] = 0;
        }

        
        if ($request->input('ALLOWED_SERIAL')) {


            $data['ALLOWED_SERIAL'] = 1;
        } else {
            $data['ALLOWED_SERIAL'] = 0;
        }
        if ($request->input('HAS_EXPIRED_DATE')) {


            $data['HAS_EXPIRED_DATE'] = 1;
        } else {
            $data['HAS_EXPIRED_DATE'] = 0;
        }

        if ($request->input('HAS_BARCODE')) {


            $data['HAS_BARCODE'] = 1;
        } else {
            $data['HAS_BARCODE'] = 0;
        }

        if ($request->input('ALLOW_FREE_SAMPLES')) {


            $data['ALLOW_FREE_SAMPLES'] = 1;
        } else {
            $data['ALLOW_FREE_SAMPLES'] = 0;
        }

        if ($request->input('ALLOW_SELLING_COMMISSIONS')) {


            $data['ALLOW_SELLING_COMMISSIONS'] = 1;
        } else {
            $data['ALLOW_SELLING_COMMISSIONS'] = 0;
        }

        if ($request->input('ALLOW_DISCOUNTS')) {


            $data['ALLOW_DISCOUNTS'] = 1;
        } else {
            $data['ALLOW_DISCOUNTS'] = 0;
        }



        try {
            DB::table('items')->where('ITEM_ID', $id)->update($data);
        } catch (QueryException $q) {

            return redirect()->route($this->routeName . 'index')->with('flash_danger', $this->errormessage);
        }


        return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = DB::table('items')->where('ITEM_ID', $id)->first();
        // Delete File ..

        $file = $row->image;

        $file_name = public_path('uploads/items/' . $file);


        //  }
        try {
            DB::table('items')->where('ITEM_ID', $id)->delete();
            File::delete($file_name);
        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'هذا الجدول مرتبط ببيانات أخرى');
        }
        return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');
    }
    /**
     * image
     */
    /**
     * uplaud image
     */
    public function UplaodImage($file_request)
    {
        //  This is Image Info..
        $file = $file_request;
        $name = $file->getClientOriginalName();
        $ext  = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $path = $file->getRealPath();
        $mime = $file->getMimeType();


        // Rename The Image ..
        $imageName = $name;
        $uploadPath = public_path('uploads/items');

        // Move The image..
        $file->move($uploadPath, $imageName);

        return $imageName;
    }
}
