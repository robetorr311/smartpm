<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Authenticate if current user has access
 */
if (!function_exists('authAccess')) {
    function authAccess($levels = [])
    {
        $CI = &get_instance();

        if (!$CI->session->logged_in) {
            delete_cookie('tokenCookie');
            $CI->session->sess_destroy();
            redirect('/');
            die();
        } else if (count($levels) > 0 && !in_array($CI->session->level, $levels)) {
            show_404();
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

/**
 * Check if database exist or display error page
 */
if (!function_exists('verifyDB')) {
    function verifyDB($database, $return = FALSE)
    {
        $CI = &get_instance();

        $CI->db->select('SCHEMA_NAME');
        $CI->db->where('SCHEMA_NAME', $database);
        $CI->db->from('INFORMATION_SCHEMA.SCHEMATA');
        $result = $CI->db->count_all_results();

        if ($return) {
            return ($result > 0);
        } else if ($result <= 0) {
            $CI->session->sess_destroy();
            redirect('/');
        }
    }
}
