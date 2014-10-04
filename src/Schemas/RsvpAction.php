<?php namespace DanHarper\InboxActions\Schemas;

use DanHarper\InboxActions\SchemaInterface;

class RsvpAction implements SchemaInterface {

	const YES = 'Yes';
	const NO = 'No';
	const MAYBE = 'Maybe';

	/**
	 * @var string
	 */
	public $attendance;

	/**
	 * @var HttpActionHandler
	 */
	public $handler;

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'RsvpAction';
	}

	public function __construct($attendance, HttpActionHandler $handler)
	{
		$this->attendance($attendance);
		$this->handler = $handler;
	}

	public function attendance($attendance)
	{
		$this->attendance = 'http://schema.org/RsvpAttendance/' . ucwords(strtolower($attendance));
	}

}
