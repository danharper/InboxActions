<?php namespace DanHarper\InboxActions\Schemas;

use DanHarper\InboxActions\SchemaInterface;

class ViewAction implements SchemaInterface {

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $url;

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'ViewAction';
	}

	public function set($name = null, $url = null)
	{
		$this->name = $name;
		$this->url = $url;
	}

}