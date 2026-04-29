<?php namespace App\Dplus\Database;
// App
use App\Database\MeekroDB\Record;

class InvItemRecord extends Record {
    const COLUMN_MAP = [
        'itemid'              => 'InitItemNbr',
        'description1'        => 'InitDesc1',
        'description2'        => 'InitDesc2'
    ];
}