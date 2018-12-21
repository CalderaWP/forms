<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\Field\FieldConfig;
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
		$this->assertEquals($value, $field->getValue($value));
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
		$this->assertEquals($default, $field->getValue($default));
		$field->setValue($value);
		$this->assertEquals($value, $field->getValue($value));
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
		$this->assertEquals($id, $array['id' ]);
		$this->assertEquals($default, $array['default' ]);
		$this->assertEquals($value, $array['value' ]);
		$this->assertEquals($form, $array['form' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::fromArray()
	 * @covers \calderawp\caldera\Forms\FieldModel::getSlug()
	 * @covers \calderawp\caldera\Forms\FieldModel::setSlug()
	 */
	public function testFromArray()
	{
		$default = 'drinks';
		$value = 'food';
		$slug = 'food_type';
		$id = 'fld1';
		$field = FieldModel::fromArray(
			[
				'id' => $id,
				'value' => $value,
				'slug' => $slug,
				'default' => $default
			]
		);
		$this->assertEquals($slug, $field->getSlug());
		$this->assertEquals($id, $field->getId());
		$this->assertEquals($value, $field->getValue());
		$this->assertEquals($default, $field->getDefault());
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::toArray()
	 */
	public function testLabel()
	{
		$label = 'Your Name';
		$field = new FieldModel();
		$field->setLabel($label);
		$this->assertEquals($label, $field->getLabel());
		$array = $field->toArray();
		$this->assertEquals($label, $array[ 'label' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::toArray()
	 */
	public function testDescription()
	{
		$description = 'Type Your Name';
		$field = new FieldModel();
		$field->setDescription($description);
		$this->assertEquals($description, $field->getDescription());
		$array = $field->toArray();
		$this->assertEquals($description, $array[ 'description' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::getFieldConfig()
	 * @covers \calderawp\caldera\Forms\FieldModel::setFieldConfig()
	 * @covers \calderawp\caldera\Forms\FieldModel::toArray()
	 */
	public function testFieldConfig()
	{
		$config = new FieldConfig();
		$options = $this->fieldOptions();
		$field = new FieldModel();
		$field->setFieldConfig($config);
		$this->assertEquals($config, $field->getFieldConfig());

		$field->getFieldConfig()->setOptions($options);
		$this->assertAttributeEquals($options, 'options', $field->getFieldConfig());

		$field->getFieldConfig()->getOptions()->removeOption($this->optionTwo());
		$this->assertFalse($field->getFieldConfig()->getOptions()->hasOption($this->optionTwo()->getId()));

		$arrayed = $field->toArray();
		$this->assertArrayHasKey('fieldConfig', $arrayed);
		$this->assertEquals($config->toArray(), $arrayed['fieldConfig']);
	}
}
