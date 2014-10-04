<?php namespace DanHarper\InboxActions\Renderers;

use DateTime;
use DanHarper\InboxActions\Collection;
use DanHarper\InboxActions\RendererInterface;
use DanHarper\InboxActions\SchemaInterface;

class JsonLdRenderer implements RendererInterface {

	public function render(SchemaInterface $embed)
	{
		$output = array_merge(['@context' => 'http://schema.org'], $this->process($embed));

		$output = json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

		return '<script type="application/ld+json">' . PHP_EOL . $output . PHP_EOL . '</script>';
	}

	private function process($embed)
	{
		if ($embed instanceof SchemaInterface)
		{
			return array_merge(['@type' => $embed->getType()], $this->processAction($embed));
		}
		else if (is_array($embed))
		{
			return array_map([$this, 'process'], $embed);
		}
		else if ($embed instanceof Collection)
		{
			return array_map([$this, 'process'], $embed->toArray());
		}
		else
		{
			return $this->convert($embed);
		}
	}

	private function processAction(SchemaInterface $embed)
	{
		$output = [];

		foreach (get_object_vars($embed) as $field => $value)
		{
			if (is_null($value)) continue;

			$output[$field] = $this->process($value);
		}

		return $output;
	}

	private function convert($data)
	{
		if ($data instanceof DateTime)
		{
			return $this->convertDateTime($data);
		}

		return $data;
	}

	private function convertDateTime(DateTime $dateTime)
	{
		return $dateTime->format(DateTime::ISO8601);
	}

} 