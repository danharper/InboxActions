<?php namespace DanHarper\InboxActions\Actions;

use Closure;
use DateTime;
use InvalidArgumentException;
use DanHarper\InboxActions\ActionInterface;
use DanHarper\InboxActions\ActionTrait;
use DanHarper\InboxActions\Collection;
use DanHarper\InboxActions\SchemaInterface;
use DanHarper\InboxActions\Schemas\PostalAddress;
use DanHarper\InboxActions\Schemas\Event;
use DanHarper\InboxActions\Schemas\HttpActionHandler;
use DanHarper\InboxActions\Schemas\Place;
use DanHarper\InboxActions\Schemas\RsvpAction;

class RSVP implements ActionInterface {

	use ActionTrait;

	/**
	 * @var Event|null
	 */
	private $event;

	public function __construct($name)
	{
		$this->named($name);
	}

	public function named($name)
	{
		$this->getEvent()->name = $name;
		return $this;
	}

	public function address($address)
	{
		if ($address instanceof PostalAddress)
		{
			$this->getPlace()->address = $address;
		}
		else if ($address instanceof Closure)
		{
			$address($this->getAddress());
		}
		else
		{
			throw new InvalidArgumentException;
		}

		return $this;
	}

	public function start(DateTime $start)
	{
		$this->getEvent()->startDate = $start;
		return $this;
	}

	public function finish(DateTime $end)
	{
		$this->getEvent()->endDate = $end;
		return $this;
	}

	public function at(DateTime $start, DateTime $finish)
	{
		return $this->start($start)->finish($finish);
	}

	public function replyYes($method, $url = null)
	{
		return $this->reply(RsvpAction::YES, $method, $url);
	}

	public function replyNo($method, $url = null)
	{
		return $this->reply(RsvpAction::NO, $method, $url);
	}

	public function replyMaybe($method, $url = null)
	{
		return $this->reply(RsvpAction::MAYBE, $method, $url);
	}

	public function reply($attendance, $method, $url = null)
	{
		$this->getActions()[] = new RsvpAction($attendance, $this->makeHttpAction($method, $url));
		return $this;
	}

	/**
	 * @param $method
	 * @param $url
	 * @return HttpActionHandler
	 */
	protected function makeHttpAction($method, $url)
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

	private function getEvent()
	{
		if ( ! $this->event) $this->event = new Event;
		return $this->event;
	}

	private function getPlace()
	{
		$event = $this->getEvent();

		if ( ! $event->location) $event->location = new Place;
		return $event->location;
	}

	private function getAddress()
	{
		$location = $this->getPlace();

		if ( ! $location->address) $location->address = new PostalAddress;
		return $location->address;
	}

	private function getActions()
	{
		$event = $this->getEvent();
		if ( ! $event->action) $event->action = new Collection;
		return $event->action;
	}

	/**
	 * @return SchemaInterface
	 */
	protected function getSchema()
	{
		return $this->event;
	}

}