<?php
/*
Plugin Name: Post QRCode
Plugin URI: https://github.com/satsabbir11/post-qrcode-plugin
Description: A wordpress post QR code plugin
Version: 1.0
Author: satsabbir11
Author URI: https://github.com/satsabbir11
License: GPLv2 or later
Text Domain: qrcode
Domain Path: /languages/
*/

function worcound_load_textdomain(){
    load_plugin_textdomain('qrcode',false,dirname(__FILE__)."/languages");
}

function qrcode_genarator($content){
    $post_id = get_the_ID();
    $post_url = urlencode(get_the_permalink($post_id));
    $image_alt = get_the_title($post_id);
    $current_post_type = get_post_type($post_id);
    $excluded_post_type = apply_filters("qrcode_excluded_post_type",array());
    if(in_array($current_post_type,$excluded_post_type)){
        return $content;
    }
    $dimension = apply_filters("qrcode_dimension","100x100");
    $image_attribute = apply_filters("qrcode_attribute","");
    $image_url = sprintf("https://api.qrserver.com/v1/create-qr-code/?size=%s&data=%s",$dimension,$post_url);
    $content .=sprintf("<div class='qrcode2'><img %s src='%s' alt='%s'/></div>",$image_attribute,$image_url,$image_alt);
    return $content;
}
add_filter("the_content","qrcode_genarator");

