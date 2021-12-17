<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{


    public function list(){
        return view('customers.list');
    }

    public function getCustomers(Request $request){

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $totalRecords = Customer::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Customer::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        $records = Customer::orderBy($columnName, $columnSortOrder)
            ->where('customers.name', 'like', '%' . $searchValue . '%')
            ->orWhere('customers.phone', 'like', '%' . $searchValue . '%')
            ->orWhere('customers.email', 'like', '%' . $searchValue . '%')
            ->select('customers.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "phone" => $record->phone,
                "email" => $record->email,
                "budget" => $record->budget,
                "message" => \mb_strimwidth($record->message, 0, 20, "..."),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

         return response()->json($response);

    }

    public function customerDetails($id){
        $customer = Customer::find($id);
        $wp_url = env('WP_URL', '');
        return view('customers.details')->with(['wp_url' => $wp_url, 'customer' => $customer]);
    }


    public function store(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'budget' => ['required', 'numeric', 'min:1'],
            'message' => ['required', 'string'],
        ]);

        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'budget' => $request->budget,
            'message' => $request->message,
        ]);

        return Redirect::route('customers.form')->with('success', 'The information has been stored!');
    }

    public function createWpAccount(Request $request){
        $request->validate([
            'id' => ['required'],
        ]);

        $id = $request->id;
        $wp_url = env('WP_URL', '');
        $customer = Customer::find($id);
        $res = ['error' => 1];

        if($customer){
            $response = Http::asForm()->post( $wp_url. '/wp-admin/admin-post.php?action=customer_ac', [
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'lara_id' => $id,
            ])->json();
            if(!empty($response)){
                $res = $response;
                if(!empty($res['account_created']) && !empty($res['user_id'])){
                    Customer::where('id', $id)->update(['wp_id' => $res['user_id']]);
                }
            }
        }
        return response()->json($res);
    }
}
