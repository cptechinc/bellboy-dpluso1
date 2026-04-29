<?php namespace App\Util\Files;

/**
 * Utility for fetching JSON file contents
 */
class JsonFetcher extends FileFetcher {
    protected static $instance;

    /**
     * Fetch File Contents
     * @param  string $filepath
     * @return array
     */
    public function fetch(string $filepath)
    {
        if ($this->exists($filepath) === false) {
            $this->errorMsg = 'File not found: ' . $filepath;
            return ['error' => true, 'exists' => false, 'errormsg' => "The $filepath JSON was not found", 'jsonerror' => true];
        }
        $this->convertToUtf8($filepath) ;
        $json = json_decode(file_get_contents($filepath), true);
        if (empty($json)) {
            $this->errorMsg = "The '$filepath' JSON contains errors, JSON ERROR: ". json_last_error();
            return ['error' => true, 'exists' => true, 'jsonerror' => true, 'errormsg' => "The $filepath JSON contains errors, JSON ERROR: ". json_last_error()];
        }
        $json['exists']    = true;
        $json['error']     = false;
        $json['jsonerror'] = false;
        return $json;
    }
}
