<?php namespace DanHarper\InboxActions\Schemas;

use DanHarper\InboxActions\SchemaInterface;

class Place implements SchemaInterface {

	/**
	 * @var PostalAddress|null
	 */
	public $address;

	public function getType()
	{
		return 'Place';
	}

}
