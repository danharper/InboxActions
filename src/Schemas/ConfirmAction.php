<?php namespace DanHarper\InboxActions\Schemas;

use DanHarper\InboxActions\SchemaInterface;

class ConfirmAction implements SchemaInterface {

	/**
	 * @var string|null
	 */
	public $name;

	/**
	 * @var HttpActionHandler
	 */
	public $handler;

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'ConfirmAction';
	}

}