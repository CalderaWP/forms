<?php

namespace calderawp\caldera\Forms\Tests\Controllers;

use calderawp\caldera\Forms\Controllers\EntryController;
use calderawp\caldera\Forms\Entry\Entry;
use calderawp\caldera\Forms\Tests\TestCase;
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
}
