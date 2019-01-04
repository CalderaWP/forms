<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\Field\FieldConfig;

class FieldConfigTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::getOptions()
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::setOptions()
	 */
	public function testSetGetOptions()
	{
		$options = $this->fieldOptions();
		$config = new FieldConfig();
		$config->setOptions($options);
		$this->assertAttributeEquals($options, 'options', $config);
		$this->assertEquals($options, $config->getOptions());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::toArray()
	 */
	public function testFromArray()
	{
		$options = [
			[
				'label' => 'Yes',
				'value' => true
			],
			[
				'label' => 'No',
				'value' => false
			]
		];

		$config = FieldConfig::fromArray(['options' => $options]);
		$this->assertSame('Yes', $config->getOptions()->getOption('yes')->getLabel());
		$this->assertSame('No', $config->getOptions()->getOption('no')->getLabel());
		$this->assertSame('no', $config->getOptions()->getOption('no')->getId());
		$this->assertSame('yes', $config->getOptions()->getOption('yes')->getId());
		$this->assertArrayHasKey('options', $config->toArray());
		$this->assertCount(2, $config->toArray()['options']);
	}

	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::setOtherConfigOption()
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::getOtherConfigOption()
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::isValidOtherConfigOption()
	 */
	public function testGetSetButtonType()
	{
		$fieldArray = [
			'buttonType' => 'next',
		];
		$fieldConfig = FieldConfig::fromArray($fieldArray);
		$this->assertEquals('next', $fieldConfig->getOtherConfigOption('buttonType'));
		$this->assertArrayHasKey('buttonType', $fieldConfig->toArray());
		$this->assertSame('next', $fieldConfig->toArray()['buttonType' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::setOtherConfigOption()
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::getOtherConfigOption()
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::isValidOtherConfigOption()
	 */
	public function testGetSetHtml5Type()
	{
		$fieldArray = [
			'html5type' => 'email',
		];

		$fieldConfig = FieldConfig::fromArray($fieldArray);
		$this->assertEquals('email', $fieldConfig->getOtherConfigOption('html5type'));
		$this->assertArrayHasKey('html5type', $fieldConfig->toArray());
		$this->assertSame('email', $fieldConfig->toArray()['html5type' ]);
	}
	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::setOtherConfigOption()
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::getOtherConfigOption()
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::isValidOtherConfigOption()
	 */
	public function testAllowsAttributes()
	{
		$attributes = [
			'min' => 5,
			'max' => 12
		];
		$fieldArray = [
			'attributes' => $attributes,
		];

		$fieldConfig = FieldConfig::fromArray($fieldArray);
		$this->assertEquals($attributes, $fieldConfig->getOtherConfigOption('attributes'));
		$this->assertSame($attributes, $fieldConfig->toArray()['attributes']);
	}
}
