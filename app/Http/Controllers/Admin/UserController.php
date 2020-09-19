<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Stock;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use File;
use DB;

class UserController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(User $object)
    {


        $this->object = $object;
        $this->viewName = 'user.';
        $this->routeName = 'users.';

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
        $rows = User::orderBy('created_at', 'Desc')->paginate(8);

        return view($this->viewName . 'index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->viewName . 'add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $max = User::latest('code')->first();

        $max = ($max != null) ? intval($max['code']) : 0;
        $max++;


        $data = [
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
            'code' => $max,
            'job' => $request->input('job'),
            'email' => $request->input('email'),
            'password' => uniqid(),
            'ar_full_name' => $request->input('ar_fullName'),
            'en_full_name' => $request->input('en_fullName'),
            'lock_date' => Carbon::create($request->input('lock_date')),


        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $data['image'] = $this->UplaodImage($image);
        }


        try {
            $user = $this->object::create($data);
        } catch (QueryException $q) {

            return redirect()->route($this->routeName . 'index')->with('flash_danger', $this->errormessage);
        }


        return redirect()->route($this->routeName . 'index')->with('flash_success', "$user->name's password has been reset successfully! Password('$user->password')");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = User::where('id', '=', $id)->first();

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
        $row = User::where('id', '=', $id)->first();

        $exception = $row->stock->pluck('stock_id')->toArray();
        $bran = $row->branch->pluck('id')->toArray();

        $stocks = Stock::whereNotIn('id', $exception)->get();
        $branches = Branch::whereNotIn('id', $bran)->get();
        return view($this->viewName . 'edit', compact('row', 'stocks', 'branches'));
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
        $user = $this->object::findOrFail($id);
        $data = [
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),

            'job' => $request->input('job'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'ar_full_name' => $request->input('ar_fullName'),
            'en_full_name' => $request->input('en_fullName'),
            'lock_date' => Carbon::create($request->input('lock_date')),


        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $data['image'] = $this->UplaodImage($image);
        }


        try {
            $user->update($data);
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
        $row = User::where('id', '=', $id)->first();
        // Delete File ..

        $file = $row->image;

        $file_name = public_path('uploads/users/' . $file);


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
        $uploadPath = public_path('uploads/users');

        // Move The image..
        $file->move($uploadPath, $imageName);

        return $imageName;
    }


    public function userSite(Request $request)
    {

        // users_stocks
        $userId = $request->input('siteUser');
        $sites = $request->input('sites');
        $row = User::where('id', '=', $userId)->first();
        if ($sites) {

            $row->branch()->sync($sites);
        } else {
            $row->branch()->detach();
        }

        return redirect()->back()->with('flash_success', 'تم التعديل بنجاح !');
    }
    public function userStock(Request $request)
    {
        // users_stocks
        $userId = $request->input('stockUser');
        $stocks = $request->input('stocks');
        $row = User::where('id', '=', $userId)->first();
        if ($stocks) {

            $row->stock()->sync($stocks);
        } else {
            $row->stock()->detach();
        }

        return redirect()->back()->with('flash_success', 'تم التعديل بنجاح !');
    }

     /***
     * 
     */
    public function search(Request $request)
    {
        $name= $request->input('searchData');
      
        $rows = User::where('name', 'like', '%' . $name . '%')->orderBy('created_at', 'Desc')->paginate(8);
        if ($request->ajax()) {
         return view($this->viewName . 'result', compact('rows'))->render();
        }else{
            return view($this->viewName . 'index', compact('rows'));
        }
    }
}
