<?php


namespace calderawp\caldera\Forms\Field;

class FieldConfig
{

	/**
	 * @var FieldOptions
	 */
	protected $options;

	/**
	 * @return FieldOptions
	 */
	public function getOptions(): FieldOptions
	{
		if (is_null($this->options)) {
			$this->options = new FieldOptions();
		}
		return $this->options;
	}

	/**
	 * @param FieldOptions $options
	 *
	 * @return  $this;
	 */
	public function setOptions(FieldOptions $options): FieldConfig
	{
		$this->options = $options;
		return $this;
	}


	public static function fromArray(array $items): FieldConfig
	{
		$obj = new static;
		if (isset($items[ 'options' ])) {
			if (! is_a($items[ 'options' ], FieldOptions::class)) {
				foreach ($items['options'] as $optionIndex => $option) {
					if (is_array($option)) {
						$option = FieldOption::fromArray($option);
					}
					if (! is_a($option, FieldOption::class)) {
						unset($items[$optionIndex]);
					}
				}
			}

			$obj->setOptions($items[ 'options' ]);
		}

		return $obj;
	}

	public function toArray() : array
	{
		$array = [];
		/** @var FieldOption $option */
		foreach ($this->getOptions() as $option) {
			$array[] = $option->toArray();
		}

		return $array;
	}
}
