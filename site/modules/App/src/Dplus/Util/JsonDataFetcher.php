<?php namespace App\Dplus\Util;
// ProcessWire
use ProcessWire\WireData;
// App
use App\Util\Files\JsonFetcher;

class JsonDataFetcher extends WireData {
    private static $instance;

    public static function instance() : JsonDataFetcher
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->errorMsg = '';
        $this->dir      = rtrim($this->config->jsonfilepath, '/') . '/';
        $this->fetcher  = JsonFetcher::instance();
    }

    public function exists($filename) : bool
    {
        return $this->fetcher->exists($this->filepath($filename));
    }

    public function modified($filename) : int
    {
        return $this->fetcher->modified($this->filepath($filename));
    }

    public function delete($filename) : bool
    {
        return $this->fetcher->delete($this->filepath($filename));
    }

    public function fetch($filename) : array
    {
        $this->errorMsg = '';
        $json = $this->fetcher->fetch($this->filepath($filename));

        if ($json['jsonerror']) {
            $this->errorMsg = $json['errormsg'];
        }
        return $json;
    }

    public function filepath($filename) : string
    {
        $filename = preg_replace('/\.\w+$/', '', $filename);
		$filename .= '.json';
        return $this->dir . $filename;
    }

}