<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\Field\FieldOption;

class FieldOptionTest extends TestCase
{

	public function testSetGetCalculationValue()
	{

		$option = new FieldOption();
		$option->setCalculationValue(2);
		$this->assertEquals(2, $option->getCalculationValue());
	}

	public function testGetCalculationValueFromValue()
	{
		$option = new FieldOption();
		$option->setValue(2);
		$this->assertEquals(2, $option->getCalculationValue());

		$option = new FieldOption();
		$option->setValue('2');
		$this->assertEquals(2, $option->getCalculationValue());
	}

	public function testId()
	{
		$option = new FieldOption();
		$id = 'opt33';
		$option->setId($id);
		$this->assertEquals($id, $option->getId());
	}

	public function testFromArray()
	{
		$id = 'op1';
		$value = 'Roy';
		$label = 'Name';
		$calcValue = 42;
		$option = FieldOption::fromArray([
			'id' => $id,
			'value' => $value,
			'label' => $label,
			'calcValue' => $calcValue
		]);
		$this->assertSame($id, $option->getId());
		$this->assertSame($value, $option->getValue());
		$this->assertSame($label, $option->getLabel());
		$this->assertSame($calcValue, $option->getCalculationValue());
	}


	public function testToArray()
	{
		$id = 'op1';
		$value = 'Roy';
		$label = 'Name';
		$calcValue = 42;
		$option = FieldOption::fromArray([
			'id' => $id,
			'value' => $value,
			'label' => $label,
			'calcValue' => $calcValue
		]);
		$arrayed = $option->toArray();
		$this->assertSame($id, $arrayed[ 'id' ]);
		$this->assertSame($value, $arrayed[ 'value' ]);
		$this->assertSame($label, $arrayed[ 'label' ]);
		$this->assertSame($calcValue, $arrayed[ 'calcValue' ]);
	}
}
