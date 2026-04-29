<?php namespace App\Dplus\Database;
// ProcessWire
use ProcessWire\Config;
// App
use App\Util\AbstractDatabaseConnector;


class Database extends AbstractDatabaseConnector {
    const NAME_PW	  = 'dplus';

    protected static $instance;

/* =============================================================
    DB Credentials
============================================================= */
    /**
     * Returns Config to connect to Database
     * @return Config
     */
    protected function dbconfig() : Config
    {
        $config = new Config();
        $this->config->dbDplus;

        $config->dbHost = $this->config->dbDplus->dbHost;
        $config->dbName = $this->config->dbDplus->dbName;
        $config->dbUser = $this->config->dbDplus->dbUser;
        $config->dbPass = $this->config->dbDplus->dbPass;
        $config->dbPort = $this->config->dbDplus->dbPort;
        return $config;
    }
}