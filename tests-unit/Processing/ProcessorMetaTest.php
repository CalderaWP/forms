<?php

namespace calderawp\caldera\Forms\Tests\Processing;

use calderawp\caldera\Forms\Processing\ProcessorMeta;
use PHPUnit\Framework\TestCase;

class ProcessorMetaTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorMeta::getLabel()
	 */
	public function testGetLabel()
	{
		$processorMeta = new ProcessorMeta(['label' => 'Noms']);
		$this->assertEquals('Noms', $processorMeta[ 'label']);
		$this->assertEquals('Noms', $processorMeta->getLabel());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorMeta::getType()
	 */
	public function testType()
	{
		$processorMeta = new ProcessorMeta(['label' => 'Noms', 'type' => 'password']);
		$this->assertEquals('password', $processorMeta[ 'type']);
		$this->assertEquals('password', $processorMeta->getType());
	}
}
