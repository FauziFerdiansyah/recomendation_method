<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';
	protected $guarded = ['id'];
	
	public static $rules = [
		'name'	=> 'required|max:45|unique:categories,name'
	];

    public static function rule_edit($id)
    {
        return array(
            'name'	=> 'required|max:45|unique:categories,name,'.$id
        );
    }
}
