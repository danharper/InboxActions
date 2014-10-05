<?php namespace DanHarper\InboxActions\Actions;

use DanHarper\InboxActions\ActionInterface;
use DanHarper\InboxActions\ActionTrait;
use DanHarper\InboxActions\Schemas\EmailMessage;
use DanHarper\InboxActions\Schemas\HttpActionHandler;
use DanHarper\InboxActions\Schemas\ConfirmAction as ConfirmActionSchema;
use DanHarper\InboxActions\Schemas\Organization;

class ConfirmAction implements ActionInterface {

	use ActionTrait;

	private $emailMessage;

	public function __construct($name, $url, $method = 'GET')
	{
		$this->named($name)->handler($url)->method($method);
	}

	public function named($name)
	{
		$this->getAction()->name = $name;
		return $this;
	}

	public function handler($url)
	{
		$this->getActionHandler()->url = $url;
		return $this;
	}

	public function method($method)
	{
		$this->getActionHandler()->method($method);
		return $this;
	}

	public function requireConfirmation($confirm = true)
	{
		$this->getActionHandler()->requiresConfirmation = $confirm;
		return $this;
	}

	public function publisher($name, $url = null)
	{
		$publisher = $this->getPublisher();
		$publisher->name = $name;
		$publisher->url = $url;
		return $this;
	}

	protected function getSchema()
	{
		return $this->emailMessage;
	}

	/**
	 * @return EmailMessage
	 */
	protected function getEmailMessage()
	{
		return $this->findOrMake($this, 'emailMessage', EmailMessage::class);
	}

	/**
	 * @return ConfirmActionSchema
	 */
	protected function getAction()
	{
		return $this->findOrMake($this->getEmailMessage(), 'action', ConfirmActionSchema::class);
	}

	/**
	 * @return HttpActionHandler
	 */
	protected function getActionHandler()
	{
		return $this->findOrMake($this->getAction(), 'handler', HttpActionHandler::class);
	}

	/**
	 * @return Organization
	 */
	protected function getPublisher()
	{
		return $this->findOrMake($this->getEmailMessage(), 'publisher', Organization::class);
	}

	/**
	 * @param $method
	 * @param $url
	 * @return HttpActionHandler
	 */
	protected function makeHttpHandler($method, $url)
	{
		if ($method instanceof HttpActionHandler)
		{
			$httpAction = $method;
		}
		else if ($method && $url)
		{
			$httpAction = new HttpActionHandler($method, $url);
		}
		else
		{
			list($method, $url) = ['GET', $method];
			$httpAction = new HttpActionHandler($method, $url);
		}

		return $httpAction;
	}

}