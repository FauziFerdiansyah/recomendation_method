<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use DB;
use Validator;
use Yajra\Datatables\Datatables;
use App\Review;
use App\Product;
class ReviewController extends Controller
{

    public function index()
    {
        return view('pages.reviews.index');
    }

    public function create()
    {
        return view('pages.reviews.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $check = DB::table('reviews')
                    ->where('customer_id', $request->input('customer_id'))
                    ->where('product_id', $request->input('product_id'))
                    ->count();
        if($check > 0){
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('alt_red', 'Customers can only review once per product.');
        }else{
            $validation     = Validator::make($input, Review::$rules);
            if ($validation->passes()) {
                $data   = new Review;
                $data->customer_id  = $request->input('customer_id');
                $data->product_id   = $request->input('product_id');
                $data->rating       = $request->input('rating');
                $data->note         = $request->input('note');
                $data->created_by   = Auth::user()->id;
                $data->updated_by   = Auth::user()->id;
                if ($data->save()) {
                    $this->updateRating(
                        $request->input('product_id'), $request->input('rating'), 1
                    );
                    return redirect()
                        ->route('review_create')
                        ->with('alt_green', 'Data has been saved.');  
                    
                    
                }else{
                    return redirect()
                        ->route('review_create')
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

    public function edit($id)
    {
        $data = Review::findOrFail($id);
        $data   = DB::table('reviews')
                    ->select(
                        [
                            'reviews.*',
                            'customers.name as customer_name',
                            'products.name as product_name',
                            
                        ]
                    )
                    ->leftJoin('products', 'reviews.product_id', '=', 'products.id')
                    ->leftJoin('customers', 'reviews.customer_id', '=', 'customers.id')
                    ->where('reviews.id', $id)
                    ->first();
        return view('pages.reviews.edit')
            ->with(compact('data'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validation = Validator::make($request->all(), Review::rule_edit($id));
        if ($validation->passes())
        {
            $data   = Review::findOrFail($id);
            $before_rating_update = $data->rating;
            $get_rating_before_product = DB::table('products')->where('id', $request->input('product_id'))->first();
            Review::where('id', $data->id)
                ->update(
                    [
                        'customer_id'   => $request->input('customer_id'),
                        'product_id'    => $request->input('product_id'),
                        'rating'        => $request->input('rating'),
                        'note'          => $request->input('note'),
                        'updated_by'    => Auth::user()->id
                    ]);
            
            $countRatng = $get_rating_before_product->total_rating - $before_rating_update + $request->input('rating');
            $this->updateRating(
                $request->input('product_id'), $countRatng, 2
            );
            return redirect()
                ->route('review_index')
                ->with('alt_green', 'Data has been saved.');

        }else{
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validation->errors());
        }
    }

     /**
     *
     * AJAX AREA
     *
     */

    public function getDatatable()
    {
        $data   = DB::table('reviews')
                    ->select(
                        [
                            'reviews.id as data_id',
                            'customers.name as customer_name',
                            'products.name as product_name',
                            'reviews.rating',
                            'reviews.note',
                            'reviews.updated_at'
                        ]
                    )
                    ->leftJoin('products', 'reviews.product_id', '=', 'products.id')
                    ->leftJoin('customers', 'reviews.customer_id', '=', 'customers.id')
                    ->orderBy('reviews.updated_at', 'desc');
        return Datatables::of($data)
                ->addColumn('actions', function($r_data) {
                    return '
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-settings m-r-5"></i> Action
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-info" href="'.route('review_edit', $r_data->data_id).'"><span class="ti-pencil mr-2"></span> Edit</a>
                            <a class="dropdown-item text-danger" href="javascript:void(0)" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#delete_form' . $r_data->data_id . '" onclick="deleteModal(' . "'" . route('review_destroy', $r_data->data_id) . "','" . $r_data->data_id . "','" . $r_data->product_name . " Review','" . Session::token() . "'" . ')"><span class="ti-trash mr-2"></span> Delete</a>
                        </div>
                        <div id="area_modal' . $r_data->data_id . '"></div>
                    </div>
                    ';
                })
                ->edit_column('data_id', function($r_data) {
                    return "<strong>".$r_data->data_id."</strong>";
                })
                ->edit_column('rating', function($r_data) {
                    $rating = "";
                    for ($x = 1; $x <= 5; $x++) {
                        if($x > $r_data->rating){
                            $rating .= '<li class="list-inline-item"><i class="fa fa-star-o text-warning fa-lg"></i></li>';
                        }else{
                            $rating .= '<li class="list-inline-item"><i class="fa fa-star text-warning fa-lg"></i></li>';
                        }
                    }
                    return $rating;
                })
                ->edit_column('updated_at', function($r_data) {
                    return date( 'F d, Y h:i:s', strtotime( $r_data->updated_at ));
                })
                ->make(true);
    }

    public function ajaxDelete($id)
    {
        $data = Review::findOrFail($id);
        $data_rating = $data->rating;
        if($data == null) {
            return response()->json([
                'status' => false,
                'message' => 'We have no database record with that data.',
                'code' => 200,
                'success' => false
            ], 200);
        }else if(Review::destroy($id)) {
            $this->updateRating(
                $data->product_id, $data_rating, 3
            );
            return response()->json([
                'status' => true,
                'message' => "Review has been deleted.",
                'code' => 200,
                'success' => true
            ], 200);
        }else {
            return response()->json([
                'status' => false,
                'message' => 'Couldn\'t delete ' . "review" . '.',
                'code' => 200,
                'success' => false
            ], 200);

        }
    }

}
