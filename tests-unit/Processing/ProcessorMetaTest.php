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

	/**
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorMeta::setId()
	 */
	public function testSetId()
	{
		$processorMeta = new ProcessorMeta(['id' => 'p55']);
		$this->assertEquals('p55', $processorMeta['id']);
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorMeta::getId()
	 */
	public function testGetId()
	{
		$processorMeta = new ProcessorMeta();
		$id = $processorMeta->getId();
		$this->assertStringStartsWith('p',$id);
		$this->assertEquals($id, $processorMeta['id']);
		$this->assertEquals($id, $processorMeta->getId());
		$processorMeta->setId('f1');
		$this->assertEquals('f1', $processorMeta->getId());
	}
}
