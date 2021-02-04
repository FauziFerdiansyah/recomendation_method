<?php 
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