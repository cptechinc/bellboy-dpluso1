<?php namespace App\Dpluso\Database;
// App
use App\Database\MeekroDB\AbstractTable;
use App\Database\MeekroDB\RecordList;

class PricingTable extends AbstractTable {
    const PW_CONNECTION_NAME = 'dpluso';
    const TABLE = 'pricing';
    const PRIMARYKEY = ['sessionid', 'recno'];
    const RECORDKEY  = ['sessionid', 'itemid'];
    const RECORD_CLASS = PricingRecord::class;

    protected static $instance;

    public function doesSessionHavePricing(string $sessionID) : bool
    {
        $tbl = self::TABLE;
        return boolval($this->db->queryFirstField("SELECT COUNT(*) FROM $tbl WHERE sessionid = %s", $sessionID));
    }

    public function findBySessionid(string $sessionID) : RecordList
    {
        $tbl = self::TABLE;
        $results = $this->db->query("SELECT * FROM $tbl WHERE sessionid = %s", $sessionID);
        $list = new RecordList();

        if (empty($results)) {
            return $list;
        }
        foreach ($results as $result) {
            $item = new PricingRecord();            
            $item->setDbArray($result);
            $list->set($item->itemid, $item);
        }
        return $list;
    }
    
}