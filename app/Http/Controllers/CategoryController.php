<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use DB;
use Validator;
use Yajra\Datatables\Datatables;
use App\Category;
class CategoryController extends Controller
{

    public function index()
    {
        return view('pages.categories.index');
    }

    public function create()
    {
        return view('pages.categories.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validation     = Validator::make($input, Category::$rules);
        if ($validation->passes()) {
            $data   = new Category;
            $data->name   = $request->input('name');
            $data->created_by   = Auth::user()->id;
            $data->updated_by   = Auth::user()->id;
            if ($data->save()) {
                return redirect()
                    ->route('category_create')
                    ->with('alt_green', 'Data has been saved.');
            }else{
                return redirect()
                    ->route('category_create')
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
        $data = Category::findOrFail($id);
        return view('pages.categories.edit')
            ->with(compact('data'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validation = Validator::make($request->all(), Category::rule_edit($id));
        if ($validation->passes())
        {
            $data   = Category::findOrFail($id);
            Category::where('id', $data->id)
                ->update(
                    [
                        'name'    => $request->input('name'),
                        'updated_by'    => Auth::user()->id
                    ]);
            return redirect()
                ->route('category_index')
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
        $data   = DB::table('categories')
                    ->select(
                        [
                            'id as data_id',
                            'name',
                            'updated_at'
                        ]
                    );
        return Datatables::of($data)
                ->addColumn('actions', function($r_data) {
                    return '
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-settings m-r-5"></i> Action
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-info" href="'.route('category_edit', $r_data->data_id).'"><span class="ti-pencil mr-2"></span> Edit</a>
                            <a class="dropdown-item text-danger" href="javascript:void(0)" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#delete_form' . $r_data->data_id . '" onclick="deleteModal(' . "'" . route('category_destroy', $r_data->data_id) . "','" . $r_data->data_id . "','" . $r_data->name . "','" . Session::token() . "'" . ')"><span class="ti-trash mr-2"></span> Delete</a>
                        </div>
                        <div id="area_modal' . $r_data->data_id . '"></div>
                    </div>
                    ';
                })
                ->edit_column('data_id', function($r_data) {
                    return "<strong>".$r_data->data_id."</strong>";
                })
                ->edit_column('updated_at', function($r_data) {
                    return date( 'F d, Y h:i:s', strtotime( $r_data->updated_at ));
                })

                ->make(true);
    }

    public function ajaxDelete($id)
    {
        $data = Category::findOrFail($id);
        if($data == null) {
            return response()->json([
                'status' => false,
                'message' => 'We have no database record with that data.',
                'code' => 200,
                'success' => false
            ], 200);
        }else if(Category::destroy($id)) {
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

}
