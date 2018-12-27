<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\CalderaForms;
use calderawp\caldera\Forms\Contracts\FormsCollectionContract;
use calderawp\caldera\Forms\Contracts\EntryCollectionContract;
use calderawp\caldera\Forms\Entry\Entry;
use calderawp\caldera\Forms\Exception;
use calderawp\caldera\Forms\Forms\ContactForm;

class CalderaFormsTest extends TestCase
{
	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::registerServices()
	 */
	public function testRegisterServices()
	{
		$calderaForms = $this->calderaForms();
		$this->assertInstanceOf(FormsCollectionContract::class, $calderaForms->getForms());
		$this->assertInstanceOf(EntryCollectionContract::class, $calderaForms->getEntries());
	}
	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::getForms()
	 * @covers \calderawp\caldera\Forms\CalderaForms::registerServices()
	 */
	public function testGetForms()
	{
		$calderaForms = $this->calderaForms();
		$this->assertInstanceOf(FormsCollectionContract::class, $calderaForms->getForms());
		$this->assertCount(1, $calderaForms->getForms()->toArray());
	}



	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::getIdentifier()
	 */
	public function testGetIdentifier()
	{
		$this->assertEquals('calderaForms', $this->calderaForms()->getIdentifier());
	}
	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::findForm()
	 */
	public function testFindFormById()
	{
		$calderaForms = $this->calderaForms();
		$contactForm = new ContactForm();
		$forms = $calderaForms->findForm('id', $contactForm->getId())->toArray();
		$form = $forms[$contactForm->getId()];
		$this->assertEquals($contactForm->getId(), $form['id']);
		$this->assertEquals($contactForm->getName(), $form['name']);
	}
	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::findForm()
	 */
	public function testFindFormByName()
	{
		$calderaForms = $this->calderaForms();
		$contactForm = new ContactForm();
		$forms = $calderaForms->findForm('name', $contactForm->getName())->toArray();
		$form = $forms[$contactForm->getId()];
		$this->assertEquals($contactForm->getName(), $form['name']);
	}
	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::findForm()
	 */
	public function testNotFindFormByName()
	{
		$this->expectException(Exception::class);

		$calderaForms = $this->calderaForms();
		$contactForm = new ContactForm();
		$forms = $calderaForms->findForm('name', 'hats');
	}
	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::findForm()
	 */
	public function testNotFindForm()
	{
		$this->expectException(Exception::class);

		$calderaForms = $this->calderaForms();
		$contactForm = new ContactForm();
		$calderaForms->findForm('id', 'rand');
		$calderaForms->findForm('name', 'rand');
	}

	public function testGetFormsDb()
	{
		$this->markTestSkipped('Not implemented yet');
	}

	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::getEntries()
	 * @covers \calderawp\caldera\Forms\CalderaForms::registerServices()
	 */
	public function testGetEntries()
	{
		$calderaForms = $this->calderaForms();
		$this->assertInstanceOf(EntryCollectionContract::class, $calderaForms->getEntries());
	}

	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::getEntries()
	 * @covers \calderawp\caldera\Forms\EntryCollection::addEntry()
	 */
	public function testAddEntry()
	{
		$calderaForms = $this->calderaForms();
		$entry = Entry::fromArray(['id' => 5, 'formId' => 'cf1' ]);
		$calderaForms
			->getEntries()
			->addEntry($entry);
		$this->assertEquals(
			5,
			$calderaForms
				->getEntries()
				->getEntry(5)
				->getId()
		);
	}

	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::getEntries()
	 * @covers \calderawp\caldera\Forms\EntryCollection::findEntryBy()
	 */
	public function testGetEntryByEntryIdId()
	{
		$calderaForms = $this->calderaForms();
		$formId = 'cf1';
		$formId2 = 'cf2';
		$entry = Entry::fromArray(['id' => 5, 'formId' => 'cf1' ]);
		$entry2FromForm = Entry::fromArray(['id' => 7, 'formId' => 'cf1' ]);
		$entryNotFromThisForm = Entry::fromArray(['id' => 6, 'formId' => $formId2 ]);
		$calderaForms
			->getEntries()
			->addEntry($entry2FromForm)
			->addEntry($entryNotFromThisForm)
			->addEntry($entry);

		$this->assertCount(1, $calderaForms->findEntryBy('id', 7)->toArray());
	}

	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::getEntries()
	 * @covers \calderawp\caldera\Forms\EntryCollection::findEntryBy()
	 */
	public function testGetEntryByFormId()
	{
		$calderaForms = $this->calderaForms();
		$formId = 'cf1';
		$formId2 = 'cf2';
		$entry = Entry::fromArray(['id' => 5, 'formId' => 'cf1' ]);
		$entry2FromForm = Entry::fromArray(['id' => 7, 'formId' => 'cf1' ]);
		$entryNotFromThisForm = Entry::fromArray(['id' => 6, 'formId' => $formId2 ]);
		$calderaForms
			->getEntries()
			->addEntry($entry2FromForm)
			->addEntry($entryNotFromThisForm)
			->addEntry($entry);

		$this->assertCount(2, $calderaForms->findEntryBy('formId', $formId)->toArray());
	}
}
