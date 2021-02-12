<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $table = 'customers';
	protected $guarded = ['id'];
	
	public static $rules = [
        'name'	=> 'required|max:45|unique:customers,name',
        'email' => 'required|email|unique:customers,email',
        'phone' => 'required',
        'gender' => 'required',
	];

    public static function rule_edit($id)
    {
        return array(
            'name'	=> 'required|max:45|unique:customers,name,'.$id,
            'phone' => 'required',
            'gender' => 'required',
        );
    }
}
