<?php namespace App\Dpluso\Pricing;
// ProcessWire
use ProcessWire\WireData;
// App
use App\Util\SimpleArray;

class PricingRequest extends WireData {
    public function __construct() {
        $this->itemids = new SimpleArray();
        $this->custid = '';
        $this->shiptoid = '';
    }
}