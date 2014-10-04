<?php namespace DanHarper\InboxActions;

use DanHarper\InboxActions\Actions\RSVP;
use DanHarper\InboxActions\Actions\ViewAction;
use DanHarper\InboxActions\Renderers\JsonLdRenderer;

class InboxAction {

	/**
	 * @var RendererInterface
	 */
	private static $renderer;

	/**
	 * @param string $name
	 * @param string $url
	 * @return ViewAction
	 */
	public static function ViewAction($name, $url)
	{
		return static::init(new ViewAction($name, $url));
	}

	/**
	 * @param string $name
	 * @return RSVP
	 */
	public static function RSVP($name)
	{
		return static::init(new RSVP($name));
	}

	private static function init(ActionInterface $action)
	{
		return $action->setRenderer(static::getRenderer());
	}

	private static function getRenderer()
	{
		if ( ! static::$renderer) static::$renderer = new JsonLdRenderer;
		return static::$renderer;
	}

	public function setRenderer(RendererInterface $renderer)
	{
		static::$renderer = $renderer;
	}

} 