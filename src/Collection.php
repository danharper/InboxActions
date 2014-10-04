<?php namespace DanHarper\InboxActions;

use ArrayAccess;

class Collection implements ArrayAccess {

	/**
	 * @var array
	 */
	private $items;

	public function __construct(array $items = [])
	{
		$this->items = $items;
	}

	public function offsetExists($offset)
	{
		return isset($this->items[$offset]);
	}

	public function offsetGet($offset)
	{
		return $this->items[$offset];
	}

	public function offsetSet($offset, $value)
	{
		if (is_null($offset))
		{
			$this->items[] = $value;
		}
		else
		{
			$this->items[$offset] = $value;
		}
	}

	public function offsetUnset($offset)
	{
		unset($this->items[$offset]);
	}

	public function toArray()
	{
		return array_values($this->items);
	}

}