<?php namespace App\Dpluso\Pricing;
// Dplus 
use App\Dplus\Abstracts\AbstractDplusRequests;

class Requests extends AbstractDplusRequests {
    public function multipleItemPrices(PricingRequest $rqst) : bool
    {
        $data = ['ITMPRIMULT', "CUSTID=$rqst->custid"];
        foreach ($rqst->itemids as $itemID) {
            $data[] = "ITEMID=$itemID";
        }
        return $this->sendRequest($data, static::DEFAULT_CGI_KEY);
    }
}