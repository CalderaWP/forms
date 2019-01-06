<?php

use calderawp\caldera\Forms\Contracts\FormModelContract as Form;

use calderawp\caldera\Forms\Filters\ProcessSubmissionFilters;
use calderawp\caldera\Forms\Contracts\EntryContract as Entry;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;
use calderawp\caldera\Forms\DataSources\FormsDataSources;
class ProcessSubmissionFiltersTest extends \calderawp\caldera\Forms\Tests\TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::preProcess()
	 */
	public function testPreProcess()
	{
		$form = \Mockery::mock('Form', Form::class );
		$request = \Mockery::mock('Request', Request::class );
		$entry = \Mockery::mock('Entry', Entry::class );
		$dataSource = \Mockery::mock('DataSource', FormsDataSources::class );
		$filterer = new ProcessSubmissionFilters($dataSource);
		$this->assertInstanceOf( Entry::class, $filterer->preProcess($entry, $request,$form));

	}

	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::validateFields()
	 */
	public function testValidateFields()
	{
		$form = \Mockery::mock('Form', Form::class );
		$request = \Mockery::mock('Request', Request::class );
		$entry = \Mockery::mock('Entry', Entry::class );
		$dataSource = \Mockery::mock('DataSource', FormsDataSources::class );
		$filterer = new ProcessSubmissionFilters($dataSource);
		$this->assertInstanceOf( Entry::class, $filterer->validateFields($entry, $request,$form));
	}
	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::addHooks()
	 */
	public function testAddHooks()
	{
		//Should be in integration tests
	}
	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::process()
	 */
	public function testProcess()
	{
		$form = \Mockery::mock('Form', Form::class );
		$request = \Mockery::mock('Request', Request::class );
		$entry = \Mockery::mock('Entry', Entry::class );
		$dataSource = \Mockery::mock('DataSource', FormsDataSources::class );
		$filterer = new ProcessSubmissionFilters($dataSource);
		$this->assertInstanceOf( Entry::class, $filterer->process($entry, $request,$form));
	}

	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::postProcess()
	 */
	public function testPostProcess()
	{
		$form = \Mockery::mock('Form', Form::class );
		$request = \Mockery::mock('Request', Request::class );
		$entry = \Mockery::mock('Entry', Entry::class );
		$dataSource = \Mockery::mock('DataSource', FormsDataSources::class );
		$filterer = new ProcessSubmissionFilters($dataSource);
		$this->assertInstanceOf( Entry::class, $filterer->postProcess($entry, $request,$form));
	}
}
