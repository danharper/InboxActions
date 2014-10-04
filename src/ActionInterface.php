<?php namespace DanHarper\InboxActions;

interface ActionInterface {

	/**
	 * @param RendererInterface $renderer
	 * @return $this
	 */
	public function setRenderer(RendererInterface $renderer);

	/**
	 * @return string
	 */
	public function render();

	/**
	 * @return string
	 */
	public function __toString();

} 