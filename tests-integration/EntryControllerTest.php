<?php

namespace calderawp\caldera\Forms\Tests\Integration;

use calderawp\caldera\Forms\Controllers\EntryController;
use calderawp\caldera\Forms\FormModel;
use calderawp\interop\Tests\Mocks\MockRequest;
use PHPUnit\Framework\TestCase;

class EntryControllerTest extends IntegrationTestCase
{

	/**
	 *
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::getForm()
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::getFormIdFromRequest()
	 * @covers \calderawp\caldera\Forms\Controllers\EntryController::createEntry()
	 * @covers \calderawp\caldera\Forms\Controllers\CalderaFormsController::applyBeforeFilter()
	 */
	public function testCreateEntry()
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
