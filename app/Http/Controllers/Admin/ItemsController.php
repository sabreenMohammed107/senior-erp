<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Item_category;
use App\Models\Person;
use App\Models\Unit_measure;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Log;
use File;

class ItemsController extends Controller
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
        $persons = Person::where('person_type_id', 100)->get();
        $category = Item_category::whereNotNull('PARENT_ID')->get();
        $uoms = Unit_measure::all();

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
        $parentmax = Item_category::where('id', $request->input('item_category_id'))->first();

        $increment = Item::where('item_category_id',$request->input('item_category_id'))->latest('code')->first();

        $increment = ($increment != null) ? intval($increment['code']) : $parentmax['code'] . sprintf("%05d", 0);
        $childmax = sprintf("%05d", $increment);
        $childmax++;

        $data = [
            'code' => $childmax,
            'item_category_id' => $request->input('item_category_id'),
            'ar_name' => $request->input('ar_name'),
            'en_name' => $request->input('en_name'),
            'vat_value' => $request->input('vat_value'),
            'storage_uom_id' => $request->input('storage_uom_id'),
            'min_limit' => $request->input('min_limit'),
            'max_limit' => $request->input('max_limit'),
            'request_limit' => $request->input('request_limit'),
            'item_barcode' => $request->input('item_barcode'),
            'ar_description' => $request->input('ar_description'),
            'en_description' => $request->input('en_description'),
            'default_uom_id' => $request->input('default_uom_id'),
            'average_price' => $request->input('average_price'),
            'wholesale_price' => $request->input('wholesale_price'),
            'retail_price' => $request->input('retail_price'),
            'person_id' => $request->input('person_id'),
            'item_total_qty' => $request->input('item_total_qty'),
            'item_total_cost' => $request->input('item_total_cost'),
            'notes' => $request->input('notes'),


        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $data['image'] = $this->UplaodImage($image);
        }


        if ($request->input('allow_sale_commission')) {


            $data['allow_sale_commission'] = 1;
        } else {
            $data['allow_sale_commission'] = 0;
        }



        if ($request->input('has_batch')) {


            $data['has_batch'] = 1;
        } else {
            $data['has_batch'] = 0;
        }


        if ($request->input('allowed_serial')) {


            $data['allowed_serial'] = 1;
        } else {
            $data['allowed_serial'] = 0;
        }
        if ($request->input('has_expired_date')) {


            $data['has_expired_date'] = 1;
        } else {
            $data['has_expired_date'] = 0;
        }

        if ($request->input('has_barcode')) {


            $data['has_barcode'] = 1;
        } else {
            $data['has_barcode'] = 0;
        }

        if ($request->input('allow_free_sale')) {


            $data['allow_free_sale'] = 1;
        } else {
            $data['allow_free_sale'] = 0;
        }



        if ($request->input('allowe_discount')) {


            $data['allowe_discount'] = 1;
        } else {
            $data['allowe_discount'] = 0;
        }



        try {
            $this->object::create($data);
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
        $row = Item::where('id', $id)->first();
        $persons = Person::where('person_type_id', 100)->get();
        $category = Item_category::whereNotNull('PARENT_ID')->get();
        $uoms = Unit_measure::all();
        return view($this->viewName . 'view', compact('persons', 'uoms', 'category', 'row'));
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
        $persons = Person::where('person_type_id', 100)->get();
        $category = Item_category::whereNotNull('PARENT_ID')->get();
        $uoms = Unit_measure::all();
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
        $data = [
            'item_category_id' => $request->input('item_category_id'),
            'ar_name' => $request->input('ar_name'),
            'en_name' => $request->input('en_name'),
            'vat_value' => $request->input('vat_value'),
            'storage_uom_id' => $request->input('storage_uom_id'),
            'min_limit' => $request->input('min_limit'),
            'max_limit' => $request->input('max_limit'),
            'request_limit' => $request->input('request_limit'),
            'item_barcode' => $request->input('item_barcode'),
            'ar_description' => $request->input('ar_description'),
            'en_description' => $request->input('en_description'),
            'default_uom_id' => $request->input('default_uom_id'),
            'average_price' => $request->input('average_price'),
            'wholesale_price' => $request->input('wholesale_price'),
            'retail_price' => $request->input('retail_price'),
            'person_id' => $request->input('person_id'),
            'item_total_qty' => $request->input('item_total_qty'),
            'item_total_cost' => $request->input('item_total_cost'),
            'notes' => $request->input('notes'),


        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $data['image'] = $this->UplaodImage($image);
        }


        if ($request->input('allow_sale_commission')) {


            $data['allow_sale_commission'] = 1;
        } else {
            $data['allow_sale_commission'] = 0;
        }



        if ($request->input('has_batch')) {


            $data['has_batch'] = 1;
        } else {
            $data['has_batch'] = 0;
        }


        if ($request->input('allowed_serial')) {


            $data['allowed_serial'] = 1;
        } else {
            $data['allowed_serial'] = 0;
        }
        if ($request->input('has_expired_date')) {


            $data['has_expired_date'] = 1;
        } else {
            $data['has_expired_date'] = 0;
        }

        if ($request->input('has_barcode')) {


            $data['has_barcode'] = 1;
        } else {
            $data['has_barcode'] = 0;
        }

        if ($request->input('allow_free_sale')) {


            $data['allow_free_sale'] = 1;
        } else {
            $data['allow_free_sale'] = 0;
        }



        if ($request->input('allowe_discount')) {


            $data['allowe_discount'] = 1;
        } else {
            $data['allowe_discount'] = 0;
        }



        try {
            $this->object::findOrFail($id)->update($data);
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
        $row = Item::where('id', $id)->first();
        // Delete File ..

        $file = $row->image;

        $file_name = public_path('uploads/items/' . $file);


        //  }
        try {
            $row->delete();
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


      /***
     * 
     */
    public function search(Request $request)
    {
        $name= $request->input('searchData');
        $code= $request->input('searchData');
      
        $rows = Item::where('ar_name', 'like', '%' . $name . '%')->orWhere('code', 'like', '%' . $code . '%')->orderBy('created_at', 'Desc')->paginate(8);
        if ($request->ajax()) {
         return view($this->viewName . 'result', compact('rows'))->render();
        }else{
            return view($this->viewName . 'index', compact('rows'));
        }
    }
}
