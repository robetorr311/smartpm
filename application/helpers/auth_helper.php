<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Authenticate if current user is Admin
 */
if (!function_exists('authAdminAccess')) {
    function authAdminAccess()
    {
        $CI = &get_instance();
        if (!$CI->session->userdata('admininfo')) {
            $CI->session->sess_destroy();
            delete_cookie('tokenCookie');
            redirect('/home');
            die();
        }
    }
}

/**
 * Execute logic for session timeout after some time
 */
if (!function_exists('sessionTimeout')) {
    function sessionTimeout()
    {
        $CI = &get_instance();
        $expireAfter = 30;

        //Check to see if our "last action" session
        //variable has been set.
        if (isset($_SESSION['last_action'])) {

            //Figure out how many seconds have passed
            //since the user was last active.
            $secondsInactive = time() - $_SESSION['last_action'];

            //Convert our minutes into seconds.
            $expireAfterSeconds = $expireAfter * 60;

            //Check to see if they have been inactive for too long.
            if ($secondsInactive >= $expireAfterSeconds) {
                //User has been inactive for too long.
                //Kill their session.
                $CI->session->sess_destroy();
                echo '<script type="text/javascript">';
                echo 'alert("Session Timeout!");';
                echo 'window.location.href = "' . base_url() . '";';
                echo '</script>';
                die();
            }
        }

        //Assign the current timestamp as the user's
        //latest activity
        $CI->session->set_userdata('last_action', time());
    }
}
