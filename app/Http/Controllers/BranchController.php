<?php

namespace App\Http\Controllers;

use App\Models\Admin_branch;
use Illuminate\Http\Request;
use DB;
use Illuminate\Database\QueryException;

class BranchController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Admin_branch $object)
    {


        $this->object = $object;
        $this->viewName = 'branch.';
        $this->routeName = 'branch.';

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
        $rows = Admin_branch::orderBy('created_at', 'Desc')->paginate(8);

        return view($this->viewName . 'index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $max = Admin_branch::latest('code')->first();
      
        // $max = ($max != null && $max != 0) ? $max : 0;
        $max = ($max != null) ? intval($max['code']) : 0;
        $max++;
       

        $data = [
            'ar_name' => $request->input('ar_name'),
            'en_name' => $request->input('en_name'),
            'email' => $request->input('email'),
            'code' => $max,
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'mobile1' => $request->input('mobile1'),
            'mobile2' => $request->input('mobile2'),
            'notes' => $request->input('notes'),
            'start_code' => $request->input('start_code'),

            'end_code' => $request->input('end_code'),


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
        $row = Admin_branch::where('id', '=', $id)->first();

        return view($this->viewName . 'view', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Admin_branch::where('id', '=', $id)->first();

        return view($this->viewName . 'edit', compact('row'));
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
            'ar_name' => $request->input('ar_name'),
            'en_name' => $request->input('en_name'),
            'email' => $request->input('email'),
          
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'mobile1' => $request->input('mobile1'),
            'mobile2' => $request->input('mobile2'),
            'notes' => $request->input('notes'),
            'start_code' => $request->input('start_code'),
            'end_code' => $request->input('end_code'),


        ];





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
        $row = Admin_branch::where('id', '=', $id)->first();

        try {
            $row->delete();
        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'هذا الجدول مرتبط ببيانات أخرى');
        }
        return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');
    }
    /***
     * 
     */
    public function search(Request $request)
    {
        $name= $request->input('searchData');

        $rows = Admin_branch::where('ar_name', 'like', '%' . $name . '%')->orderBy('created_at', 'Desc')->paginate(8);
         return view($this->viewName . 'index', compact('rows'));
    }
}
