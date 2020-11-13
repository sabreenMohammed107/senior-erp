<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Rep_type;
use App\Models\Representative;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class RepresentativeController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Representative $object)
    {

        $this->object = $object;
        $this->viewName = 'rep-persons.';
        $this->routeName = 'rep-persons.';

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
        $branches = $user->branch;
        $row = new Branch();
        $branch_id = 0;
        $representatives = Representative::where('branch_id', $branch_id)->get();

        return view($this->viewName . 'index', compact('branches', 'row', 'representatives'));
    }

    /**
     * Display a table  of the branch.
     *
     * @return \Illuminate\Http\Response
     */
    public function branchFetch(Request $request)
    {
        $branch_id = $request->input('branch_id');
        $row = Branch::where('id', $branch_id)->first();
        $representatives = Representative::where('branch_id', $branch_id)->get();

        return view($this->viewName . 'preIndex', compact('row', 'representatives'))->render();
    }

    public function creation(Request $request)
    {

        $id = $request->input('branch');

        $branch = Branch::where('id', $id)->first();
        $types=Rep_type::all();
        if (!empty($request->input('branch'))) {
            return view($this->viewName . 'add', compact('branch','types'));
        } else {
            return redirect()->route($this->routeName . 'index')->with('flash_danger', 'يجب اختيار الفرع اولا !');
        }
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
        $max = Representative::where('branch_id', $request->input('branch_id'))->where('rep_type_id',$request->input('rep_type_id'))->latest('code')->first();

        $max = ($max != null) ? intval($max['code']) : 0;
        $max++;

        $data = [
            'code' => $max,
            'ar_name' => $request->input('ar_name'),
            'en_name' => $request->input('en_name'),
            'rep_type_id'=> $request->input('rep_type_id'),
            'notes' => $request->input('notes'),
            'mobile'=>$request->input('mobile'),
            'branch_id' => $request->input('branch_id'),
        ];
      

                $stock = $this->object::create($data);
           

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
        $row = Representative::where('id', $id)->first();

        $branch = Branch::where('id', $row->branch_id)->first();
        $types=Rep_type::all();
        return view($this->viewName . 'view', compact('branch', 'types', 'row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Representative::where('id', $id)->first();

        $branch = Branch::where('id', $row->branch_id)->first();
        $types=Rep_type::all();
        return view($this->viewName . 'edit', compact('branch', 'types', 'row'));
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
            'rep_type_id'=> $request->input('rep_type_id'),
            'notes' => $request->input('notes'),
            'mobile'=>$request->input('mobile'),
           
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
        $row = Representative::where('id', $id)->first();
        // Delete File ..


        try {
           
            $row->delete();
        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'هذا الجدول مرتبط ببيانات أخرى');
        }
        return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');
  
    }
}
