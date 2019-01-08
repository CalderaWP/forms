<?php

namespace calderawp\caldera\Forms\Tests\Processing;

use calderawp\caldera\Forms\Processing\Types\ProcessorType;
use PHPUnit\Framework\TestCase;

class ProcessorTypeTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Processing\Types\ProcessorType::getCallbacks()
	 */
	public function testGetCallbacks()
	{
		$type = new class extends ProcessorType
		{
			public function getCallbacks(): array
			{
				return [];
			}


			public function getProcessorType(): string
			{
			}

		};
		$this->assertIsArray($type->getCallbacks());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\Types\ProcessorType::getProcessorType()
	 */
	public function testGetProcessorType()
	{
		$type = new class extends ProcessorType
		{
			public function getCallbacks(): array
			{
				return [];
			}


			public function getProcessorType(): string
			{
				return 'shallowLumens';
			}

		};
		$this->assertIsString($type->getProcessorType());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\Types\ProcessorType::toArray()
	 */
	public function testToArray()
	{
		$type = new class extends ProcessorType
		{
			public function getCallbacks(): array
			{
				return [];
			}


			public function getProcessorType(): string
			{
				return 'catDogTurtle';
			}

		};
		$this->assertArrayHasKey( 'type', $type->toArray() );

	}
}
