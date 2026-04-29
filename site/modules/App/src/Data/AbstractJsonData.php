<?php namespace App\Data;
// ProcessWire
use ProcessWire\WireData;

class AbstractJsonData extends WireData {
    const FIELDS_BOOL = ['error', 'jsonerror'];
    const FIELDS_INT = [];
    const FIELDS_FLOAT = [];
    const FIELDS_STRING = ['errormsg'];
    const FIELDS_YNBOOL = [];
    const JSON_ALIASES = [];

/* =============================================================
    Constructors / Inits
============================================================= */
    public function __construct() {
        foreach (array_merge(static::FIELDS_INT, static::FIELDS_FLOAT) as $fieldname) {
            $this->$fieldname = 0;
        }
        foreach (array_merge(static::FIELDS_BOOL, static::FIELDS_YNBOOL) as $fieldname) {
            $this->$fieldname = '';
        }
        foreach (static::FIELDS_STRING as $fieldname) {
            $this->$fieldname = '';
        }
    }

/* =============================================================
    Setters
============================================================= */
    /**
     * Set Fields fom JSON array
     * @param  array $data
     * @return void
     */
    public function setFromJson(array $data) : void 
    {
        foreach (array_merge(static::FIELDS_STRING, static::FIELDS_BOOL) as $field) {
            $key = $field;
            if (array_key_exists($field, static::JSON_ALIASES)) {
                $key = static::JSON_ALIASES[$field];
            }
            $this->$field = array_key_exists($key, $data) ? stripslashes($data[$key]) : '';

            if (in_array($field, static::FIELDS_YNBOOL)) {
                $this->$field = substr(strtoupper($this->$field), 0, 1) == 'Y';
            }
        }

        foreach (static::FIELDS_INT as $field) {
            $key = $field;
            if (array_key_exists($field, static::JSON_ALIASES)) {
                $key = static::JSON_ALIASES[$field];
            }
            $this->$field = array_key_exists($key, $data) ? intval($data[$key]) : 0;
        }

        foreach (static::FIELDS_FLOAT as $field) {
            $key = $field;
            if (array_key_exists($field, static::JSON_ALIASES)) {
                $key = static::JSON_ALIASES[$field];
            }
            $this->$field = array_key_exists($key, $data) ? floatval($data[$key]) : 0;
        }
    }

/* =============================================================
    Getters
============================================================= */
    /**
     * Return Data as array
     * @return array
     */
    public function toArray() : array
    {
        return $this->data;
    }
}