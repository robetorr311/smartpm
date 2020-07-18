<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Format Mobile Number
 */
if (!function_exists('formatPhoneNumber')) {
    function formatPhoneNumber($phone)
    {
        if (is_numeric($phone) && strlen($phone) >= 10) {
            $output = substr($phone, -10, -7) . "." . substr($phone, -7, -4) . "." . substr($phone, -4); 
            return $output;
        }
        return $phone;
    }
}