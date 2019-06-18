<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Change default database to company database
 */
if (!function_exists('dbSelect')) {
    function dbSelect($database = null)
    {
        $CI = &get_instance();
        $database = $database ?? $CI->session->database;

        if ($database) {
            try {
                $CI->db = $CI->load->database([
                    'dsn'	=> '',
                    'hostname' => 'localhost',
                    'username' => 'root',  
                    'password' => '',
                    'database' => $database,
                    'dbdriver' => 'mysqli',
                    'dbprefix' => '',
                    'pconnect' => FALSE,
                    'db_debug' => (ENVIRONMENT !== 'production'),
                    'cache_on' => FALSE,
                    'cachedir' => '',
                    'char_set' => 'utf8',
                    'dbcollat' => 'utf8_general_ci',
                    'swap_pre' => '',
                    'encrypt' => FALSE,
                    'compress' => FALSE,
                    'stricton' => FALSE,
                    'failover' => array(),
                    'save_queries' => TRUE
                ], TRUE);
            } catch (T_STRING $e) {
                verifyDB($database);
            }
        }
    }
}
