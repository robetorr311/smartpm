<?php
/**
 * New Company Registration Database Management Library
 * 
 * Be carefule while using this library.
 * 
 * * This is modifying CodeIgniter's default $this->db variable value
 * * to change selected database and perform migration
 * 
 * This is used to create database after new agency register and perform
 * migration on that database which creates a blank database.
 */
defined('BASEPATH') or exit('No direct script access allowed');

class New_company
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function createDB($database)
    {
        $this->CI->db->query('create database ' . $database);

        $this->CI->db = $this->CI->load->database([
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
        ], true);

        $this->CI->load->library('migration');

        return ($this->CI->migration->latest() !== FALSE);
    }

    public function dropDB($database)
    {
        $this->CI->db->query('drop database if exists ' . $database);
    }
}
