<?php namespace App\Dplus\Util;
// ProcessWire
use ProcessWire\WireData;
use ProcessWire\WireHttp;

/**
 * Sends CGI Requests
 */
class SessionCgiRequest extends WireData {
    protected static $instance;

    public static function instance() : SessionCgiRequest
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    /**
     * Sends HTTP GET Request to CGI BIN file
     * @param  string $cgi       CGI BIN filename
     * @param  string $sessionID SessionID for CGI Request
     * @return bool
     */
    public function send($cgi, $sessionID) {
        $http = new WireHttp();
        return $http->get("127.0.0.1/cgi-bin/$cgi?fname=$sessionID");
    }

    /**
     * Writes an array one datem per line into the dplus directory
     * @param  array  $data      Array of Lines for the request
     * @param  string $sessionID
     * @return bool
     */
    function writeFile($data, $sessionID) : bool
    {
        $content = implode("\n", $data);
        $filename = "/usr/capsys/ecomm/" . $sessionID;
        return boolval(file_put_contents($filename, $content));
    }
}