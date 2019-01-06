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
		$this->assertEquals($value, $field->toArray()[ 'value' ]);
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
		$this->assertEquals($id, $array[ 'id' ]);
		$this->assertEquals($default, $array[ 'default' ]);
		$this->assertEquals($value, $array[ 'value' ]);
		$this->assertEquals($form->toArray(), $array[ 'form' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::toArray()
	 */
	public function testToArrayProvidesFieldConfigOptions()
	{
		$field = FieldModel::fromArray([
			'id' => 'agreeToTerms',
			'type' => 'select',
			'label' => 'Agree to terms',
			'description' => 'Compliance is mandatory',
			'fieldConfig' => [
				'multiple' => false,
				'options' => [
					[
						'value' => true,
						'label' => 'Yes',
					],
					[
						'value' => false,
						'label' => 'No',
					],
				],
			],
		]);
		$this->assertCount(2, $field->toArray()[ 'fieldConfig' ][ 'options' ]);
		$this->assertEquals(false, $field->toArray()[ 'fieldConfig' ][ 'multiple' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::toArray()
	 */
	public function testToArrayProvidesFieldConfigAttributes()
	{
		$field = FieldModel::fromArray([

			'id' => 'test1',
			'type' => 'input',
			'html5type' => 'number',
			'slug' => '',
			'label' => '',
			'description' => '',
			'attributes' => [
				'min' => 5,
				'max' => 12,
			],

		]);
		//[
		//		'multiple' => false,
		//		'buttonType' => 'submit',
		//		'html5type' => 'text',
		//		'attributes' => []
		//	]
		$this->assertCount(2, $field->toArray()[ 'fieldConfig' ][ 'attributes' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::toArray()
	 */
	public function testToArrayProvidesFieldConfigHtml5Type()
	{
		$field = FieldModel::fromArray([

			'id' => 'test2',
			'type' => 'input',
			'html5type' => 'number',
			'slug' => '',
			'label' => '',
			'description' => '',
			'attributes' => [
				'min' => 5,
				'max' => 12,
			],

		]);
		$this->assertSame('number', $field->toArray()[ 'fieldConfig' ][ 'html5type' ]);
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
				'default' => $default,
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
		$this->assertEquals($config->toArray(), $arrayed[ 'fieldConfig' ]);
		$this->assertCount(1, $arrayed[ 'fieldConfig' ][ 'options' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::getType()
	 * @covers \calderawp\caldera\Forms\FieldModel::setType()
	 * @covers \calderawp\caldera\Forms\FieldModel::toArray()
	 * @covers \calderawp\caldera\Forms\FieldModel::fromArray()
	 */
	public function testGetSetType()
	{
		$field = new FieldModel();
		$this->assertEquals('text', $field->getType());
		$field->setType('select');
		$this->assertEquals('select', $field->getType());

		$field = FieldModel::fromArray([
			'type' => 'select',
		]);
		$this->assertEquals('select', $field->getType());
		$this->assertEquals('select', $field->toArray()[ 'type' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldModel::fromArray()
	 */
	public function testSetFieldConfigFromArray()
	{
		$options = [
			[
				'label' => 'Yes',
				'value' => true,
			],
			[
				'label' => 'No',
				'value' => false,
			],
		];
		/** @var FieldModel $field */
		$field = FieldModel::fromArray([
			'type' => 'select',
			'fieldConfig' => [
				'options' => $options,
			],
		]);
		$array = $field->toArray();
		$this->assertEquals('select', $field->getType());
		$this->assertEquals('select', $array[ 'type' ]);
		$this->assertCount(2, $field->getFieldConfig()->getOptions()->toArray());
		$this->assertEquals('No', $field->getFieldConfig()->getOptions()->getOption('no')->getLabel());
	}
}
