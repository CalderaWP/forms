<?php

namespace calderawp\caldera\Forms\Tests\Controllers;

use calderawp\caldera\Forms\CalderaForms;
use calderawp\caldera\Forms\Controllers\FormsController;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\caldera\Forms\Tests\TestCase;
use calderawp\interop\Tests\Mocks\MockRequest;
use calderawp\interop\Tests\Mocks\MockRestResponse;

class FormsControllerTest extends TestCase
{

	public function testResponseToForm()
	{

		$container = $this->serviceContainer();
		$calderaForms = new CalderaForms($container);
		$controller = new FormsController($calderaForms);
		/** @var FormModel $form */
		$form = \Mockery::mock('Form', FormModel::class);
		$response = new MockRestResponse();
		$form->shouldReceive('toResponse')->andReturn($response);

		$controller->responseToForm($form);
		$this->addToAssertionCount(1);
	}

	public function testGetForm()
	{

		$container = $this->serviceContainer();
		$calderaForms = new CalderaForms($container);

		$formId = 'cf1';
		$controller = new FormsController($calderaForms);
		$request = new MockRequest();
		/** @var FormModel $form */
		$form = \Mockery::mock('Form', FormModel::class);

		$form->shouldReceive('fromArray')->andReturn([
			'id' => $formId
		]);
		$response = new MockRestResponse();
		$form->shouldReceive('responseToForm')->andReturn($response);

		$controller->getForm($form, $request);
		$this->addToAssertionCount(1);
	}

	public function testGetFormNotNull()
	{
		$form = $this->form('cf1');
		$container = $this->serviceContainer();
		$calderaForms = new CalderaForms($container);

		$controller = new FormsController($calderaForms);
		$request = new MockRequest();
		$this->assertSame($form, $controller->getForm($form, $request));
	}
	public function testGetCalderaForms()
	{
		$container = $this->serviceContainer();
		$calderaForms = new CalderaForms($container);
		$controller = new FormsController($calderaForms);
		$this->assertEquals($calderaForms, $controller->getCalderaForms());
	}


	public function testCreateForm()
	{
		$form = $this->form('cf1');
		$container = $this->serviceContainer();
		$calderaForms = new CalderaForms($container);

		$controller = new FormsController($calderaForms);
		$request = new MockRequest();
		$this->assertSame($form, $controller->createForm($form, $request));
	}

	public function testGetForms()
	{
		$this->markTestSkipped('The mocks in all of these test make them meaningless');

		/** @var FormsCollection $forms */
		$forms = \Mockery::mock('Forms', FormsCollection::class);
		$container = $this->serviceContainer();
		$calderaForms = new CalderaForms($container);

		$controller = new FormsController($calderaForms);
		$request = new MockRequest();
		$this->assertSame($forms, $controller->getForms(null, $request));
	}

	public function testDeleteForm()
	{
		$this->markTestSkipped('Must create DB package');
	}
}
