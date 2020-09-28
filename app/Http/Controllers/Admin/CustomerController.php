<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Financial_entry;
use App\Models\Financial_subsystem;
use App\Models\Location;
use App\Models\Person;
use App\Models\Person_catrgory;
use App\Models\Representative;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use File;
use DB;

class CustomerController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Person $object)
    {


        $this->object = $object;

        $this->viewName = 'customer.';
        $this->routeName = 'customer.';

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

        $rows = Person::where('person_type_id', 101)->orderBy('created_at', 'Desc')->get();

        return view($this->viewName . 'index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('id', 1)->first();
        $branches = $user->branch;
        $person_categories = Person_catrgory::all();
        $marketers = Representative::where('rep_type_id', 101)->get();
        $sales = Representative::where('rep_type_id', 100)->get();
        $currencies = Currency::all();
        $countries = Country::all();
        $cities = [];
        $locations = [];
        return view($this->viewName . 'add', compact('branches', 'person_categories', 'marketers', 'sales', 'currencies', 'countries', 'cities', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $personBranch = Branch::where('id', $request->input('branch_id'))->first();

        $increment = Person::latest('code')->first();

        $increment = ($increment != null) ? intval($increment['code']) : $personBranch['start_code'] - 1;

        $increment++;
        $data = [
            'code' => $increment,
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
            'last_invoice_date' => Carbon::parse($request->input('last_invoice_date')),
            'person_type_id' => 101,
        ];

        if ($request->input('person_currency_id')) {

            $data['person_currency_id'] = $request->input('person_currency_id');
        }

        if ($request->input('person_category_id')) {

            $data['person_category_id'] = $request->input('person_category_id');
        }
        if ($request->input('branch_id')) {

            $data['branch_id'] = $request->input('branch_id');
        }

        if ($request->input('country_id')) {

            $data['country_id'] = $request->input('country_id');
        }
        if ($request->input('city_id')) {

            $data['city_id'] = $request->input('city_id');
        }
        if ($request->input('location_id')) {

            $data['location_id'] = $request->input('location_id');
        }

        if ($request->input('sales_rep_id')) {

            $data['sales_rep_id'] = $request->input('sales_rep_id');
        }
        if ($request->input('marketing_rep_id')) {

            $data['marketing_rep_id'] = $request->input('marketing_rep_id');
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
            if ($increment > $personBranch['end_code']) {
                return redirect()->route($this->routeName . 'index')->with('flash_danger', "كود العميل اكبر من نطاق الكود للفرع");
            } else {
                $customer = $this->object::create($data);
                $financeEntry = new Financial_entry();
                $financeEntry->trans_type_id = 102;
                $financeEntry->entry_serial = -1;
                $financeEntry->entry_date = $data['person_open_balance_date'];
                $financeEntry->person_id = $customer->id;
                $financeEntry->person_name = $data['name'];
                $financeEntry->branch_id = $data['branch_id'];
                $financeEntry->entry_statment = "رصيد أفتتاحى لعميل";
                if ($data['balance_type'] == 1) {
                    $financeEntry->debit = $data['person_open_balance'];
                    $financeEntry->credit = 0;
                } else {
                    $financeEntry->debit = 0;
                    $financeEntry->credit = $data['person_open_balance'];
                }
                $gl = Financial_subsystem::where('id', 115)->first();
                $financeEntry->gl_item_id = $gl->gl_item_id;

                $financeEntry->save();
            }


            DB::commit();
            // Enable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } catch (\Exception $e) {

            DB::rollback();

            $success = false;
        }

        if ($success=true) {
            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
        } else {
            return redirect()->route($this->routeName . 'index')->with('flash_danger', $this->errormessage);
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
        $user = User::where('id', 1)->first();
        $branches = $user->branch;
        $person_categories = Person_catrgory::all();
        $marketers = Representative::where('rep_type_id', 101)->get();
        $sales = Representative::where('rep_type_id', 100)->get();
        $currencies = Currency::all();
        $countries = Country::all();
        $cities = City::where('country_id', $row->country_id)->get();
        $locations = Location::where('city_id', $row->city_id)->get();
        return view($this->viewName . 'view', compact('row', 'branches', 'person_categories', 'marketers', 'sales', 'currencies', 'countries', 'cities', 'locations'));
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
        $user = User::where('id', 1)->first();
        $branches = $user->branch;
        $person_categories = Person_catrgory::all();
        $marketers = Representative::where('rep_type_id', 101)->get();
        $sales = Representative::where('rep_type_id', 100)->get();
        $currencies = Currency::all();
        $countries = Country::all();
        $cities = City::where('country_id', $row->country_id)->get();
        $locations = Location::where('city_id', $row->city_id)->get();
        return view($this->viewName . 'edit', compact('row', 'branches', 'person_categories', 'marketers', 'sales', 'currencies', 'countries', 'cities', 'locations'));
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
            'last_invoice_date' => Carbon::parse($request->input('last_invoice_date')),

        ];

        if ($request->input('person_currency_id')) {

            $data['person_currency_id'] = $request->input('person_currency_id');
        }

        if ($request->input('person_category_id')) {

            $data['person_category_id'] = $request->input('person_category_id');
        }
        if ($request->input('branch_id')) {

            $data['branch_id'] = $request->input('branch_id');
        }

        if ($request->input('country_id')) {

            $data['country_id'] = $request->input('country_id');
        }
        if ($request->input('city_id')) {

            $data['city_id'] = $request->input('city_id');
        }
        if ($request->input('location_id')) {

            $data['location_id'] = $request->input('location_id');
        }

        if ($request->input('sales_rep_id')) {

            $data['sales_rep_id'] = $request->input('sales_rep_id');
        }
        if ($request->input('marketing_rep_id')) {

            $data['marketing_rep_id'] = $request->input('marketing_rep_id');
        }


        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $data['image'] = $this->UplaodImage($image);
        }






        DB::transaction(function () use ($data,  $id) {


            $customerUpdate = $this->object::findOrFail($id)->update($data);

            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
        });
        return redirect()->route($this->routeName . 'index')->with('flash_danger', $this->errormessage);
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
     * get city dependant on country.
     *
     * @param  request
     * @return \Illuminate\Http\Response
     */
    public function fetchCity(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');

        $data = City::where('country_id', $value)->get();

        $output = '<option value="">Select</option>';
        foreach ($data as $row) {

            $output .= '<option value="' . $row->id . '">' . $row->ar_name . '</option>';
        }



        echo $output;
    }

    /**
     * get locations dependant on city.
     *
     * @param  request
     * @return \Illuminate\Http\Response
     */
    public function fetchLocation(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');

        $data = Location::where('city_id', $value)->get();

        $output = '<option value="">Select</option>';
        foreach ($data as $row) {

            $output .= '<option value="' . $row->id . '">' . $row->ar_name . '</option>';
        }



        echo $output;
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
