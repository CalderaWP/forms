<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\Entry\Entry;
use calderawp\caldera\Forms\Entry\EntryValue;
use calderawp\caldera\Forms\Entry\EntryValues;
use calderawp\caldera\Forms\FormModel;
use calderawp\interop\Tests\Mocks\MockRequest;

class EntryTest extends TestCase
{


	/**
	 * @covers \calderawp\caldera\Forms\Entry\Entry::getFormId()
	 */
	public function testGetFormId()
	{
		$formId = 'cf1';
		$entry = new Entry();
		$entry->setFormId($formId);
		$this->assertSame($formId, $entry->getFormId());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Entry\Entry::getEntryValues()
	 * @covers \calderawp\caldera\Forms\Entry\Entry::setEntryValues()
	 */
	public function testGetSetEntryValues()
	{
		$form = $this->form();
		$fieldId1 = 'f1';
		$fieldId2 = 'f12';
		$entryId1 = 11 + rand(2, 8);
		$entryId2 = 22 + rand(10, 20);
		$field = $this->field($fieldId1, [], $form);
		$field2 = $this->field($fieldId2, [], $form);

		$entryValue = (new EntryValue($form, $field))->setId($entryId1);
		$entryValue->setValue('e1');
		$this->assertSame('e1', $entryValue->getValue());
		$entryValue2 = (new EntryValue($form, $field2))->setId($entryId2);
		$entryValue2->setValue('e2');
		$this->assertSame('e2', $entryValue2->getValue());


		$entryValues = (new EntryValues())->addValue($entryValue)->addValue($entryValue2);

		$entry = (new Entry())->setEntryValues($entryValues);
		$entry->setFormId('cf1' );

		$this->assertAttributeEquals($entryValues, 'entryValues', $entry);
		$this->assertSame($entryValues, $entry->getEntryValues());

		$this->assertSame([
			'e1', 'e2'
		],array_values($entry->valuesToArray()));
	}

	/**
	 * @covers \calderawp\caldera\Forms\Entry\Entry::toArray()
	 * @covers \calderawp\caldera\Forms\Entry\Entry::getEntryValues()
	 * @covers \calderawp\caldera\Forms\Entry\Entry::getId()
	 * @covers \calderawp\caldera\Forms\Entry\Entry::getFormId()
	 * @covers \calderawp\caldera\Forms\Entry\Entry::getDate()
	 */
	public function testToArray()
	{
		$formId = 'cf1';
		$form = $this->form($formId);
		$fieldId1 = 'f1';
		$fieldId2 = 'f12';
		$entryId1 = 11 + rand(2, 8);
		$entryId2 = 22 + rand(10, 20);
		$field = $this->field($fieldId1, [], $form);
		$field2 = $this->field($fieldId2, [], $form);
		$entryValue = (new EntryValue($form, $field))->setId($entryId1);
		$entryValue2 = (new EntryValue($form, $field2))->setId($entryId2);
		$entryValues = (new EntryValues())->addValue($entryValue)->addValue($entryValue2);
		$date = new \DateTimeImmutable(date(Entry::DATE_FORMAT, time()));
		$entryId = 1;
		$entry = (new Entry())->setEntryValues($entryValues);
		$entry->setDate($date)
			->setId($entryId)
			->setFormId($formId);
		$array = $entry->toArray();
		$this->assertEquals($entryId, $array[ 'id' ]);
		$this->assertEquals($formId, $array[ 'formId' ]);
		$this->assertEquals($date->format(Entry::DATE_FORMAT), $array[ 'date' ]);
		$this->assertEquals(2, count($array[ 'entryValues' ]));
	}



	/**
	 * @covers \calderawp\caldera\Forms\Entry\Entry::toResponse()
	 */
	public function testToResponse()
	{
		$formId = 'cf1';
		$form = new FormModel();
		$form->setId($formId);
		$fieldId1 = 'f1';
		$fieldId2 = 'f12';
		$entryId1 = 11 + rand(2, 8);
		$entryId2 = 22 + rand(10, 20);
		$field = $this->field($fieldId1, [], $form);
		$field2 = $this->field($fieldId2, [], $form);
		$entryValue = (new EntryValue($form, $field))->setId($entryId1);
		$entryValue2 = (new EntryValue($form, $field2))->setId($entryId2);
		$entryValues = (new EntryValues())->addValue($entryValue);
		$date = new \DateTimeImmutable(date(Entry::DATE_FORMAT, time()));
		$entryId = 1;
		$entry = (new Entry())
			->setEntryValues($entryValues)
			->setDate($date)
			->setFormId($formId)
			->setId($entryId);
		$response = $entry->toResponse();
		$this->assertEquals($entryId, $response->getData()['id']);
	}


	/**
	 * @covers \calderawp\caldera\Forms\Entry\Entry::fromArray()
	 * @covers \calderawp\caldera\Forms\Entry\Entry::setEntryValuesFromArray()
	 * @covers \calderawp\caldera\Forms\Entry\Entry::setFormId()
	 * @covers \calderawp\caldera\Forms\Entry\Entry::setId()
	 * @covers \calderawp\caldera\Forms\Entry\Entry::setDate()
	 */
	public function testFromArray()
	{
		$formId = 'cf1';
		$form = $this->form($formId);
		$fieldId1 = 'f1';
		$fieldId2 = 'f12';
		$entryValue1Id = 11 + rand(2, 8);
		$entryValue2Id = 22 + rand(10, 20);
		$field = $this->field($fieldId1, [], $form);
		$field2 = $this->field($fieldId2, [], $form);
		$entryValue = (new EntryValue($form, $field))->setId($entryValue1Id);
		$entryValue2 = (new EntryValue($form, $field2))->setId($entryValue2Id);
		$entryValues = (new EntryValues())->addValue($entryValue)->addValue($entryValue2);
		$entryId = 4;
		$time = new \DateTime(date(Entry::DATE_FORMAT));
		$entry = Entry::fromArray([
			'formId' => $formId,
			'entryValues' => $entryValues,
			'id' => $entryId,
			'date' => $time,
		]);

		$this->assertEquals($formId, $entry->getFormId());
		$this->assertEquals($entryValues, $entry->getEntryValues());
		$this->assertEquals($entryId, $entry->getId());
		$this->assertEquals($time, $entry->getDate());

		$this->assertSame(2, count($entryValues->toArray()));
		$entry = Entry::fromArray([
			'formId' => $formId,
			'entryValues' => $entryValues->toArray(),
			'id' => $entryId,
			'date' => $time->format(Entry::DATE_FORMAT),
		]);


		$this->assertEquals($formId, $entry->getFormId());
		$this->assertEquals(\calderawp\caldera\Forms\Entry\EntryValues::class, get_class($entry->getEntryValues()));
		$this->assertEquals($entryId, $entry->getId());
		$this->assertEquals($time, $entry->getDate());
	}

	/**
	 * @covers Entry::setDate()
	 */
	public function testGetSetDate()
	{
		$entry = new Entry();
		$date = new \DateTimeImmutable();
		$entry->setDate($date);
		$this->assertAttributeEquals($date, 'date', $entry);
		$this->assertEquals($date, $entry->getDate());
	}

	/**
	 * @covers Entry::setDate()
	 */
	public function testGetSetDateFromString()
	{
		$entry = new Entry();
		$date = new \DateTimeImmutable(date(Entry::DATE_FORMAT, time()));
		$entry->setDate($date);
		$entry->setDate($date->format(Entry::DATE_FORMAT));
		$this->assertEquals($date, $entry->getDate());
	}

	/**
	 * @covers Entry::setFormId()
	 */
	public function testSetFormId()
	{
		$formId = 'cf1';
		$entry = new Entry();
		$entry->setFormId($formId);
		$this->assertAttributeEquals($formId, 'formId', $entry);
	}


	/** @covers Entry::fromDatabaseResult() */
	public function testFromDatabaseResult()
	{
		$result = array (
			'id' => '1',
			'form_id' => 'contact-form',
			'user_id' => '7',
			'datestamp' => '2018-12-29 16:06:06',
		);

		$entry = Entry::fromDatabaseResult($result);
		$this->assertSame($result['id'], $entry->getId());
		$this->assertSame($result['form_id'], $entry->getFormId());
		$this->assertSame((int)$result['user_id'], $entry->getUserId());
		$this->assertSame($result['datestamp'], $entry->getDateAsString());
	}

}
