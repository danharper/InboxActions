<?php namespace DanHarper\InboxActions\Schemas;

use DanHarper\InboxActions\SchemaInterface;

class Organization implements SchemaInterface {

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
		return 'Organization';
	}

	public function __construct($name = null, $url = null)
	{
		$this->set($name, $url);
	}

	public function set($name, $url)
	{
		$this->name = $name;
		$this->url = $url;
	}

}