<?php namespace App\ProcessWire;
// Base PHP
use PDOException;
// ProcessWire
use ProcessWire\Config;
use ProcessWire\WireData;
use ProcessWire\WireDatabasePDO;

/**
 * Wrapper class for creating a ProcessWire Database Connection
 * @property string               $wirename  Name to use to attach to wire()
 * @property Config               $dbconfig  DB Credentials
 * @property WireDatabasePDO|bool $pdo        Connection
 */
class WireDatabasePDOConnector extends WireData {
    public function __construct() {
        $this->wirename = '';
        $this->dbconfig = new Config();
        $this->pdo      = false;
    }
    
    /**
     * Set Database Credentials
     * @param  Config $config
     * @return void
     */
    public function setDbconfig(Config $config) : void
    {
        $this->dbconfig = $config;
    }

    /**
     * Establish Connection
     * @throws PDOException
     * @return bool
     */
    public function connect() : bool
    {
        if (empty($this->dbconfig)) {
            return false;
        }
        try {
            $this->pdo = WireDatabasePDO::getInstance($this->dbconfig);
        } catch (PDOException $e) {
            $this->logError($e->getMessage());
            $this->pdo = false;
            return false;
        }
        if (empty($this->wire("db-$this->wirename-pdo"))) {
            $this->wire("db-$this->wirename-pdo", $this->pdo, true);
        }
        return true;
    }

/* =============================================================
    Logging
============================================================= */
    /**
     * Writes Error Message to Database Error Log
     * @param  string $message Error Message
     * @return void
     */
    protected function logError($message) : void
    {
        $date = date("Y-m-d h:m:s");
        $message = "[{$date}] [{$this->name}] $message";
        $this->log->save('db-errors', $message);
    }
}