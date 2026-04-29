<?php namespace App\Dplus\Database;
// App
use App\Database\MeekroDB\Record;

/**
 * @property InvItemRecord|null $itmitem
 * @property PoItemRecord|null  $nextShipment
 */
class SoFreqOrderedItemRecord extends Record {
    public function __construct() {
        $this->itmitem = null;
        $this->nextShipment = null;
    }

    const COLUMN_MAP = [
        'itemid'              => 'InitItemNbr',
        'lastsaleqty'         => 'FrqdLastSaleQty',
        'lastsalenbrofboxes'  => 'FrqdLastSaleBoxes',
        'lastsaleordernbr'    => 'FrqdLastSaleOrdr',
        'lastsaledate'        => 'FrqdLastSaleDate',
        'lastsaleprice'       => 'FrqdLastSalePric',
        'freqstartdate'       => 'FrqdDurationDate',
        'freqnbrofsales'      => 'FrqdDurationTimes',
        'freqqtysold'         => 'FrqdDurationQty',
        'freqnbrofboxes'      => 'FrqdDurationBoxes',
    ];
}