<?php

namespace calderawp\caldera\Forms\Tests\Controllers;

use calderawp\caldera\Forms\Controllers\EntryController;
use calderawp\caldera\Forms\Entry\Entry;
use calderawp\caldera\Forms\Entry\EntryValues;
use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FieldsCollection;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\Tests\TestCase;
use calderawp\caldera\restApi\Request;
use calderawp\interop\Tests\Mocks\MockRequest;

class EntryControllerTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::getEntries()
	 */
	public function testGetEntries()
	{
		$calderaForms = $this->calderaForms();
		$formId = 'cf1';
		$entries = $calderaForms->getEntries()
			->addEntry(Entry::fromArray(['id' => 1, 'formId' => $formId ]))
			->addEntry(Entry::fromArray(['id' => 2, 'formId' => $formId ]));
		$controller = new EntryController($calderaForms);
		$this->assertEquals($entries, $controller->getEntries(null, new MockRequest()));
	}

	/**
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::getEntries()
	 */
	public function testGetEntriesNotNull()
	{
		$calderaForms = $this->calderaForms();
		$formId = 'cf1';
		$entries = $calderaForms->getEntries()
			->addEntry(Entry::fromArray(['id' => 1, 'formId' => $formId ]))
			->addEntry(Entry::fromArray(['id' => 2, 'formId' => $formId ]));
		$controller = new EntryController($calderaForms);
		$this->assertEquals($entries, $controller->getEntries($entries, new MockRequest()));
	}
	/**
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::getEntry()
	 */
	public function testGetEntry()
	{
		$calderaForms = $this->calderaForms();
		$formId = 'cf1';
		$entry = Entry::fromArray(['id' => 1, 'formId' => $formId ]);
		$entries = $calderaForms->getEntries()
			->addEntry(Entry::fromArray(['id' => 1, 'formId' => $formId ]))
			->addEntry($entry)
			->addEntry(Entry::fromArray(['id' => 5, 'formId' => $formId ]));

		$controller = new EntryController($calderaForms);
		$request = new MockRequest();
		$request->setParam('id', $entry->getId());
		$this->assertEquals($entry, $controller->getEntry(null, $request));
	}
	/**
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::getEntry()
	 */
	public function testGetEntryNotNull()
	{
		$calderaForms = $this->calderaForms();
		$formId = 'cf1';
		$entry = Entry::fromArray(['id' => 1, 'formId' => $formId ]);
		$controller = new EntryController($calderaForms);
		$this->assertEquals($entry, $controller->getEntry($entry, new MockRequest()));
	}

	/**
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::entriesToResponse()
	 */
	public function testEntriesToResponse()
	{
		$calderaForms = $this->calderaForms();
		$formId = 'cf1';
		$calderaForms->getEntries()
			->addEntry(Entry::fromArray(['id' => 1, 'formId' => $formId ]))
			->addEntry(Entry::fromArray(['id' => 2, 'formId' => $formId ]));
		$controller = new EntryController($calderaForms);
		$this->assertCount(2, $controller->entriesToResponse($calderaForms->getEntries())->getData());
	}
	/**
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::entryToResponse()
	 */
	public function testEntryToResponse()
	{
		$calderaForms = $this->calderaForms();
		$formId = 'cf1';
		$entry = Entry::fromArray(['id' => 1, 'formId' => $formId ]);
		$controller = new EntryController($calderaForms);
		$array = $entry->toArray();
		unset($array['userId' ]);
		$this->assertEquals($array, $controller->entryToResponse($entry)->getData());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::entryToResponse()
	 */
	public function testEntryToResponseNotReturnsUserId()
	{
		$calderaForms = $this->calderaForms();
		$formId = 'cf1';
		$entry = Entry::fromArray(['id' => 1, 'formId' => $formId, 'userId' => 112 ]);
		$controller = new EntryController($calderaForms);
		$this->assertArrayNotHasKey('userId', $controller->entryToResponse($entry)->getData());
	}
	/**
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::createEntry()
	 */
	public function testCreateEntry()
	{
		$calderaForms = $this->calderaForms();
		$formId = 'cf1';
		$fieldId1 = 'fld1';
		$field1 = FieldModel::fromArray(['id' => $fieldId1, 'formId' => $formId ]);
		$field1Value = 'hsdfsda';
		$fieldId2 = 'fld2';
		$field2 = FieldModel::fromArray(['id' => $fieldId2, 'formId' => $formId ]);
		$field2Value = 'flsfad';
		$form = new FormModel();
		$form->setId($formId);
		$form->setFields(new FieldsCollection());
		$form->getFields()
			->addField($field1)
			->addField($field2);
		$request = new Request();
		$request->setParams([
			'entryValues' => [
				$fieldId1 => $field1Value,
				$fieldId2 => $field2Value
			],
			'formId' => $formId
		]);

		$calderaForms
			->getForms()
			->addForm($form);
		$this->assertEquals(
			$form,
			$calderaForms
			->findForm('id', $formId)
			->getForm($formId)
		);


		$controller = new EntryController($calderaForms);
		$createdEntry = $controller->createEntry(null, $request);
		$this->assertInstanceOf(EntryValues::class, $createdEntry->getEntryValues());
		$this->assertTrue($createdEntry->getEntryValues()->hasValue($fieldId1));
		$this->assertTrue($createdEntry->getEntryValues()->hasValue($fieldId2));
		$this->assertSame(
			$field1Value,
			$createdEntry->getEntryValues()->getValue($fieldId1)->getValue()
		);
		$this->assertSame(
			$field2Value,
			$createdEntry->getEntryValues()->getValue($fieldId2)->getValue()
		);
	}

	/**
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::createEntry()
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::getEntry()
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::getEntries()
	 * @covers \calderawp\caldera\Forms\Controllers\CalderaFormsController::applyFilters()
	 * @covers \calderawp\caldera\Forms\Controllers\CalderaFormsController::addFilter()
	 */
	public function testFilters()
	{
		$expectedEntry = \Mockery::mock('Entry', Entry::class);
		$expectedEntry2 = \Mockery::mock('Entry', Entry::class);
		$expectedEntries = \Mockery::mock('Entries', \calderawp\caldera\Forms\Contracts\EntryCollectionContract::class);
		$value = null;
		$calderaForms = $this->calderaForms();
		$controller = new EntryController($calderaForms);
		$request = (new MockRequest())
			->setParam('formId', 'contact-form');
		$controller->addFilter("caldera/forms/createEntry", function () use ($expectedEntry) {
			return $expectedEntry;
		});
		$this->assertSame($expectedEntry, $controller->createEntry(null, $request));
		$controller->addFilter("caldera/forms/getEntry", function ($value) use ($expectedEntry2) {
			return $expectedEntry2;
		});
		$this->assertSame($expectedEntry2, $controller->getEntry(null, $request));
		$controller->addFilter("caldera/forms/getEntries", function () use ($expectedEntries) {
			return $expectedEntries;
		});
		$this->assertSame($expectedEntries, $controller->getEntries(null, $request));
	}

	/**
	 * This should be in integration tests
	 *
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::getForm()
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::getFormIdFromRequest()
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::createEntry()
	 * @covers \calderawp\caldera\Forms\Controllers\CalderaFormsController::applyBeforeFilter()
	 */
	public function testGetsForm()
	{
		$controller = new EntryController($this->calderaForms());

		$results = new \stdClass();
		$controller->addFilter("caldera/forms/createEntry", function ($entry, $request, FormModel $formModel) use ($results) {
			$results->filterRan = true;
			$results->formModel = $formModel;
			return $entry;
		}, 20, 3);
		$request = (new MockRequest())
			->setParam('formId', 'contact-form');
		$controller->createEntry(null, $request);
		$this->assertTrue($results->filterRan);
		$this->assertInstanceOf(FormModel::class, $results->formModel);
	}
}
