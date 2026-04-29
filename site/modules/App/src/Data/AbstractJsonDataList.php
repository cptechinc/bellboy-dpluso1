<?php namespace App\Data;
// ProcessWire
use ProcessWire\WireArray;


class AbstractJsonDataList extends WireArray {
    public function makeBlankItem() : AbstractJsonData
    {
        return new AbstractJsonData();
    }

    public function toArray() : array
    {
        $list = [];

        foreach ($this as $data) {
            $list[] = $data->toArray();
        }
        return $list;
    }

    public function setFromJson(array $data) : void
    {
        foreach ($data as $jsonData) {
            $obj = $this->makeBlankItem();
            $obj->setFromJson($jsonData);
            $this->months->add($obj);
        }
    }
}