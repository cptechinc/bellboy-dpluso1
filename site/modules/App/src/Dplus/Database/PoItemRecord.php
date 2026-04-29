<?php namespace App\Dplus\Database;
// App
use App\Database\MeekroDB\Record;

class PoItemRecord extends Record {
    const COLUMN_MAP = [
        'ponbr'               => 'PohdNbr',
        'linenbr'             => 'PodtLine',
        'itemid'              => 'InitItemNbr',
        'description1'        => 'PodtDesc1',
        'description2'        => 'PodtDesc2',
        'expectedDate'        => 'PodtExptDate',
        'qtyordered'          => 'PodtQtyOrd',
    ];
}