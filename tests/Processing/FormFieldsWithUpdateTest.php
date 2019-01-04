<?php

namespace calderawp\caldera\Forms\Tests\Processing;

use calderawp\caldera\Forms\Processing\FormFieldsWithUpdate;
use calderawp\caldera\Forms\Tests\TestCase;

class FormFieldsWithUpdateTest extends TestCase
{

	public function testUpdateFieldValue()
	{
		$fieldUpdater = \Mockery::mock();
		$fieldUpdater->shouldReceive(
			'update'
		)->andReturn(true);
		$fields = new FormFieldsWithUpdate([
			'fld1' => '1',
			'fld2' => 'two'
		]);
		$fields->setFieldUpdater([$fieldUpdater,'update']);
		$this->assertTrue($fields->updateFieldValue('fld2', 2));
	}

	public function testGetFieldValue()
	{
		$fields = new FormFieldsWithUpdate([
			'fld1' => '1',
			'fld2' => 'two'
		]);

		$this->assertSame('two', $fields->getFieldValue('fld2'));
		$this->assertSame('1', $fields->getFieldValue('fld1'));
	}

	public function testGetFields()
	{
		$_fields = [
			'fld1' => '1',
			'fld2' => 'two'
		];
		$fields = new FormFieldsWithUpdate($_fields);
		$this->assertSame($_fields, $fields->toArray());
	}

	public function testSetFieldUpdater()
	{
		$fieldUpdater = function () {
		};
		$fields = new FormFieldsWithUpdate([
			'fld1' => '1',
			'fld2' => 'two'
		]);
		$fields->setFieldUpdater($fieldUpdater);
		$this->assertAttributeEquals($fieldUpdater, 'fieldUpdater', $fields);
	}

	public function testHasField()
	{
		$fields = new FormFieldsWithUpdate([
			'fld1' => '1',
			'fld2' => 'two'
		]);
		$this->assertTrue($fields->hasField('fld2'));
		$this->assertFalse($fields->hasField('fddd'));
	}
}
