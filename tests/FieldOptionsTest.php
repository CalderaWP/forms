<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\Field\FieldOption;
use calderawp\caldera\Forms\Field\FieldOptions;

class FieldOptionsTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldOptions::fromArray();
	 */
	public function testFromArray()
	{
		$opts = [
			$this->optionOne(),
			$this->optionTwo(),
		];
		$fieldOptions = FieldOptions::fromArray($opts);
		$this->assertAttributeEquals([
			$this->optionOne()->getId() => $this->optionOne(),
			$this->optionTwo()->getId() => $this->optionTwo(),

		], 'items', $fieldOptions);
	}

	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldOptions::removeOption();
	 * @covers \calderawp\caldera\Forms\Field\FieldOptions::hasOption();
	 */
	public function testRemoveOption()
	{
		$optTwo = $this->optionTwo();
		$opts = [
			$this->optionOne(),
			$optTwo,
		];
		$fieldOptions = FieldOptions::fromArray($opts);
		$fieldOptions->removeOption($optTwo);
		$this->assertFalse($fieldOptions->hasOption($optTwo->getId()));
	}

	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldOptions::addOption();
	 */
	public function testAddOption()
	{
		$fieldOptions = new FieldOptions();
		$optTwo = $this->optionTwo();
		$fieldOptions->addOption($optTwo);
		$fieldOptions->hasOption($optTwo->getId());
		$this->assertAttributeEquals([$optTwo->getId() => $optTwo], 'items', $fieldOptions);
	}

	public function testAddMoreOptions()
	{
		$fieldOptions = new FieldOptions();
		$optThree = FieldOption::fromArray([
			'id' => 'opt3',
			'value' => '3',
			'label' => 'zr 3',
			'calcValue' => 33,
		]);

		$optTwo = $this->optionTwo();
		$fieldOptions->addOption($optThree);
		$fieldOptions->addOption($this->optionOne());
		$fieldOptions->addOption($optTwo);
		$this->assertTrue($fieldOptions->hasOption($optTwo->getId()));
		$this->assertTrue($fieldOptions->hasOption($optThree->getId()));
		//$this->assertEquals('opt3', $fieldOptions->getOptions()['opt3']['id']);
		$this->assertEquals($optThree->getId(), $fieldOptions->getOptions()['opt3']->getId());
		$this->assertEquals($optThree->getLabel(), $fieldOptions->getOptions()['opt3']->toArray()['label']);
	}
	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldOptions::getOptions();
	 * @covers \calderawp\caldera\Forms\Field\FieldOptions::addOption();
	 */
	public function testGetOptions()
	{
		$fieldOptions = new FieldOptions();
		$optTwo = $this->optionTwo();
		$fieldOptions->addOption($optTwo);
		$fieldOptions->addOption($this->optionOne());

		$this->assertCount(2, $fieldOptions->getOptions());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldOptions::hasOption();
	 */
	public function testHasOption()
	{
		$fieldOptions = new FieldOptions();
		$optTwo = $this->optionTwo();
		$fieldOptions->addOption($optTwo);
		$this->assertTrue(is_string($optTwo->getId()));

		$this->assertTrue($fieldOptions->hasOption($optTwo->getId()));
		$this->assertFalse($fieldOptions->hasOption($this->optionOne()->getId()));
	}

	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldOptions::getOption();
	 * @covers \calderawp\caldera\Forms\Field\FieldOptions::addOption();
	 */
	public function testGetOption()
	{
		$fieldOptions = new FieldOptions();
		$optTwo = $this->optionTwo();
		$fieldOptions->addOption($optTwo);
		$fieldOptions->addOption($this->optionOne());
		$this->assertEquals($optTwo, $fieldOptions->getOption($optTwo->getId()));
	}
}
