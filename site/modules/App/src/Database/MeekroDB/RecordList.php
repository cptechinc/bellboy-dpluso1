<?php namespace App\Database\MeekroDB;
// ProcessWire
use ProcessWire\WireArray;

/**
 * Container for Lists of Records
 */
class RecordList extends WireArray {
    public function makeBlankItem()
    {
        return new Record();
    }
}