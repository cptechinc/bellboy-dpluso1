<?php namespace App\Dplus\Database;
// App
use App\Database\MeekroDB\AbstractTable;

class PoItemsTable extends AbstractTable {
    const PW_CONNECTION_NAME = 'dplus';
    const TABLE = 'po_detail';
    const PRIMARYKEY = ['PohdNbr', 'PodtLine'];
    const RECORDKEY  = ['PohdNbr', 'PodtLine'];
    const RECORD_CLASS = PoItemRecord::class;

    protected static $instance;


    public function fetchNextExpectedShipment(string $itemID) {
        $tbl = self::TABLE;
        $date = date('Ymd', strtotime("-6 months"));
        $result = $this->db->queryFirstRow("SELECT * FROM $tbl JOIN po_head on $tbl.PohdNbr = po_head.PohdNbr WHERE InitItemNbr = %s AND PodtExptDate >= %s AND po_head.PohdStat != 'C' ORDER BY PodtShipDate", $itemID, $date);

        if (empty($result)) {
            return false;
        }
        $item = new PoItemRecord();
        $item->setDbArray($result);
        return $item;
    }
}