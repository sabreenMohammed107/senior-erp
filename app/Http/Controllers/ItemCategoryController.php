<?php

namespace App\Http\Controllers;

use App\Models\Item_category;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Item_category $object)
    {


        $this->object = $object;
        $this->viewName = 'item-category.';
        $this->routeName = 'item-category.';

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
        $rows = Item_category::whereNull('parent_id')->orderBy('created_at', 'Desc')->paginate(8);

        return view($this->viewName . 'index', compact('rows'));
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
        $max = Item_category::whereNull('parent_id')->latest('code')->first();


        $max = ($max != null) ? intval($max['code']) : 0;
        $max++;


        $data = [
            'ar_name' => $request->input('ar_name'),
            'en_name' => $request->input('en_name'),

            'code' => $max,
            'ar_description' => $request->input('ar_description'),
            'en_description' => $request->input('en_description'),



        ];



        try {
            $this->object::create($data);
        } catch (QueryException $q) {

            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->errormessage);
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
        $row = Item_category::where('id', '=', $id)->first();
        $cats = Item_category::where('parent_id', '=', $id)->get();
        return view($this->viewName . 'view', compact('row', 'cats'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Item_category::where('id', '=', $id)->first();
        $cats = Item_category::where('parent_id', '=', $id)->get();
        return view($this->viewName . 'edit', compact('row', 'cats'));
    }

    public function AddsubCategory(Request $request)
    {
        $parentmax = Item_category::where('id', $request->input('parent_id'))->first();

        $increment = Item_category::where('parent_id', $request->input('parent_id'))->latest('code')->first();
       
        $increment = ($increment != null) ? intval($increment['code']) : $parentmax['code'] . sprintf("%02d",0);
        $childmax =sprintf("%02d", $increment);
        $childmax++;


        $data = [
            'ar_name' => $request->input('ar_name'),
            'en_name' => $request->input('en_name'),
            'parent_id' => $request->input('parent_id'),
            'code' => $childmax,
            'ar_description' => $request->input('ar_description'),
            'en_description' => $request->input('en_description'),



        ];



        try {
            $this->object::create($data);
        } catch (QueryException $q) {

            return redirect()->back()->with('flash_success', $this->errormessage);
        }


        return redirect()->back()->with('flash_success', $this->message);
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
        $cat = $this->object::findOrFail($id);
        $data = [
            'ar_name' => $request->input('ar_name'),
            'en_name' => $request->input('en_name'),


            'ar_description' => $request->input('ar_description'),
            'en_description' => $request->input('en_description'),



        ];



        try {
            $cat->update($data);
        } catch (QueryException $q) {

            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->errormessage);
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
        $row = Item_category::where('id', '=', $id)->first();

        try {
            $row->parent()->delete();
            $row->delete();
           
        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'هذا الجدول مرتبط ببيانات أخرى');
        }
        return redirect()->back()->with('flash_success', 'تم الحذف بنجاح !');
    
    }
    /**
     * 
     */
    public function deletesubCategory($id){

        $row = Item_category::where('id', '=', $id)->first();

        try {
          
            $row->delete();
        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'هذا الجدول مرتبط ببيانات أخرى');
        }
        return redirect()->back()->with('flash_success', 'تم الحذف بنجاح !');
    }
}
