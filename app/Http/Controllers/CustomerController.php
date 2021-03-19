<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use DB;
use Validator;
use Yajra\Datatables\Datatables;
use App\Customer;
use App\Product;
use App\Review;
class CustomerController extends Controller
{

    public function index()
    {
        return view('pages.customers.index');
    }

    public function create()
    {
        return view('pages.customers.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validation     = Validator::make($input, Customer::$rules);
        if ($validation->passes()) {
            $data   = new Customer;
            $data->name         = $request->input('name');
            $data->email        = $request->input('email');
            $data->gender       = $request->input('gender');
            $data->phone        = $request->input('phone');

            if ($data->save()) {
                return redirect()
                    ->route('customer_create')
                    ->with('alt_green', 'Data has been saved.');
            }else{
                return redirect()
                    ->route('customer_create')
                    ->withInput()
                    ->withErrors($validation->errors());
            }            
        }else{
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validation->errors());
        }
    }

    public function edit($id)
    {
        $data = Customer::findOrFail($id);
        return view('pages.customers.edit')
            ->with(compact('data'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validation = Validator::make($request->all(), Customer::rule_edit($id));
        if ($validation->passes())
        {
            $data   = Customer::findOrFail($id);
            Customer::where('id', $data->id)
                ->update(
                    [
                        'name'    => $request->input('name'),
                        'email'    => $request->input('email'),
                        'gender'    => $request->input('gender'),
                        'phone'    => $request->input('phone')
                    ]);
            return redirect()
                ->route('customer_index')
                ->with('alt_green', 'Data has been saved.');

        }else{
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validation->errors());
        }
    }

    private function updateRating($id_product, $rating, $type) {
        $get_review_count = DB::table('reviews')->where('product_id', $id_product)->count();

        $getCountVote = ($get_review_count > 0)? $get_review_count : 0;
        $get_product = DB::table('products')
                ->where('id', $id_product)->first();
        if($type == 1){ // Add
            Product::where('id', $id_product)
            ->update(
                [
                    'total_vote'    => ($getCountVote),
                    'total_rating'  => ($get_product->total_rating + $rating)
                ]);
        }elseif($type == 2){ // Edit
            Product::where('id', $id_product)
            ->update(
                [
                    'total_vote'    => ($getCountVote),
                    'total_rating'  => ($rating)
                ]);
        }else{
            Product::where('id', $id_product)
            ->update(
                [
                    'total_vote'    => ($getCountVote),
                    'total_rating'  => ($get_product->total_rating - $rating)
                ]);
        }
    }

     /**
     *
     * AJAX AREA
     *
     */

    public function getDatatable()
    {
        $data   = DB::table('customers')
                    ->select(
                        [
                            'id as data_id',
                            'name',
                            'email',
                            'phone',
                            'gender',
                            'updated_at'
                        ]
                    )->orderBy('updated_at', 'desc');
        return Datatables::of($data)
                ->addColumn('actions', function($r_data) {
                    return '
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-settings m-r-5"></i> Action
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-info" href="'.route('customer_edit', $r_data->data_id).'"><span class="ti-pencil mr-2"></span> Edit</a>
                            <a class="dropdown-item text-danger" href="javascript:void(0)" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#delete_form' . $r_data->data_id . '" onclick="deleteModal(' . "'" . route('customer_destroy', $r_data->data_id) . "','" . $r_data->data_id . "','" . $r_data->name . "','" . Session::token() . "'" . ')"><span class="ti-trash mr-2"></span> Delete</a>
                        </div>
                        <div id="area_modal' . $r_data->data_id . '"></div>
                    </div>
                    ';
                })
                ->edit_column('data_id', function($r_data) {
                    return "<strong>".$r_data->data_id."</strong>";
                })
                ->edit_column('gender', function($r_data) {
                    return ($r_data->gender == 1)? "<strong>Male</strong>" : "<strong>Female</strong>";
                })
                ->edit_column('updated_at', function($r_data) {
                    return date( 'F d, Y h:i:s', strtotime( $r_data->updated_at ));
                })

                ->make(true);
    }

    public function ajaxDelete($id)
    {
        $idCst = $id;
        $data = Customer::findOrFail($id);
        if($data == null) {
            return response()->json([
                'status' => false,
                'message' => 'We have no database record with that data.',
                'code' => 200,
                'success' => false
            ], 200);
        }else if(Customer::destroy($idCst)) {
            $ReviewBySuctomer = Review::where('reviews.customer_id', $idCst)
            ->select('reviews.product_id', 'reviews.rating')
            ->get();
            foreach ($ReviewBySuctomer as $key => $v) {
                $RemoveCustomerRating = Review::where('customer_id', $idCst)->delete();
                $this->updateRating(
                    $v->product_id, $v->rating, 3
                );
                
            }
          return response()->json([
                'status' => true,
                'message' => "<b>".$data->name."</b>" . " has been deleted.",
                'code' => 200,
                'success' => true
            ], 200);
        }else {
            return response()->json([
                'status' => false,
                'message' => 'Couldn\'t delete ' . $data->name . '.',
                'code' => 200,
                'success' => false
            ], 200);

        }
    }

    // Ajax Search Customer Select 2
    public function ajaxSearchCustomer(Request $request)
    {

        $search = $request->input('key.term');
        $cust = Customer::where('customers.name', 'LIKE','%'.$search.'%')

        ->select('customers.id','customers.name')
        ->orderBy('customers.name', 'asc')
        ->limit(6)
        ->get();

        $array_data_json = [];
        foreach ($cust as $key => $r) {
            $array_data_json[] = [          
                                    'value' => $r->id,
                                    'name' => $r->name
                                ];
        }
        return response()
        ->json($array_data_json);
    }

}
