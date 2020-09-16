<?php

namespace App\Http\Controllers;

use App\Models\Stocks;
use Illuminate\Http\Request;
use App\Models\Admin_branch;
use App\Models\Item_category;
use DB;
use App\Models\Users_branch;
use App\User;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

use Notification;
use App\Notifications\MyFirstNotification;
class StocksController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;

    public function __construct(Stocks $object)
    {

    $this->object = $object;
    $this->viewName = 'stocks.';
    $this->routeName = 'stocks.';

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
    $row = new Admin_branch();
    $branch_id = 0;
    $stocks = Stocks::where('branch_id', $branch_id)->get();

    return view($this->viewName . 'index', compact('branches', 'row', 'stocks'));
}
    
/*

*/
public function branchFetch(Request $request)
{
    $branch_id = $request->input('branch_id');
    $row = Admin_branch::where('id', $branch_id)->first();
    $stocks = Stocks::where('branch_id', $branch_id)->get();
  
    return view($this->viewName . 'preIndex', compact('row', 'stocks'))->render();
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

    public function creation(Request $request)
    {

        $id = $request->input('branch');

        $branch = DB::table('admin_branches')->where('id', $id)->first();
      
        return view($this->viewName . 'add', compact( 'branch'));
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
            'STOCK_AR_NAME' => $request->input('STOCK_AR_NAME'),
            'STOCK_EN_NAME' => $request->input('STOCK_EN_NAME'),
            'RESPONSIBLE_EMP_ID' => $request->input('RESPONSIBLE_EMP_ID'),
            'OPEN_BALANCE_DATE' =>  Carbon::parse($request->get('OPEN_BALANCE_DATE')),

            'NOTES' => $request->input('NOTES'),

            'branch_id' => $request->input('branch_id'),
        ];
            try {
                $stock = DB::table('stocks')->insertGetId($data);

                $user = User::first();
  
                $details = [
                    'greeting' => 'Hi Artisan',
                    'body' => 'This is my first notification from ItSolutionStuff.com',
                    'thanks' => 'Thank you for using ItSolutionStuff.com tuto!',
                    'actionText' => 'View My Site',
                    'actionURL' => url('/'),
                    'stock_id' => $stock
                ];
          
                Notification::send($user, new MyFirstNotification($details));
               
          
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
        $row = DB::table('stocks')->where('STOCK_ID', $id)->first();

        $branch = DB::table('admin_branches')->where('id', $row->branch_id)->first();
      
        return view($this->viewName . 'view', compact( 'branch', 'row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = DB::table('stocks')->where('STOCK_ID', $id)->first();

        $branch = DB::table('admin_branches')->where('id', $row->branch_id)->first();
      
        return view($this->viewName . 'edit', compact( 'branch', 'row'));
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
            'STOCK_AR_NAME' => $request->input('STOCK_AR_NAME'),
            'STOCK_EN_NAME' => $request->input('STOCK_EN_NAME'),
            'RESPONSIBLE_EMP_ID' => $request->input('RESPONSIBLE_EMP_ID'),
            'OPEN_BALANCE_DATE' =>  Carbon::parse($request->get('OPEN_BALANCE_DATE')),

            'NOTES' => $request->input('NOTES'),

            'branch_id' => $request->input('branch_id'),
        ];
            try {
                DB::table('stocks')->where('STOCK_ID', $id)->update($data);
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
        
        $row = DB::table('stocks')->where('STOCK_ID', $id)->first();
        // Delete File ..

      
        try {
            DB::table('stocks')->where('STOCK_ID', $id)->delete();
        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'هذا الجدول مرتبط ببيانات أخرى');
        }
        return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');
    }


    public function sendNotification()
    {
        $user = User::first();
  
        $details = [
            'greeting' => 'Hi Artisan',
            'body' => 'This is my first notification from ItSolutionStuff.com',
            'thanks' => 'Thank you for using ItSolutionStuff.com tuto!',
            'actionText' => 'View My Site',
            'actionURL' => url('/'),
            'order_id' => 101
        ];
  
        Notification::send($user, new MyFirstNotification($details));
   
        dd('done');
    }
}
