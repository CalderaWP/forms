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
}
