<?php

namespace calderawp\caldera\Forms\Tests\Controllers;

use calderawp\caldera\Forms\CalderaForms;
use calderawp\caldera\Forms\Controllers\FormsController;
use calderawp\caldera\Forms\Exception;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\Forms\ContactForm;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\caldera\Forms\Tests\TestCase;
use calderawp\interop\Tests\Mocks\MockRequest;
use calderawp\interop\Tests\Mocks\MockRestResponse;
use calderawp\caldera\Forms\Contracts\FormModelContract as Form;

class FormsControllerTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Controllers\FormsController::responseToForm()
	 */
	public function testResponseToForm()
	{

		$calderaForms = $this->calderaForms();

		$controller = new FormsController($calderaForms);
		/** @var FormModel $form */
		$form = \Mockery::mock('Form', FormModel::class);
		$response = new MockRestResponse();
		$form->shouldReceive('toResponse')->andReturn($response);

		$controller->responseToForm($form);
		$this->addToAssertionCount(1);
	}
	/**
	 * @covers \calderawp\caldera\Forms\Controllers\FormsController::getForm()
	 */
	public function testGetForm()
	{

		$calderaForms = $this->calderaForms();

		$controller = new FormsController($calderaForms);
		$request = new MockRequest();
		$request->setParam('formId', ContactForm::ID);
		$form = $controller->getForm(null, $request);
		$this->assertEquals(ContactForm::ID, $form->getId());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Controllers\FormsController::getForm()
	 */
	public function testGetFormNotNull()
	{
		$form = $this->form('cf1');
		$calderaForms = $this->calderaForms();


		$controller = new FormsController($calderaForms);
		$request = new MockRequest();
		$this->assertSame($form, $controller->getForm($form, $request));
	}

	/**
	 * @covers \calderawp\caldera\Forms\Controllers\FormsController::getCalderaForms()
	 */
	public function testCreateForm()
	{
		$calderaForms = $this->calderaForms();
		$this->expectException(Exception::class);
		$controller = new FormsController($calderaForms);
		$controller->createForm(null, new MockRequest());
	}


	public function testGetForms()
	{

		$calderaForms = $this->calderaForms();
		$controller = new FormsController($calderaForms);
		$request = new MockRequest();
		$this->assertSame($calderaForms->getForms(), $controller->getForms(null, $request));
	}

	/**
	 * @covers \calderawp\caldera\Forms\Controllers\FormsController::deleteForm()
	 */
	public function testDeleteForm()
	{
		$calderaForms = $this->calderaForms();

		$this->expectException(Exception::class);

		$controller = new FormsController($calderaForms);
		$controller->deleteForm(null, new MockRequest());
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
		$arg2 = new \stdClass();
		$expectedForm = \Mockery::mock('Form', Form::class);
		$expectedForm2 = \Mockery::mock('Form', Form::class);
		$expectedForms = \Mockery::mock('Forms', FormsCollection::class);
		$value = null;
		$calderaForms = $this->calderaForms();
		$controller = new FormsController($calderaForms);

		$controller->addFilter("caldera/forms/getForm", function ($form, $request) use ($expectedForm, $arg2) {
			$arg2->getForm = $request;
			return $expectedForm;
		}, 10, 2);
		$this->assertSame($expectedForm, $controller->getForm(null, new MockRequest()));
		$this->assertInstanceOf(MockRequest::class, $arg2->getForm);
		$controller->addFilter("caldera/forms/createForm", function () use ($expectedForm2) {
			return $expectedForm2;
		});
		$this->assertSame($expectedForm2, $controller->createForm(null, new MockRequest()));

		$controller->addFilter("caldera/forms/getForms", function () use ($expectedForms) {
			return $expectedForms;
		});
		$this->assertSame($expectedForms, $controller->getForms(null, new MockRequest()));
	}
}
