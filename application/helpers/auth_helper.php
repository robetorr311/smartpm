<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Authenticate if current user is Admin
 */
if (!function_exists('authAdminAccess')) {
    function authAdminAccess()
    {
        authAccess('SUPER_ADMIN');
    }
}

/**
 * Authenticate if current user has access
 */
if (!function_exists('authAccess')) {
    function authAccess($level)
    {
        $CI = &get_instance();

        $userLevels = [
            'SUPER_ADMIN' => '1',
            'ADMIN' => '2',
            'MANAGER' => '3',
            'TEAM_LEADER' => '4',
            'USER' => '5',
            'NON_USER' => '6'
        ];
        // $CI->session->level == $userLevels[$level]    <<<<    LEVEL CHECK CONDITION

        if (!$CI->session->logged_in) {
            delete_cookie('tokenCookie');
            $CI->session->sess_destroy();
            redirect('/');
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
