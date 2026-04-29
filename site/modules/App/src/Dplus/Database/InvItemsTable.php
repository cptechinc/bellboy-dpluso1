<?php namespace App\Dplus\Database;
// App
use App\Database\MeekroDB\AbstractTable;

class InvItemsTable extends AbstractTable {
    const PW_CONNECTION_NAME = 'dplus';
    const TABLE = 'inv_item_mast';
    const PRIMARYKEY = ['InitItemNbr'];
    const RECORDKEY  = ['InitItemNbr'];
    const RECORD_CLASS = InvItemRecord::class;

    protected static $instance;

    public function description1(string $itemID) : string
    {
        $tbl = self::TABLE;
        return $this->db->queryFirstField("SELECT InitDesc1 FROM $tbl WHERE InitItemNbr = %s", $itemID);
    }

    public function fetch(string $itemID) {
        $tbl = self::TABLE;
        $result = $this->db->queryFirstRow("SELECT * FROM $tbl WHERE InitItemNbr = %s", $itemID);

        if (empty($result)) {
            return false;
        }
        $item = new InvItemRecord();
        $item->setDbArray($result);
        return $item;
    }
}