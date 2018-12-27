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
		$this->assertEquals($entry->toArray(), $controller->entryToResponse($entry)->getData());
	}

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
		$this->assertEquals($form, $calderaForms->findForm('id', $formId)->getForm($formId));


		$controller = new EntryController($calderaForms);
		$createdEntry = $controller->createEntry(null, $request);
		$this->assertInstanceOf(EntryValues::class, $createdEntry->getEntryValues());
		$this->assertTrue($createdEntry->getEntryValues()->hasValue($fieldId1));
		$this->assertTrue($createdEntry->getEntryValues()->hasValue($fieldId2));
	}
}
