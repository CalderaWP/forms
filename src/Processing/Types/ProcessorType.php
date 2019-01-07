<?php


namespace calderawp\caldera\Forms\Processing\Types;
use calderawp\interop\Contracts\ProcessesFormSubmissionContract;


abstract class ProcessorType
{
	/** @inheritdoc */
	public function toArray(): array
	{
		return [

		];
	}

	/** @inheritdoc */
	public function jsonSerialize()
	{
		$this->toArray();
	}

	/**
	 * @return string
	 */
	abstract public function getProcessorType() : string;

}
