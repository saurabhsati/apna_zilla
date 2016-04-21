<?php

/*
    Usage:  get_resized_image_path('d3f5be31e24a194366da81e5ad76a8328e1159df.jpeg','/uploads/cities/',250,260);

 */
function get_resized_image_path($image_file = FALSE,$dir=FALSE,$height=250,$width=250,$fallback_text="Default Image")
{

    $CACHE_DIR = 'resize_cache/';

    $dir = rtrim($dir,"/");
    $dir = ltrim($dir,"/");
    $base_path = rtrim(base_path(),"/") ;

    $real_dir = $base_path."/public/".$dir."/";
    $extension  = get_extension($image_file);

  
    if($image_file == FALSE || $dir == FALSE)
    {
         return "https://placeholdit.imgix.net/~text?txtsize=33&txt=".$fallback_text."&w=".$width."&h=".$height;
    }

    /* Check if File Exists */
    if(!image_exists($real_dir.$image_file))
    {
        return "https://placeholdit.imgix.net/~text?txtsize=33&txt=".$fallback_text."&w=".$width."&h=".$height;
    }

    /* Check if Given file is image*/
    if(!is_valid_image($real_dir.$image_file))
    {
        return "https://placeholdit.imgix.net/~text?txtsize=33&txt=No+Image&w=".$width."&h=".$height;
    }

    /* Generate Expected Resized Image Name */
    $expected_resize_image_name = generate_resized_image_name($image_file,$width,$height,$extension);

   

    if(!image_exists($real_dir.$CACHE_DIR.$expected_resize_image_name))
    {
        /* Create Cache Dir */
        $parent_dir =  dirname($real_dir.$expected_resize_image_name);
        $resize_cache_dir  = $parent_dir."/".$CACHE_DIR;
        @mkdir($resize_cache_dir,0777);
        
        $real_path   = $real_dir.$image_file;   

        Image::make( $real_path )->resize( $width, $height )->save( $resize_cache_dir.'/'.$expected_resize_image_name ); 

    }

   
    
    return url('/')."/".$dir."/".$CACHE_DIR.$expected_resize_image_name;
}

function get_extension($image_file)
{
    $arr_part = array();
    $arr_part = explode('.', $image_file);
    return end($arr_part);
}

function is_valid_image($image_real_path)
{
    return getimagesize($image_real_path);
}

function image_exists($image_real_path)
{
    if (!file_exists($image_real_path) || !is_readable($image_real_path)) 
    {
        return FALSE;
    } 
    return TRUE;
}


function generate_resized_image_name($file_name,$width,$height,$extension)
{
    return substr($file_name, 0, strrpos($file_name, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
}

