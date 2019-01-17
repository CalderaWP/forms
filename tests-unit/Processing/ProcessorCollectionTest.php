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
		$processorOne->shouldReceive('getId' )->andReturn('g1');
		$processorOne->shouldReceive('getProcessorType')->andReturn($type);
		$processorTwo = \Mockery::mock('Processor', Processor::class);
		$processorTwo->shouldReceive('getProcessorType')->andReturn('notTheType');
		$processorTwo->shouldReceive('getId' )->andReturn('g2');

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
		$processorOne->shouldReceive('getId' );
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
				'id' => 'a12',
				'label' => 'Letters and Numbers',
				'type' => 'testType',
				'config' =>
					[
						'settingOne' => 'fld1',
						'settingTwo' => 'Hats',
					]
			],
			[
				'id' => '1',
				'label' => 'String number',
				'type' => 'testType',
				'config' =>
					[
						'settingOne' => 'fld1',
						'settingTwo' => 'Hats',
					]
			]
		];
		$processors = ProcessorCollection::fromArray($array);
		$this->assertSame($array, array_values($processors->toArray()));
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
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorCollection::getProcessor()
	 */
	public function testGetProcessor()
	{
		$id1 = 'aardvarkJourney';
		$array = [
			[
				'id' => $id1,
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
		$this->assertIsObject( $processors->getProcessor($id1) );
		$this->assertNull($processors->getProcessor('EveryThingMattersBecauseNothingHasMeaning'));
	}


	/**
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorCollection::fromArray()
	 */
	public function testFromArray(){
		$processorArray = [
			'id' => 'season7Episode2',
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
			$processorArray,
			[
				'id' => 'p2',
				'type' => 'mailchimp',
				'label' => 'Main Mailchimp',
				'config' => [
					'listId' => '7',
					'requestMethod' => 'POST',
					'responseField' => 'message',
					'fieldToUpdate' => 'apiMessage',
				]
			]
		]);
		$this->assertTrue( $processors->hasProcessorOfType( 'apiRequest'));
		$processorsToArray = $processors->toArray();
		$this->assertSame($processorArray['config'],$processorsToArray['season7Episode2']['config']);
	}
}
