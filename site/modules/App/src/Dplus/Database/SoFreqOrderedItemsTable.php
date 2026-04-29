<?php namespace App\Dplus\Database;
// App
use App\Database\MeekroDB\AbstractTable;
use App\Database\MeekroDB\RecordList;

class SoFreqOrderedItemsTable extends AbstractTable {
    const PW_CONNECTION_NAME = 'dplus';
    const TABLE = 'so_freq_ordr_det';
    const PRIMARYKEY = ['ArcuCustId', 'ArstShipId', 'InitItemNbr'];
    const RECORDKEY  = ['ArcuCustId', 'ArstShipId', 'InitItemNbr'];
    const RECORD_CLASS = SoFreqOrderedItemRecord::class;

    protected static $instance;

    public function doesCustomerHaveFreqOrdered(string $custID) : bool
    {
        $tbl = self::TABLE;
        return boolval($this->db->queryFirstField("SELECT COUNT(*) FROM $tbl WHERE ArcuCustId = %s", $custID));
    }

    public function findByCustomer(string $custID) : RecordList
    {
        $tbl = self::TABLE;
        $results = $this->db->query("SELECT * FROM $tbl WHERE ArcuCustId = %s", $custID);

        $list = new RecordList();

        if (empty($results)) {
            return $list;
        }
        foreach ($results as $result) {
            $item = new SoFreqOrderedItemRecord();
            $item->setDbArray($result);
            $list->add($item);
        }
        return $list;
    }
}