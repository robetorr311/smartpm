<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_migrate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // authAdminAccess();

        $this->db = $this->load->database([
            'dsn' => '',
            'hostname' => $this->db->hostname,
            'username' => $this->db->username,  
            'password' => $this->db->password,
            'database' => 'smartpm_master',
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

        $this->load->library('migration');
        $this->migration = new CI_Migration([
            'migration_enabled' => TRUE,
            'migration_path' => APPPATH . 'master_migrations/',
            'migration_type' => 'timestamp'
        ]);
    }

    public function index()
    {
        echo 'Migration Module';
    }

    public function do_migration($version = null)
    {
        if (isset($version) && $this->migration->version($version) === FALSE) {
            show_error($this->migration->error_string());
        } elseif (is_null($version) && $this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo 'Migration Successfull to ' . (is_null($version) ? 'latest' : $version) . '.';
        }
    }

    public function undo_migration($version = null)
    {
        $migrations = $this->migration->find_migrations();
        $migration_keys = array_keys($migrations);
        if (isset($version) && array_key_exists($version, $migrations) && $this->migration->version($version)) {
            echo 'The migration was reset to the version: ' . $version;
            exit;
        } elseif (isset($version) && !array_key_exists($version, $migrations)) {
            echo 'The migration with version number ' . $version . ' doesn\'t exist.';
        } else {
            $penultimate = (sizeof($migration_keys) < 2) ? 0 : $migration_keys[sizeof($migration_keys) - 2];
            if ($this->migration->version($penultimate)) {
                echo 'The migration has been rolled back successfully.';
                exit;
            } else {
                echo 'Couldn\'t roll back the migration.';
                exit;
            }
        }
    }

    public function reset_migration()
    {
        if ($this->migration->current() !== FALSE) {
            echo 'The migration was reset to the version set in the config file.';
            exit;
        } else {
            echo 'Couldn\'t reset migration.';
            show_error($this->migration->error_string());
            exit;
        }
    }
}
