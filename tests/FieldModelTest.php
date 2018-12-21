<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FormModel;

class FieldModelTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::getValue()
	 * @covers \calderawp\caldera\Forms\FieldModel::setValue()
	 */
	public function testSetGetValue()
	{
		$field = new FieldModel();
		$value = 'food';
		$field->setValue($value);
		$this->assertEquals($value, $field->getValue($value) );

	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::getValue()
	 * @covers \calderawp\caldera\Forms\FieldModel::setValue()
	 * @covers \calderawp\caldera\Forms\FieldModel::getDefault()
	 * @covers \calderawp\caldera\Forms\FieldModel::setDefault()
	 */
	public function testSetGetDefault()
	{
		$field = new FieldModel();
		$default = 'drinks';
		$value = 'food';
		$field->setDefault($default);
		$this->assertEquals($default, $field->getValue($default) );
		$field->setValue($value);
		$this->assertEquals($value, $field->getValue($value) );

	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::toArray()
	 */
	public function testToArray()
	{
		$field = new FieldModel();
		$default = 'drinks';
		$value = 'food';
		$id = 'fld1';
		$form = new FormModel();
		$field->setForm($form);
		$field->setId($id);
		$field->setDefault($default);
		$field->setValue($value);
		$array = $field->toArray();
		$this->assertEquals( $id, $array['id' ] );
		$this->assertEquals( $default, $array['default' ] );
		$this->assertEquals( $value, $array['value' ] );
		$this->assertEquals( $form, $array['form' ] );
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::fromArray()
	 */
	public function testFromArray()
	{
		$default = 'drinks';
		$value = 'food';
		$id = 'fld1';
		$field = FieldModel::fromArray(
			[
				'id' => $id,
				'value' => $value,
				'default' => $default
			]
		);
		$this->assertEquals($id, $field->getId() );
		$this->assertEquals($value, $field->getValue() );
		$this->assertEquals($default, $field->getDefault() );

	}


}
