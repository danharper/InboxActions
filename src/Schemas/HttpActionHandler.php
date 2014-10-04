<?php namespace DanHarper\InboxActions\Schemas;

use DanHarper\InboxActions\SchemaInterface;

class HttpActionHandler implements SchemaInterface {

	const GET = 'GET';
	const POST = 'POST';

	/**
	 * @var string
	 */
	public $method;

	/**
	 * @var string
	 */
	public $url;

	/**
	 * @var bool|null
	 */
	public $requiresConfirmation;

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'HttpActionHandler';
	}

	public function __construct($method = 'GET', $url = null)
	{
		$this->method($method);
		$this->url = $url;
	}

	public function method($method)
	{
		$this->method = 'http://schema.org/HttpRequestMethod/' . strtoupper($method);
	}

	public static function GET($url)
	{
		return new HttpActionHandler(self::GET, $url);
	}

	public static function POST($url)
	{
		return new HttpActionHandler(self::POST, $url);
	}

}
