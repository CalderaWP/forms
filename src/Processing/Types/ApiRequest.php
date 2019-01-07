<?php


namespace calderawp\caldera\Forms\Processing\Types;

use calderawp\caldera\Forms\Processing\ProcessorConfig;

class ApiRequest extends ProcessorType
{


	//? is this default settings
	//? how do we define UI fields and non-ui fields?
	public function getProcessorConfig(): ProcessorConfig
	{
		return new ProcessorConfig([
			'requestURL' => 'https://something.com',
			'requestMethod' => 'POST',
			'responseField' => 'message',
			'fieldToUpdate' => 'apiMessage',
		]);
	}

	public function getProcessorType(): string
	{
		return 'apiRequest';
	}
}
