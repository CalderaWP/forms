<?php


namespace calderawp\caldera\Forms\Field;

class FieldOptions
{

	protected $items;

	public function addOption(FieldOption $option) : FieldOptions
	{
		$this->items[$option->getId()] = $option;
		return $this;
	}

	public static function fromArray(array  $items) : FieldOptions
	{
		$obj = new static();
		foreach ($items as $item) {
			$obj->addOption($item);
		}
		return $obj;
	}
	public function toArray() : array
	{
		if (empty($this->items)) {
			return [];
		}
		$array = [];
		foreach ($this->items as $item) {
			$array[$item->getId()]= $item->toArray();
		}

		return $array;
	}

	public function getOption($optionId) : FieldOption
	{
		if ($this->hasOption($optionId)) {
			return $this->items[$optionId];
		}
	}

	public function getOptions(): array
	{
		return is_array($this->items) ? $this->items : [];
	}

	public function removeOption(FieldOption $option) : FieldOptions
	{
		if ($this->hasOption($option->getId())) {
			unset($this->items[$option->getId()]);
		}
		return $this;
	}

	public function hasOption($optionId): bool
	{

		return array_key_exists($optionId, $this->getOptions());
	}
}
