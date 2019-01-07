<?php

namespace calderawp\caldera\Forms\Tests\Processing;

use calderawp\caldera\Forms\Processing\Processor;
use calderawp\caldera\Forms\Processing\ProcessorCollection;
use calderawp\caldera\Forms\Tests\TestCase;

class ProcessorCollectionTest extends TestCase
{
	/**
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorCollection::hasProcessorOfType()
	 */
	public function testHasProcessorOfType()
	{
		$type = 'theType';
		$processorOne = \Mockery::mock('Processor', Processor::class);
		$processorOne->shouldReceive('getProcessorType')->andReturn($type);
		$processorTwo = \Mockery::mock('Processor', Processor::class);
		$processorTwo->shouldReceive('getProcessorType')->andReturn('notTheType');
		$processors = new ProcessorCollection();
		$processors->addProcessor($processorTwo);
		$processors->addProcessor($processorOne);
		$this->assertTrue($processors->hasProcessorOfType($type));
		$this->assertFalse($processors->hasProcessorOfType('ffaasd'));
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorCollection::addProcessor()
	 */
	public function testAddProcessor()
	{
		$processorOne = \Mockery::mock('Processor', Processor::class);
		$processors = new ProcessorCollection();
		$processors->addProcessor($processorOne);
		$this->assertAttributeCount(1, 'items', $processors);
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorCollection::fromArray()
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorCollection::toArray()
	 */
	public function testToFromArray()
	{
		$array = [
			[
				'label' => 'The Label',
				'type' => 'testType',
				'config' =>
					[
						'settingOne' => 'fld1',
						'settingTwo' => 'Hats',
					]
			],
			[
				'label' => 'The Second label',
				'type' => 'testType',
				'config' =>
					[
						'settingOne' => 'fld1',
						'settingTwo' => 'Hats',
					]
			]
		];
		$processors = ProcessorCollection::fromArray($array);
		$this->assertSame($array, $processors->toArray());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorCollection::getIterator()
	 * @covers \calderawp\interop\Traits\ItemsIterator::getIterator()
	 */
	public function testIsIterator(){
		$array = [
			[
				'label' => 'The Label',
				'type' => 'testType',
				'config' =>
					[
						'settingOne' => 'fld1',
						'settingTwo' => 'Hats',
					]
			],
			[
				'label' => 'The Second label',
				'type' => 'testType',
				'config' =>
					[
						'settingOne' => 'fld1',
						'settingTwo' => 'Hats',
					]
			]
		];
		$processors = ProcessorCollection::fromArray($array);

		$this->assertTrue( is_iterable( $processors->getIterator() ));
		$this->assertTrue( is_iterable( $processors ));
		$this->assertFalse(empty($processors));


	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorCollection::fromArray()
	 */
	public function testFromArray(){
		$processorArray = [
			'type' => 'apiRequest',
			'label' => 'Test sending form data to test API',
			'config' => [
				'requestURL' => 'https://something.com',
				'requestMethod' => 'POST',
				'responseField' => 'message',
				'fieldToUpdate' => 'apiMessage',
			]
		];
		$processor = Processor::fromArray($processorArray);
		$processors = ProcessorCollection::fromArray([
			$processorArray
		]);

		$this->assertTrue( $processors->hasProcessorOfType( 'apiRequest'));
		$processorsToArray = $processors->toArray();
		$this->assertSame($processorArray['config'],$processorsToArray[0]['config']);
	}
}
