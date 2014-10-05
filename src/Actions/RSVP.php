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

	public function yes($url, $method = 'GET')
	{
		return $this->reply(RsvpAction::YES, $url, $method);
	}

	public function no($url, $method = 'GET')
	{
		return $this->reply(RsvpAction::NO, $url, $method);
	}

	public function maybe($url, $method = 'GET')
	{
		return $this->reply(RsvpAction::MAYBE, $url, $method);
	}

	private function reply($attendance, $url, $method)
	{
		$this->getActions()[] = new RsvpAction($attendance, new HttpActionHandler($method, $url));
		return $this;
	}

	private function getEvent()
	{
		return $this->findOrMake($this, 'event', Event::class);
	}

	private function getPlace()
	{
		return $this->findOrMake($this->getEvent(), 'location', Place::class);
	}

	private function getAddress()
	{
		return $this->findOrMake($this->getPlace(), 'address', PostalAddress::class);
	}

	private function getActions()
	{
		return $this->findOrMake($this->getEvent(), 'action', Collection::class);
	}

	/**
	 * @return SchemaInterface
	 */
	protected function getSchema()
	{
		return $this->event;
	}

}