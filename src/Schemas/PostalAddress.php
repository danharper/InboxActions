<?php namespace DanHarper\InboxActions\Schemas;

use DanHarper\InboxActions\SchemaInterface;

class PostalAddress implements SchemaInterface {

	/**
	 * @var string|null
	 */
	public $name;

	/**
	 * @var string|null
	 */
	public $streetAddress;

	/**
	 * @var string|null
	 */
	public $addressLocality;

	/**
	 * @var string|null
	 */
	public $addressRegion;

	/**
	 * @var string|null
	 */
	public $postalCode;

	/**
	 * @var string|null
	 */
	public $addressCountry;

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'PostalAddress';
	}

	public function __construct()
	{
		call_user_func_array([$this, 'set'], func_get_args());
	}

	public function set($name = null, $streetAddress = null, $city = null, $region = null, $postCode = null, $country = null)
	{
		$this->name = $name;
		$this->streetAddress = $streetAddress;
		$this->addressLocality = $city;
		$this->addressRegion = $region;
		$this->postalCode = $postCode;
		$this->addressCountry = $country;
	}

	public function name($name)
	{
		$this->name = $name;

		return $this;
	}

	public function street($street)
	{
		$this->streetAddress = $street;

		return $this;
	}

	public function city($city)
	{
		$this->addressLocality = $city;

		return $this;
	}

	public function region($region)
	{
		$this->addressRegion = $region;

		return $this;
	}

	public function postCode($postCode)
	{
		$this->postalCode = $postCode;

		return $this;
	}

	public function country($country)
	{
		$this->addressCountry = $country;

		return $this;
	}

}