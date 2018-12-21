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
	 * @covers \calderawp\caldera\Forms\FieldsCollection::fromArray()
	 */
	public function testFromArray()
	{
		$fields = $this->getFields();
		$collection = FieldsCollection::fromArray([
			'fields' => $fields,
		]);
		$this->assertAttributeEquals($fields, 'items', $collection);
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
		$this->assertEquals($field1, $array[ $field1Id ]);
		$this->assertEquals($field2, $array[ $field2Id ]);
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
