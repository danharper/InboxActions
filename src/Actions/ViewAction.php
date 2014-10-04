<?php namespace DanHarper\InboxActions\Actions;

use DanHarper\InboxActions\ActionInterface;
use DanHarper\InboxActions\ActionTrait;
use DanHarper\InboxActions\SchemaInterface;
use DanHarper\InboxActions\Schemas\EmailMessage;
use DanHarper\InboxActions\Schemas\Organization;
use DanHarper\InboxActions\Schemas\ViewAction as ViewActionSchema;

class ViewAction implements ActionInterface {

	use ActionTrait;

	/**
	 * @var EmailMessage
	 */
	private $emailMessage;

	public function __construct($name = null, $url = null)
	{
		$this->action($name, $url);
	}

	public function action($name, $url)
	{
		$this->getAction()->set($name, $url);

		return $this;
	}

	public function publisher($name, $url)
	{
		$this->getPublisher()->set($name, $url);

		return $this;
	}

	public function getAction()
	{
		$email = $this->getEmailMessage();

		if ( ! $email->action) $email->action = new ViewActionSchema;
		return $email->action;
	}

	public function getPublisher()
	{
		$email = $this->getEmailMessage();

		if ( ! $email->publisher) $email->publisher = new Organization;
		return $email->publisher;
	}

	public function getEmailMessage()
	{
		if ( ! $this->emailMessage) $this->emailMessage = new EmailMessage;
		return $this->emailMessage;
	}

	/**
	 * @return SchemaInterface
	 */
	protected function getSchema()
	{
		return $this->emailMessage;
	}

}
