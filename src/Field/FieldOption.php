<?php


namespace calderawp\caldera\Forms\Field;

use calderawp\interop\Traits\ProvidesIdGeneric;
use calderawp\interop\Traits\ProvidesLabel;
use calderawp\interop\Traits\ProvidesValue;

class FieldOption implements CalderaFormsFieldOptionContract
{

	use ProvidesValue;
	use ProvidesLabel;
	use ProvidesIdGeneric;


	/** @var int */
	protected $calculationValue;

	/** @inheritdoc */
	public function getCalculationValue(): int
	{
		return is_int($this->calculationValue) ? $this->calculationValue
			: intval($this->getValue());
	}
	/** @inheritdoc */
	public function setCalculationValue(int $value): CalderaFormsFieldOptionContract
	{
		$this->calculationValue = $value;
		return $this;
	}


	public function toArray(): array
	{
		return [
			'id' => $this->getId(),
			'value' => $this->getValue(),
			'label' => $this->getLabel(),
			'calcValue' => $this->getCalculationValue()
		];
	}

	/** @inheritdoc */
	public function getId()
	{
		if (! $this->id) {
			return str_replace(' ', '', strtolower(preg_replace("[^A-Za-z0-9 ]", "", $this->getLabel())));
		}

		return $this->id;
	}

	public function jsonSerialize()
	{
		return $this->toArray();
	}


	public function __set($name, $value)
	{
		// TODO: Implement __set() method.
	}

	public static function fromArray(array $items) : FieldOption
	{

		$obj = new static();
		foreach ([
					 'id',
					 'value',
					 'label',
					 'calcValue'
				 ] as $key) {
			if (isset($items[$key])) {
				$_value = $items[$key];
				switch ($key) {
					case 'id':
						$obj->setId($_value);
						break;
					case 'value':
						$obj->setValue($_value);
						break;
					case 'label':
						$obj->setLabel($_value);
						break;
					case 'calcValue':
					case 'calculationValue':
						$obj->setCalculationValue($_value);
						break;
				}
			}
		}

		if (empty($items['id'])) {
			$obj->setId($obj->getId());
		}

		return $obj;
	}
}
