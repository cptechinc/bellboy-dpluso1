<?php namespace App\Dplus\Abstracts;
// ProcessWire
use ProcessWire\WireData;
// Dplus
use App\Dplus\Util\SessionCgiRequest as CgiRequest;

/**
 * 
 * Sends CGI requests to for COBOL Execution
 */
abstract class AbstractDplusRequests extends WireData {
    const DEFAULT_CGI_KEY = 'default';
    
/* =============================================================
    CRUD Request Sending
============================================================= */
    protected function sendRequest($data = [], $cgiKey = '') {
        if (empty($data)) {
            return true;
        }
        $dplusdb = $this->config->dplusdbname;
        $data = array_merge(["DBNAME=$dplusdb"], $data);
        CgiRequest::instance()->writeFile($data, session_id());
        return CgiRequest::instance()->send($this->getRequestCgiName($cgiKey), session_id());
    }

    /**
     * Return CGI Script Name to make request to
     * @return string
     */
    protected function getRequestCgiName($key = '') {
        $key = $key ? $key : static::DEFAULT_CGI_KEY;
        return $this->config->cgis[$key];
    }
}