<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Auth;
use Session;
use DB;
use App\User;
use Validator;
use Yajra\Datatables\Datatables;

class UsersController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('pages.users.index');
    }

    public function create()
    {
        return view('pages.users.create');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validation     = Validator::make($input, User::$rules);
        if ($validation->passes()) {

            $data   = new User;
            $data->name          = $request->input('name');
            $data->email         = $request->input('email');
            $data->password      = Hash::make($request->input('password'));
            $data->status        = $request->input('status');
            $data->created_by    = Auth::user()->id;
            $data->updated_by    = Auth::user()->id;

            if ($data->save()) {
                return redirect()
                    ->route('user_create')
                    ->with('alt_green', 'Data has been saved.');
            }else{
                return redirect()
                    ->route('user_create')
                    ->withInput()
                    ->withErrors($validation);
            }
            
        }else{
            return redirect()
                ->route('user_create')
                ->withInput()
                ->withErrors($validation);
        }

    }

    public function edit($id)
    {
        $data           = User::findOrFail($id);
        return view('pages.users.edit')->with(compact('data'));
    }

    public function update(Request $request, $id) {
        $input = $request->all();

        $validation = Validator::make($request->all(), User::rule_edit($id));
        if ($validation->passes())
        {
            $data   = User::findOrFail($id);
            if(empty($request->input('status'))){
                $status_active = 1;
            }else{
                $status_active = 2;
            }
            User::where('id', $data->id)
                ->update(
                    [
                        'name'          => $request->input('name'),
                        'email'         => $request->input('email'),
                        'status'        => $status_active,
                        'updated_by'    => Auth::user()->id
                    ]);
            return redirect()
                ->route('user_index')
                ->with('alt_green', 'Data has been saved.');

        }else{
            return redirect()
                ->route('user_edit', ['id' => $id])
                ->withInput()
                ->withErrors($validation);
        }



    }

    public function password(Request $request)
    {
        if($request->isMethod('post'))
        {
            $id     = Auth::user()->id;
            $rules = array(
                'current_password'      => 'required',
                'password'              => 'required|min:5|confirmed|different:current_password',
                'password_confirmation' => 'required|required_with:password'
            );
            $validation = Validator::make($request->all(), $rules);
            if ($validation->passes())
            {
                if(Hash::check($request->input('current_password'), Auth::user()->password))
                {

                    $data   = User::findOrFail($id);
                    User::where('id', $id)
                        ->update(
                            [
                                'password'      => bcrypt($request->input('password')),
                                'updated_by'    => Auth::user()->id
                            ]);
                    return redirect()
                        ->route('users.password')
                        ->with('alt_green', 'Data has been saved.');
                }else{
                    return redirect()
                        ->route('users.password')
                        ->with('alt_red', 'Current password not match.');
                }


            }else{
                return redirect()
                    ->route('users.password')
                    ->withInput()
                    ->withErrors($validation);
            }
        }
        return view('admin.pages.users.password');
    }

    public function change_password($id)
    {
        $data           = User::findOrFail($id);
        return view('pages.users.change_password')->with(compact('data'));
    }
    public function update_password(Request $request, $id)
    {
        if($request->isMethod('post'))
        {

            $rules = array(
                'current_password'      => 'required',
                'password'              => 'required|min:5|confirmed|different:current_password',
                'password_confirmation' => 'required|required_with:password'
            );
            $validation = Validator::make($request->all(), $rules);
            if ($validation->passes())
            {
                if(Hash::check($request->input('current_password'), Auth::user()->password))
                {

                    $data   = User::findOrFail($id);
                    User::where('id', $id)
                        ->update(
                            [
                                'password'      => bcrypt($request->input('password')),
                                'updated_by'    => Auth::user()->id
                            ]);
                    return redirect()
                        ->route('user_index')
                        ->with('alt_green', 'Data has been saved.');
                }else{
                    return redirect()
                        ->route('user_change_password', ['id' => $id])
                        ->with('alt_red', 'Current password not match.');
                }


            }else{
                return redirect()
                    ->route('user_change_password', ['id' => $id])
                    ->withInput()
                    ->withErrors($validation);
            }
        }
        return view('admin.pages.users.user_index');
    }


    /**
     *
     * AJAX AREA
     *
     */

    public function getDatatable()
    {
        $get_data   = DB::table('users')
                        ->select(
                            [
                                'users.id as data_id',
                                'users.name as user_name',
                                'users.email',
                                'users.status',
                                'users.updated_at'
                            ]
                        );
                        //->where('users.status', 2);
                        //->where('users.id', '!=', Auth::user()->id);
        return Datatables::of($get_data)
                ->addColumn('actions', function($r_data) {
                    return '
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-settings m-r-5"></i> Action
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-info" href="'.route('user_edit', $r_data->data_id).'"><span class="ti-pencil mr-2"></span> Edit</a>
                            <a class="dropdown-item text-danger" href="javascript:void(0)" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#delete_form' . $r_data->data_id . '" onclick="deleteModal(' . "'" . route('user_destroy', $r_data->data_id) . "','" . $r_data->data_id . "','" . $r_data->user_name . "','" . Session::token() . "'" . ')"><span class="ti-trash mr-2"></span> Delete</a> 
                            <a class="dropdown-item text-secondary" href="'.route('user_change_password', $r_data->data_id).'"><span class="ti-lock mr-2"></span> Edit Password</a>
                        </div>
                        <div id="area_modal' . $r_data->data_id . '"></div>
                    </div>
                    ';
                })
                ->edit_column('data_id', function($r_data) {
                    return "<strong>".$r_data->data_id."</strong>";
                })
                ->edit_column('status', function($r_data)
                {
                     return status($r_data->status);
                })
                ->edit_column('updated_at', function($r_data) {
                    return date( 'F d, Y h:i:s', strtotime( $r_data->updated_at ));
                })

                ->make(true);

    }

    public function ajaxDelete($id)
    {
        $data = User::findOrFail($id);
        if($data == null) {
            return response()->json([
                'status' => false,
                'message' => 'We have no database record with that data.',
                'code' => 200,
                'success' => false
            ], 200);
        }else if(User::destroy($id)) {
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
