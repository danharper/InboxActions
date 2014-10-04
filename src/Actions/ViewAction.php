<?php namespace DanHarper\InboxActions\Actions;

use DanHarper\InboxActions\ActionInterface;
use DanHarper\InboxActions\ActionTrait;
use DanHarper\InboxActions\SchemaInterface;
use DanHarper\InboxActions\Schemas\EmailMessage;
use DanHarper\InboxActions\Schemas\HttpActionHandler;
use DanHarper\InboxActions\Schemas\Organization;
use DanHarper\InboxActions\Schemas\ViewAction as ViewActionSchema;

class ViewAction implements ActionInterface {

	use ActionTrait;

	/**
	 * @var EmailMessage
	 */
	private $emailMessage;

	public function __construct($name, $url = null)
	{
		$this->named($name)->handler($url);
	}

	public function named($name)
	{
		$this->getAction()->name = $name;
		return $this;
	}

	public function handler($url)
	{
		$this->getAction()->url = $url;
		return $this;
	}

	public function publisher($name, $url)
	{
		$this->getPublisher()->set($name, $url);
		return $this;
	}

	/**
	 * @return ViewActionSchema
	 */
	protected function getAction()
	{
		return $this->findOrMake($this->getEmailMessage(), 'action', ViewActionSchema::class);
	}

	/**
	 * @return EmailMessage
	 */
	protected function getEmailMessage()
	{
		return $this->findOrMake($this, 'emailMessage', EmailMessage::class);
	}

	/**
	 * @return Organization
	 */
	protected function getPublisher()
	{
		return $this->findOrMake($this->getEmailMessage(), 'publisher', Organization::class);
	}

	/**
	 * @return SchemaInterface
	 */
	protected function getSchema()
	{
		return $this->emailMessage;
	}

}
