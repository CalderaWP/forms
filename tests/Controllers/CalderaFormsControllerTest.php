<?php


namespace calderawp\caldera\Forms\Tests\Controllers;

use calderawp\caldera\Forms\Controllers\EntryController;
use calderawp\caldera\Forms\Tests\TestCase;
use calderawp\interop\Tests\Mocks\MockRequest;

class CalderaFormsControllerTest extends TestCase
{
	/**
	 * @covers \calderawp\caldera\Forms\Controllers\CalderaFormsController::applyFilters()
	 * @covers \calderawp\caldera\Forms\Controllers\CalderaFormsController::addFilter()
	 */
	public function testFilterAccesors()
	{
		$results = new \stdClass();

		$calderaForms = $this->calderaForms();
		$filterName = 'noms';
		$controller = \caldera()->getEvents()->getHooks();
		$controller->addFilter($filterName, function ($arg, $arg2) use ($results) {
			$results->one = true;
			$results->oneArg2 = $arg2;
			return 5;
		}, 10, 2);
		$this->assertSame(
			5,
			$controller->applyFilters($filterName, null, 22)
		);
		$this->assertTrue($results->one);
		$this->assertSame(22, $results->oneArg2);


		$controller = new EntryController($calderaForms);
		$filterName2 = 'test2';
		$controller->addFilter($filterName2, function ($arg) use ($results) {
			$results->two = true;
			return 7;
		});
		$returnValue = $controller->applyFilters($filterName2, null);
		$this->assertTrue($results->two);
		$this->assertSame(7, $returnValue);


		$controller = new EntryController($calderaForms);
		$filterName2 = 'test2';
		$controller->addFilter($filterName2, function ($arg) use ($results) {
			$results->two = true;
			return 7;
		});
		$returnValue = $controller->applyFilters($filterName2, null);
		$this->assertTrue($results->two);
		$this->assertSame(7, $returnValue);

		$controller = new EntryController($calderaForms);

		$filterName3 = 'test3';
		$controller->addFilter($filterName3, function ($arg) use ($results) {
			$results->three = true;
			return 33;
		});
		$returnValue = $controller->applyFilters($filterName3, null);
		$this->assertTrue($results->three);
		$this->assertSame(33, $returnValue);
	}

	public function testFilterA()
	{
		$results = new \stdClass();

		$controller = new EntryController($this->calderaForms());

		$filterName4 = 'test4';
		$controller->addFilter($filterName4, function ($arg, $request) use ($results) {
			$results->four = true;
			$results->fourRequest = $request;
			return 333;
		}, 10, 2);
		$request = new MockRequest();

		$returnValue = $controller->applyFilters($filterName4, null, 221);
		$this->assertTrue($results->four);
		$this->assertSame(333, $returnValue);
		$this->assertSame($request, $results->fourRequest);
	}
}
