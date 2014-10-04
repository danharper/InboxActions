<?php
namespace DanHarper\InboxActions;

interface RendererInterface {

	/**
	 * @param SchemaInterface $embed
	 * @return string
	 */
	public function render(SchemaInterface $embed);

}