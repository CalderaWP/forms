<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FieldsCollection;
use calderawp\interop\Tests\Traits\EntityFactory;

class FieldsCollectionTest extends TestCase
{

	use EntityFactory;

	/**
	 * @covers \calderawp\caldera\Forms\FieldsCollection::setFields()
	 */
	public function testSetFields()
	{

		$fields = $this->getFields();
		$collection = new FieldsCollection();
		$collection->setFields($fields);
		$this->assertAttributeEquals($fields, 'items', $collection);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldsCollection::addField()
	 */
	public function testAddField()
	{
		$field = new FieldModel();
		$collection = new FieldsCollection();
		$collection->addField($field);
		$this->assertAttributeEquals([$field->getId() => $field], 'items', $collection);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldsCollection::hasField()
	 */
	public function testHasField()
	{
		$id = 'fld4';
		$field = new FieldModel();
		$field->setId($id);
		$collection = new FieldsCollection();
		$collection->addField($field);
		$this->assertTrue($collection->hasField($id));
		$id2 = 'fld32';
		$slug2 = 'vroom_nom';
		$field2 = new FieldModel();
		$field2->setId($id2);
		$field2->setSlug($slug2);
		$this->assertEquals($slug2, $field2->getSlug());
		$this->assertFalse($collection->hasField($id2));
		$collection->addField($field2);
		$this->assertTrue($collection->hasField($id2));
		$this->assertTrue($collection->hasField($slug2));
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldsCollection::fromArray()
	 */
	public function testFromArray()
	{
		$fields = $this->getFields();
		$collection = FieldsCollection::fromArray([
			'fields' => $fields,
		]);
		$this->assertAttributeEquals($fields, 'items', $collection);
	}/**
	 * @covers \calderawp\caldera\Forms\FieldsCollection::fromArray()
	 */
	public function testFromArrayWithFieldsAsArray()
	{
		$fieldId = 'fld1';
		$fieldValue = 'fs';
		$field = [
			'id' => $fieldId,
			'value' => $fieldValue,
		];
		$fieldsFromModel = [$field];
		$collection = FieldsCollection::fromArray([
			'fields' => $fieldsFromModel,
		]);
		$this->assertAttributeInstanceOf(FieldsCollection::class, 'items', $collection);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldsCollection::toArray()
	 */
	public function testToArray()
	{
		$field1Id = 'fld1';
		$field1 = new FieldModel();
		$field1->setId($field1Id);
		$field2Id = 'fld12';
		$field2 = new FieldModel();
		$field2->setId($field2Id);
		$collection = new FieldsCollection();
		$collection->addField($field1);
		$collection->addField($field2);
		$array = $collection->toArray();
		$this->assertEquals($field1->toArray(), $array[ $field1Id ]);
		$this->assertEquals($field2->toArray(), $array[ $field2Id ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FieldsCollection::removeField()
	 * @covers \calderawp\caldera\Forms\FieldsCollection::addField()
	 */
	public function testRemoveField()
	{
		$field1Id = 'fld1';
		$field1 = new FieldModel();
		$field1->setId($field1Id);
		$field2Id = 'fld12';
		$field2 = new FieldModel();
		$field2->setId($field2Id);
		$collection = new FieldsCollection();
		$collection->addField($field1);
		$collection->addField($field2);
		$collection->removeField($field1);
		$this->assertTrue($collection->has($field2Id));
		$this->assertFalse($collection->has($field1Id));
	}
}
