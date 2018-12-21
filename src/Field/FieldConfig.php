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
		if( is_null( $this->options ) ){
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


	public function toArray() : array
	{
		$array = [];
		/** @var FieldOption $option */
		foreach ( $this->getOptions() as $option ){
			$array[] = $option->toArray();
		}

		return $array;
	}
}
