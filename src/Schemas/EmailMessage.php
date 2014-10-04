<?php namespace DanHarper\InboxActions\Schemas;

use DanHarper\InboxActions\SchemaInterface;

class EmailMessage implements SchemaInterface {

	/**
	 * @var string|null
	 */
	public $description;

	/**
	 * @var ViewAction|null
	 */
	public $action;

	/**
	 * @var Organization|null
	 */
	public $publisher;

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'EmailMessage';
	}

}