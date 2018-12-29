<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\Entry\EntryValue;
use calderawp\caldera\Forms\FormModel;

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


	public function testGetFormId()
	{
		$formId = 'cf1';
		$form = $this->form($formId);
		$field = $this->field('fld2334', [], $form);
		$entryValue = new EntryValue($form, $field);
		$this->assertSame($formId, $entryValue->getFormId());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::toArray()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::setSlug()
	 * @covers \calderawp\caldera\Forms\FieldModel::fromArray()
	 * @covers \calderawp\caldera\Forms\FormModel::fromArray()
	 */
	public function testToArray()
	{
		$formId = 'cf1';
		$form = $this->form($formId);
		$field = $this->field('fld2334', [], $form);
		$entryValue = new EntryValue($form, $field);
		$value = 'Noms';
		$slug = 'sluggo';
		$id = 9;
		$entryValue->setId($id);
		$entryValue->setValue($value)
			->setSlug($slug)
			->setId($id);

		$array = $entryValue->toArray();
		$this->assertSame($field->getId(), $array['fieldId']);
		$this->assertSame($formId, $array['formId']);
		$this->assertSame($id, $array['id']);
		$this->assertSame($slug, $array['slug']);
		$this->assertSame($value, $array['value']);
	}

	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::toArray()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::setSlug()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::setId()
	 * @covers \calderawp\caldera\Forms\FieldModel::fromArray()
	 * @covers \calderawp\caldera\Forms\FormModel::fromArray()
	 */
	public function testFromArray()
	{
		$formId = 'cf1';
		$form = $this->form($formId);
		$fieldId = 'fld2334';
		$field = $this->field($fieldId, [], $form);
		$value = 'Noms';
		$slug = 'sluggo';
		$id = 9;

		$array = [
			'fieldId' => $fieldId,
			'formId' => $formId,
			'slug' =>$slug,
			'value' => $value,
			'id' => $id
		];

		$entryValue  = EntryValue::fromArray($array);

		$this->assertSame($fieldId, $entryValue->getFieldId());
		$this->assertSame($formId, $entryValue->getFormId());
		$this->assertSame($id, $entryValue->getId());
		$this->assertSame($value, $entryValue->getValue());

		$this->assertEquals($slug, $entryValue->getSlug());
		$this->assertEquals($slug, $entryValue->getFieldSlug());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::toArray()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::setSlug()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::setId()
	 * @covers \calderawp\caldera\Forms\FieldModel::fromArray()
	 * @covers \calderawp\caldera\Forms\FormModel::fromArray()
	 */
	public function testFromArrayWithFieldAndFormModels()
	{
		$formId = 'cf1';
		$form = $this->form($formId);
		$fieldId = 'fld2334';
		$field = $this->field($fieldId, [], $form);
		$value = 'Noms';
		$slug = 'sluggo';
		$id = 9;

		$array = [
			'field' => $field,
			'form' => $form,
			'slug' =>$slug,
			'value' => $value,
			'id' => $id
		];

		$entryValue  = EntryValue::fromArray($array);

		$this->assertEquals($form, $entryValue->getForm());
		$this->assertEquals($field, $entryValue->getField());
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
	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::getField()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::setField()
	 */
	public function testSetField()
	{
		$form = $this->form();
		$field = $this->field('fld2334', [], $form);
		$entryValue = new EntryValue($form, $field);

		$field2 = $this->field('fld48a', [], $form);
		$entryValue->setField($field2);
		$this->assertEquals($field2, $entryValue->getField());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::getForm()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::getFormId()
	 */
	public function testGetForm()
	{
		$formId = 'cf11';
		$form = $this->form($formId);
		$field = $this->field('fld2334', [], $form);
		$entryValue = new EntryValue($form, $field);
		$this->assertEquals($form, $entryValue->getForm());
		$this->assertEquals($formId, $entryValue->getFormId());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::getFieldId()
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::getField()
	 */
	public function testGetFieldId()
	{
		$form = $this->form();
		$field = $this->field('fld2334', [], $form);
		$entryValue = new EntryValue($form, $field);
		$this->assertEquals($field->getId(), $entryValue->getFieldId());
		$this->assertEquals($field->getId(), $entryValue->getField()->getId());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Entry\EntryValue::fromDataBaseResults()
	 */
	public function testFromDatabaseResults(){

		$result = array (
			'id' => '182',
			'entry_id' => '67',
			'field_id' => 'firstName',
			'slug' => 'firstName',
			'value' => 'Roy',
		);
		$form = \Mockery::mock('Form', FormModel::class );
		$entryValue = EntryValue::fromDataBaseResults($result,$form);
		$this->assertSame($entryValue->getEntryId(), (int)$result['entry_id']);
		$this->assertSame($entryValue->getId(), $result['id']);
		$this->assertSame($entryValue->getSlug(), $result['slug']);
		$this->assertSame($entryValue->getValue(), $result['value']);
	}
}
