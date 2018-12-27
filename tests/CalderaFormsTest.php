<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\CalderaForms;
use calderawp\caldera\Forms\Contracts\FormsCollectionContract;
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

	public function testGetEntryBy()
	{
		$this->markTestSkipped('Not implemented yet');
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
		$this->assertEquals($contactForm->getId(), $calderaForms->findForm('id', $contactForm->getId())->getId());
	}
	/**
	 * @covers \calderawp\caldera\Forms\CalderaForms::findForm()
	 */
	public function testFindFormByName()
	{
		$calderaForms = $this->calderaForms();
		$contactForm = new ContactForm();
		$this->assertEquals($contactForm->getId(), $calderaForms->findForm('name', $contactForm->getName())->getId());
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
}
