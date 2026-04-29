<?php namespace App\Util;
// Meekro
use MeekroDB;
// ProcessWire
use ProcessWire\Config;
use ProcessWire\WireData;
// Pauldro ProcessWire
use App\ProcessWire\WireDatabasePDOConnector;

/**
 * Service for Connecting MySQL database with ProcessWire / Propel ORM
 * 
 * @property Config                    $dbconfig
 * @property WireDatabasePDOConnector  $pw
 */
abstract class AbstractDatabaseConnector extends WireData {
    const NAME_PW	  = '';

    protected static $instance;

    public static function instance() {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function __construct() {
        $this->dbconfig = $this->dbconfig();
        $this->pw       = new WireDatabasePDOConnector();
    }

/* =============================================================
    DB Credentials
============================================================= */
    /**
     * Returns Config to connect to Database
     * @return Config
     */
    abstract protected function dbconfig();

/* =============================================================
    DB Connect
============================================================= */
    public function connect() : bool
    {
        if ($this->connectProcessWire() === false) {
            return false;
        }
        $this->connectMeekroDb();
        $this->wire('db-' . static::NAME_PW, $this, true);
        return true;
    }

    /**
     * Return if Connection was made via ProcessWire
     * @return bool
     */
    public function connectProcessWire() {
        $this->pw->wirename = static::NAME_PW;
        $this->pw->setDbconfig($this->dbconfig);
        return $this->pw->connect();
    }

    public function connectMeekroDb() : bool
    {
        $this->meekrodb = new MeekroDB($this->generateDsn(), $this->dbconfig->dbUser, $this->dbconfig->dbPass);
        $this->meekrodb->logfile = '/tmp/' . static::NAME_PW . '-sql.log';
        $this->wire('db-' . static::NAME_PW . '-meekrodb' , $this->meekrodb, true);
        return true;
    }

/* =============================================================
    Database Accessors
============================================================= */

/* =============================================================
    Logging
============================================================= */
    /**
     * Writes Error Message to Database Error Log
     * @param  string $message Error Message
     * @return void
     */
    public function logError($message) {
        $date = date("Y-m-d h:m:s");
        $class = static::NAME_PW;
        $message = "[{$date}] [{$class}] $message";
        $this->log->save('db-errors', $message);
    }

    /**
	 * Return DSN from DB Creds
	 */
	protected function generateDsn() : string
    {
        $host = $this->dbconfig->dbHost;
		$name = $this->dbconfig->dbName;
		$port = $this->dbconfig->dbPort;
		return "mysql:host=$host;port=$port;dbname=$name";
	}
}