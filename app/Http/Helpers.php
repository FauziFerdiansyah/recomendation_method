<?php 
function rupiah_format($amount) {
	$convert = 'Rp. '.number_format($amount, 0, '', '.'). ',-';
	return $convert;
}
function weight_format($weight) {
	$convert = round($weight, 0);
	return $convert;
}
function status($code)
{
    if($code == 1)
    {
        $output     = '<span class="badge badge-danger">Inactive</span>';
    }else{
        $output     = '<span class="badge badge-success">Active</span>';
    }
    return $output;
}
?>