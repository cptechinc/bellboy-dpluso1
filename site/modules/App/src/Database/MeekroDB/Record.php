<?php namespace App\Database\MeekroDB;
// ProcessWire
use ProcessWire\WireData;

/**
 * Container for DatabaseTable Record
 */
class Record extends WireData {
	const PRIMARYKEY = [];
	const RECORDKEY  = [];
	const GLUE = '|';
	const COLUMN_MAP = [

    ];

	/**
	 * Return Keys for this Model
	 * @return array
	 */
	public function primarykey() : array 
	{
		$keys = [];

		foreach (static::PRIMARYKEY as $key) {
			$keys[] = $this->$key;
		}
		return $keys;
	}

	/**
	 * Return Primary Key as a string
	 * @return string
	 */
	public function primarykeyString() : string 
	{
		return implode(static::GLUE, $this->primarykey());
	}

	public function setDbArray(array $data) : void
	{
		$this->setArray($data);

		foreach (static::COLUMN_MAP as $field => $srcField) {
			if (array_key_exists($srcField, $data)) {
				$this->set($field, $data[$srcField]);
			}
		}
	} 
}