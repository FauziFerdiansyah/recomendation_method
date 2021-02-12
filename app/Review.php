<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	protected $table = 'reviews';
	protected $guarded = ['id'];
	
	public static $rules = [
		'customer_id'  => 'required',
		'product_id'  => 'required',
		'rating'  => 'required|numeric|min:0|not_in:0',
	];

    public static function rule_edit($id)
    {
        return array(
            'customer_id'  => 'required',
			'product_id'  => 'required',
			'rating'  => 'required|numeric|min:0|not_in:0',
        );
    }
}
