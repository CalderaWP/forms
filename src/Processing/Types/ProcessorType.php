<?php


namespace calderawp\caldera\Forms\Processing\Types;

use calderawp\caldera\Forms\Contracts\ProcessorTypeContract;

abstract class ProcessorType implements ProcessorTypeContract
{
	/** @inheritdoc */
	public function toArray(): array
	{
		return [
			'type' => $this->getProcessorType()
		];
	}

	/** @inheritdoc */
	public function jsonSerialize()
	{
		$this->toArray();
	}

	/** @inheritdoc */
	abstract public function getProcessorType() : string;

	/** @inheritdoc */
	abstract public function getCallbacks() : array;
}
