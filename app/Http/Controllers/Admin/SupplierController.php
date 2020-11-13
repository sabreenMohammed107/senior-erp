<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Financial_entry;
use App\Models\Financial_subsystem;
use App\Models\Person;
use App\Models\Person_catrgory;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use File;
use DB;

class SupplierController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Person $object)
    {


        $this->object = $object;

        $this->viewName = 'supplier.';
        $this->routeName = 'supplier.';

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
        $rows = Person::where('person_type_id', 100)->orderBy('created_at', 'Desc')->get();

        return view($this->viewName . 'index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $person_categories = Person_catrgory::where('category_type','=',0)->get();

        $currencies = Currency::all();

        return view($this->viewName . 'add', compact('person_categories', 'currencies',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $max = Person::where('person_type_id', 100)->latest('code')->first();

        $max = ($max != null) ? intval($max['code']) : 0;
        $max++;

        $data = [
            'code' => $max,
            'name' => $request->input('name'),
            'nick_name' => $request->input('nick_name'),
            'phone1' => $request->input('phone1'),
            'phone2' => $request->input('phone2'),
            'fax' => $request->input('fax'),
            'contact_person' => $request->input('contact_person'),
            'contact_person_mobile' => $request->input('contact_person_mobile'),
            'website' => $request->input('website'),
            'email' => $request->input('email'),
            'commercial_register' => $request->input('commercial_register'),
            'tax_card' => $request->input('tax_card'),
            'tax_authority' => $request->input('tax_authority'),
            'person_open_balance' => $request->input('person_open_balance'),
            'person_open_balance_date' => Carbon::parse($request->get('person_open_balance_date')),
            'person_limit_balance' => $request->input('person_limit_balance'),
            'notes' => $request->input('notes'),
            'person_type_id' => 100,
        ];

        if ($request->input('person_currency_id')) {

            $data['person_currency_id'] = $request->input('person_currency_id');
        }

        if ($request->input('person_category_id')) {

            $data['person_category_id'] = $request->input('person_category_id');
        }



        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $data['image'] = $this->UplaodImage($image);
        }


        if ($request->input('balance_type')) {


            $data['balance_type'] = 1;
        } else {
            $data['balance_type'] = 0;
        }



        $success = true;

        DB::beginTransaction();

        try {

            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $supplier = $this->object::create($data);
            $financeEntry = new Financial_entry();
            $financeEntry->trans_type_id = 102;
            $financeEntry->entry_serial = -1;
            $financeEntry->entry_date = $data['person_open_balance_date'];
            $financeEntry->person_id = $supplier->id;
            $financeEntry->person_name = $data['name'];

            $financeEntry->entry_statment = "رصيد أفتتاحى لمورد";
            if ($data['balance_type'] == 1) {
                $financeEntry->credit = $data['person_open_balance'];
                $financeEntry->debit = 0;
            } else {
                $financeEntry->credit = 0;
                $financeEntry->debit = $data['person_open_balance'];
            }
            $gl = Financial_subsystem::where('id', 110)->first();
            $financeEntry->gl_item_id = $gl->gl_item_id;

            $financeEntry->save();




            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
        } catch (\Exception $e) {

            DB::rollback();


            return redirect()->back()->with('flash_danger', $e->getMessage());
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
        $row = Person::where('id', $id)->first();

        $person_categories =  Person_catrgory::where('category_type','=',0)->get();

        $currencies = Currency::all();

        return view($this->viewName . 'view', compact('row', 'person_categories', 'currencies',));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Person::where('id', $id)->first();

        $person_categories =  Person_catrgory::where('category_type','=',0)->get();

        $currencies = Currency::all();

        return view($this->viewName . 'edit', compact('row', 'person_categories', 'currencies',));
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

            'name' => $request->input('name'),
            'nick_name' => $request->input('nick_name'),
            'phone1' => $request->input('phone1'),
            'phone2' => $request->input('phone2'),
            'fax' => $request->input('fax'),
            'contact_person' => $request->input('contact_person'),
            'contact_person_mobile' => $request->input('contact_person_mobile'),
            'website' => $request->input('website'),
            'email' => $request->input('email'),
            'commercial_register' => $request->input('commercial_register'),
            'tax_card' => $request->input('tax_card'),
            'tax_authority' => $request->input('tax_authority'),

            'person_limit_balance' => $request->input('person_limit_balance'),
            'notes' => $request->input('notes'),

        ];

        if ($request->input('person_currency_id')) {

            $data['person_currency_id'] = $request->input('person_currency_id');
        }

        if ($request->input('person_category_id')) {

            $data['person_category_id'] = $request->input('person_category_id');
        }



        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $data['image'] = $this->UplaodImage($image);
        }


        if ($request->input('balance_type')) {


            $data['balance_type'] = 1;
        } else {
            $data['balance_type'] = 0;
        }

       


           $this->object::findOrFail($id)->update($data);
     
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
        $row = Person::where('id', $id)->first();
        // Delete File ..

        $file = $row->image;

        $file_name = public_path('uploads/persons/' . $file);

        //Transactions check for open_balance
        $Transactions =Financial_entry::where('trans_type_id', '<>', 102)->where('person_id', '=', $id)->count();
        //Actions
        if ($Transactions == 0) {
            DB::beginTransaction();
            try {

                Financial_entry::where('trans_type_id', '=', 102)->where('person_id', '=', $id)->delete();

                $row->delete();
                File::delete($file_name);

                DB::commit();
                return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');
            } catch (QueryException $q) {
                DB::rollBack();
                
                return redirect()->back()->with('flash_danger', 'هذا الجدول مرتبط ببيانات أخرى');
            }
        } else {
            return redirect()->back()->with('flash_danger', 'هذا الجدول مرتبط ببيانات أخرى');
        }
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
        $uploadPath = public_path('uploads/persons');

        // Move The image..
        $file->move($uploadPath, $imageName);

        return $imageName;
    }
}
