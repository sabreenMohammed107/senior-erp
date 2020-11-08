<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Users_branch;
use App\User;
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

    public function __construct(Branch $object)
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
        $rows = Branch::orderBy('created_at', 'Desc')->paginate(8);

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
        $max = Branch::latest('code')->first();

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

        DB::beginTransaction();

        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            //update user Branches on saving
            $branch = Branch::create($data);
            //Auth User
            $userId = User::where('id', 1)->first();
            $relate = [
                'user_id' => $userId->id,
                'branch_id' => $branch->id,

            ];
            Users_branch::create($relate);

            DB::commit();
            // Enable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
        } catch (\Exception $e) {

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
        $row = Branch::where('id', '=', $id)->first();

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
        $row = Branch::where('id', '=', $id)->first();

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



        try {
            $this->object::findOrFail($id)->update($data);
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
        $row = Branch::where('id', '=', $id)->first();

        try {
            if ($row) {
                $row->branch()->detach();
                $row->delete();
            }
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
        $name = $request->input('searchData');

        $rows = Branch::where('ar_name', 'like', '%' . $name . '%')->orderBy('created_at', 'Desc')->paginate(8);
        if ($request->ajax()) {
            return view($this->viewName . 'result', compact('rows'))->render();
        } else {
            return view($this->viewName . 'index', compact('rows'));
        }
    }
}
