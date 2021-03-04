<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'products';
	protected $guarded = ['id'];
	
	public static $rules = [
        'name'	=> 'required|max:45|unique:products,name',
        'image' => 'required|mimes:jpg,jpeg,bmp,png,gif|max:1024',
        // 'category_id'  => 'required',
        'image'  => 'required',
        'price'  => 'required',
        'weight'  => 'required',
        'description'  => 'required',
	];

    public static function rule_edit($id)
    {
        return array(
            'name'	=> 'required|max:45|unique:products,name,'.$id,
            'image' => 'required|mimes:jpg,jpeg,bmp,png,gif|max:1024',
            // 'category_id'  => 'required',
            'image'  => 'required',
            'price'  => 'required',
            'weight'  => 'required',
            'description'  => 'required',
        );
    }
}
