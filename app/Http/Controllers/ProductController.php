<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use DB;
use Validator;
use Yajra\Datatables\Datatables;
use App\Product;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
class ProductController extends Controller
{

    public function index()
    {
        return view('pages.products.index');
    }

    public function create()
    {
        // $list_category      = DB::table('categories')->pluck('name', 'id'); 
        // return view('pages.products.create')->with(compact('list_category'));
        return view('pages.products.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validation     = Validator::make($input, Product::$rules);
        if ($validation->passes()) {
            $allowed_filename = null;
            if ($request->file('image') != null) {
                $path   = 'img/products/';  // set images data
                $image          = $request->file('image'); // get images data
                $originalName   = $image->getClientOriginalName();
                $extension      = $image->getClientOriginalExtension();
                $allowed_filename = str_slug($request->input('name'), '-') .'-'.date('ymdhis').'.'.$image->getClientOriginalExtension();

                $manager = new ImageManager();
                $manager->make($image)->save($path.$allowed_filename); // upload original image
            }

            $data   = new Product;
            $data->name         = $request->input('name');
            // $data->category_id  = $request->input('category_id');
            $data->price        = $request->input('price');
            $data->weight       = $request->input('weight');
            $data->description  = $request->input('description');
            $data->image        = $allowed_filename;
            $data->created_by   = Auth::user()->id;
            $data->updated_by   = Auth::user()->id;
            if ($data->save()) {
                return redirect()
                    ->route('product_create')
                    ->with('alt_green', 'Data has been saved.');
            }else{
                return redirect()
                    ->route('product_create')
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
        $data = Product::findOrFail($id);
        // $list_category     = DB::table('categories')->pluck('name', 'id');  
        // return view('pages.products.edit')
        //     ->with(compact('data', 'list_category'));
        return view('pages.products.edit')
            ->with(compact('data'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validation = Validator::make($request->all(), Product::rule_edit($id));
        if ($validation->passes())
        {
            $data   = Product::findOrFail($id);
            $allowed_filename = $data->image;
            if ($request->file('image') != null) {
                $path           = 'img/products/';
                $full_path1 = $path . $data->picture;
                if ( File::exists( $full_path1 ) ) {
                    File::delete( $full_path1 );
                }
                $image          = $request->file('image'); // set images data
                $originalName   = $image->getClientOriginalName(); // get images data
                $extension      = $image->getClientOriginalExtension();
                $allowed_filename = str_slug($request->input('name'), '-') .'-'.date('ymdhis').'.'.$image->getClientOriginalExtension();
        
                $manager = new ImageManager();
                $manager->make($image)->save($path.$allowed_filename); // upload original image
            }

            Product::where('id', $data->id)
                ->update(
                    [
                        'name'          => $request->input('name'),
                        // 'category_id'   => $request->input('category_id'),
                        'price'         => $request->input('price'),
                        'weight'        => $request->input('weight'),
                        'image'         => $allowed_filename,
                        'description'   => $request->input('description'),
                        'updated_by'    => Auth::user()->id
                    ]);
            return redirect()
                ->route('product_index')
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
        $data   = DB::table('products')
                    ->select(
                        [
                            'products.id as data_id',
                            'products.name as product_name',
                            // 'categories.name as category',
                            'products.image',
                            'products.price',
                            'products.weight',
                            'products.total_rating',
                            'products.total_vote',
                            'products.updated_at'
                        ]
                    )
                    // ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                    ->orderBy('updated_at', 'desc');
        return Datatables::of($data)
                ->addColumn('actions', function($r_data) {
                    return '
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-settings m-r-5"></i> Action
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-info" href="'.route('product_edit', $r_data->data_id).'"><span class="ti-pencil mr-2"></span> Edit</a>
                            <a class="dropdown-item text-danger" href="javascript:void(0)" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#delete_form' . $r_data->data_id . '" onclick="deleteModal(' . "'" . route('product_destroy', $r_data->data_id) . "','" . $r_data->data_id . "','" . $r_data->image . "','" . Session::token() . "'" . ')"><span class="ti-trash mr-2"></span> Delete</a>
                        </div>
                        <div id="area_modal' . $r_data->data_id . '"></div>
                    </div>
                    ';
                })
                ->edit_column('data_id', function($r_data) {
                    return "<strong>".$r_data->data_id."</strong>";
                })
                ->edit_column('price', function($r_data) {
                    return "
                        <dl class='row'>
                            ".
                            //<dt class='col-sm-5'>Category :</dt>
                            ''//<dd class='col-sm-7'>".$r_data->category."</dd>
                            ."
                            <dt class='col-sm-5'>Price :</dt>
                            <dd class='col-sm-7'>".rupiah_format($r_data->price)."</dd>
                            <dt class='col-sm-5'>Weight :</dt>
                            <dd class='col-sm-7'>".weight_format($r_data->weight)." Gram</dd>
                        </dl>
                    ";
                })
                ->edit_column('image', function($r_data) {
                    $roundRating = ($r_data->total_rating != 0)?round($r_data->total_rating / $r_data->total_vote):0;
                    $rating = "";
                    for ($x = 1; $x <= 5; $x++) {
                        if($x > $roundRating){
                            $rating .= '<li class="list-inline-item mr-1"><i class="fa fa-star-o text-warning"></i></li>';
                        }else{
                            $rating .= '<li class="list-inline-item mr-1"><i class="fa fa-star text-warning"></i></li>';
                        }
                    }
                    return "<img src='".asset('/img/products/'.$r_data->image)."' class='img rounded mx-auto d-block' width='100%' alt='".$r_data->product_name."'>
                    <div class='mx-auto d-block mt-2 text-center'>".$rating." <small>(".number_format_short($r_data->total_vote).")</small>"."</div>";
                })
                ->edit_column('updated_at', function($r_data) {
                    return date( 'F d, Y h:i:s', strtotime( $r_data->updated_at ));
                })

                ->make(true);
    }

    public function ajaxDelete($id)
    {
        $data = Product::findOrFail($id);
        if($data == null) {
            return response()->json([
                'status' => false,
                'message' => 'We have no database record with that data.',
                'code' => 200,
                'success' => false
            ], 200);
        }else if(Product::destroy($id)) {
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

    // Ajax Search Product Select 2
    public function ajaxSearchProduct(Request $request)
    {

        $search = $request->input('key.term');
        $cust = Product::where('products.name', 'LIKE','%'.$search.'%')

        ->select('products.id','products.name')
        ->orderBy('products.name', 'asc')
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
