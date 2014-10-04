<?php namespace DanHarper\InboxActions\Schemas;

use DateTime;
use DanHarper\InboxActions\SchemaInterface;

class Event implements SchemaInterface {

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var DateTime|null
	 */
	public $startDate;

	/**
	 * @var DateTime|null
	 */
	public $endDate;

	/**
	 * @var Place|null
	 */
	public $location;

	/**
	 * @var RsvpAction[]|null
	 */
	public $action;

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'Event';
	}

}