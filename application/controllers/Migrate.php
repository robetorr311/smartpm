<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migrate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // authAdminAccess();

        $this->load->library('migration');
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
