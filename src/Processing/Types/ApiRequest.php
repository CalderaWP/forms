<?php


namespace calderawp\caldera\Forms\Processing\Types;

use calderawp\caldera\Forms\Processing\Processor;
use calderawp\caldera\Forms\Processing\ProcessorConfig;
use calderawp\caldera\Forms\Processing\Types\Callbacks\ApiRequestPre;

class ApiRequest extends ProcessorType
{

	/** @inheritdoc */
	public function getProcessorType(): string
	{
		return 'apiRequest';
	}

	/** @inheritdoc */
	public function getCallbacks(): array
	{
		return [
			Processor::PRE_PROCESS => ApiRequestPre::class,
		];
	}
}
