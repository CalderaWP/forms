<?php


namespace calderawp\caldera\Forms\Field;

class FieldConfig
{

	/**
	 * @var FieldOptions
	 */
	protected $options;

	protected $otherConfigOptions = [
		'buttonType' => 'submit',
		'html5type' => 'text',
		'attributes' => []
	];


	public function setOtherConfigOption(string $option, $value): FieldConfig
	{
		if ($this->isValidOtherConfigOption($option)) {
			$this->otherConfigOptions[ $option ] = $value;
		}
		return $this;
	}

	public function getOtherConfigOption(string $option)
	{
		if ($this->isValidOtherConfigOption($option)) {
			return $this->otherConfigOptions[ $option ];
		}
	}

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
			if (!is_a($items[ 'options' ], FieldOptions::class)) {
				$options = new FieldOptions();

				foreach ($items[ 'options' ] as $optionIndex => $option) {
					if (is_array($option)) {
						$option = FieldOption::fromArray($option);
					}
					if (is_a($option, FieldOption::class)) {
						$options->addOption($option);
					}
				}
				$obj->setOptions($options);
			} else {
				$obj->setOptions($items[ 'options' ]);
			}
			unset($items[ 'options' ]);
		}
		foreach ($items as $key => $value) {
			if ($obj->isValidOtherConfigOption($key)) {
				$obj->setOtherConfigOption($key, $value);
			}
		}


		return $obj;
	}

	public function toArray(): array
	{
		$array = [];
		/** @var FieldOption $option */
		foreach ($this->getOptions() as $option) {
			$array[] = $option->toArray();
		}

		return $array;
	}

	/**
	 * @param string $option
	 *
	 * @return bool
	 */
	public function isValidOtherConfigOption(string $option): bool
	{
		return array_key_exists($option, $this->otherConfigOptions);
	}
}
