<?php namespace DanHarper\InboxActions;

trait ActionTrait {

	/**
	 * @var RendererInterface
	 */
	protected $renderer;

	public function setRenderer(RendererInterface $renderer)
	{
		$this->renderer = $renderer;
		return $this;
	}

	public function render()
	{
		if ($this->renderer)
		{
			return $this->renderer->render($this->getSchema());
		}
		else
		{
			return '';
		}
	}

	public function __toString()
	{
		return $this->render();
	}

	/**
	 * @return SchemaInterface
	 */
	abstract protected function getSchema();

} 