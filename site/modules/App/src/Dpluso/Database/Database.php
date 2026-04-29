<?php namespace App\Dpluso\Database;
// ProcessWire
use ProcessWire\Config;
// App
use App\Util\AbstractDatabaseConnector;


class Database extends AbstractDatabaseConnector {
    const NAME_PW	  = 'dpluso';

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

        $config->dbHost = $this->config->dbHost;
        $config->dbName = $this->config->dplusdbname;
        $config->dbUser = $this->config->dbUser;
        $config->dbPass = $this->config->dbPass;
        $config->dbPort = $this->config->dbPort;
        return $config;
    }
}