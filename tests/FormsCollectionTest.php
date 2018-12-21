<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\interop\Tests\Traits\EntityFactory;
use calderawp\interop\Contracts\CalderaForms\HasForm as Form;

class FormsCollectionTest extends TestCase
{

	use EntityFactory;

	/**
	 * @covers \calderawp\caldera\Forms\FormsCollection::setForms()
	 */
	public function testSetForms()
	{
		$id = 'cf1';
		$forms = $this->getForms();
		$collection = new FormsCollection();
		$collection->setForms($forms);
		$this->assertAttributeEquals($forms, 'items', $collection);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FormsCollection::addForm()
	 * @covers \calderawp\caldera\Forms\FormsCollection::removeForm()
	 */
	public function testRemoveForm()
	{
		$id = 'cf1';
		$form = new FormModel();
		$form->setId($id);
		$id2= 'cf2';
		$form2 = new FormModel();
		$form2->setId($id2);
		$collection = new FormsCollection();
		$collection->addForm($form);
		$collection->addForm($form2);
		$collection->removeForm($form2);
		$this->assertTrue($collection->has($id));
		$this->assertFalse($collection->has($id2));
	}

	/**
	 * @covers \calderawp\caldera\Forms\FormsCollection::addForm()
	 */
	public function testAddForm()
	{
		$id = 'cf1';
		$form = new FormModel();
		$form->setId($id);
		$collection = new FormsCollection();
		$collection->addForm($form);
		$this->assertAttributeEquals([$form->getId() => $form], 'items', $collection);
	}


	/**
	 * @covers \calderawp\caldera\Forms\FormsCollection::addForm()
	 * @covers \calderawp\caldera\Forms\FormsCollection::getForms()
	 */
	public function testGetForms()
	{
		$id = 'cf1';
		$form = new FormModel();
		$form->setId($id);
		$collection = new FormsCollection();
		$collection->addForm($form);
		$this->assertEquals([$form->getId() => $form], $collection->getForms());
	}
}
