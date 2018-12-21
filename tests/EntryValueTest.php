<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\Entry\EntryValue;

class EntryValueTest extends TestCase
{


	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::__construct()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::setField()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::setForm()
	 */
	public function test__construct()
	{
		$form = $this->form();
		$field = $this->field('fld2334', [], $form);
		$entryValue = new EntryValue($form, $field);
		$this->assertEquals($form, $entryValue->getForm());
		$this->assertEquals($field, $entryValue->getField());
		$this->assertAttributeEquals($form, 'form', $entryValue);
		$this->assertAttributeEquals($field, 'field', $entryValue);
	}

	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::getValue()
	 */
	public function testGetValue()
	{
		$form = $this->form();
		$field = $this->field('fld2334', [], $form);
		$entryValue = new EntryValue($form, $field);
		$value = 'sdfjl';
		$entryValue->setValue($value);
		$this->assertEquals($value, $entryValue->getValue());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::getValue()
	 */
	public function testGetValueFromFieldDefault()
	{
		$form = $this->form();
		$default = 'Hi Roy';
		$field = $this->field('fld2334', ['default' => $default ], $form);
		$this->assertEquals($default, $field->getDefault());
		$entryValue = new EntryValue($form, $field);
		$this->assertEquals($default, $entryValue->getValue());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::getSlug()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::getFieldSlug()
	 */
	public function testGetFieldSlug()
	{
		$value = 'fak';
		$slug = 'dasl_kghf';
		$entryValue = $this->entryValue($value);
		$entryValue->setSlug($slug);
		$this->assertEquals($slug, $entryValue->getSlug());
		$this->assertEquals($slug, $entryValue->getFieldSlug());
	}
	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::getField()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::setField()
	 */
	public function testGetField()
	{
		$form = $this->form();
		$field = $this->field('fld2334', [], $form);
		$entryValue = new EntryValue($form, $field);
		$this->assertEquals($field, $entryValue->getField());
	}

	public function testSetField()
	{
		$form = $this->form();
		$field = $this->field('fld2334', [], $form);
		$entryValue = new EntryValue($form, $field);

		$field2 = $this->field('fld48a', [], $form);
		$entryValue->setField($field2);
		$this->assertEquals($field2, $entryValue->getField());
	}

	public function testGetForm()
	{
		$form = $this->form();
		$field = $this->field('fld2334', [], $form);
		$entryValue = new EntryValue($form, $field);
		$this->assertEquals($form, $entryValue->getForm());
	}

	public function testGetFieldId()
	{
		$form = $this->form();
		$field = $this->field('fld2334', [], $form);
		$entryValue = new EntryValue($form, $field);
		$this->assertEquals($field->getId(), $entryValue->getFieldId());
	}
}
