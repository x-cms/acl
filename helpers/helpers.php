<?php

if (!function_exists('get_image')) {
    function get_image($image, $default = 'admin/images/no-image.png')
    {
        if (!$image || !trim($image)) {
            return asset($default);
        }
        return asset($image);
    }
}