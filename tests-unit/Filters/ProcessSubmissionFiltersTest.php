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
		$processors = 		 \Mockery::mock('Processors', \calderawp\caldera\Forms\Processing\ProcessorCollection::class );
		$processors->shouldReceive('toArray' )->andReturn([]);
		$form = \Mockery::mock('Form', Form::class );
		$form->shouldReceive( 'getProcessors' )
			->andReturn( $processors);
		$request = \Mockery::mock('Request', Request::class );
		$entry = \Mockery::mock('Entry', Entry::class );
		$dataSource = \Mockery::mock('DataSource', FormsDataSources::class );
		$filterer = new ProcessSubmissionFilters($dataSource);
		$this->assertSame( $entry, $filterer->preProcess($entry, $request,$form));

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
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::mainProcess()
	 */
	public function testProcess()
	{
		$processors = 		 \Mockery::mock('Processors', \calderawp\caldera\Forms\Processing\ProcessorCollection::class );
		$processors->shouldReceive('toArray' )->andReturn([]);
		$processors->shouldReceive('getIterator' )->andReturn(
			 new \ArrayIterator([])
		);
		$form = \Mockery::mock('Form', Form::class );
		$form->shouldReceive( 'getProcessors' )
			->andReturn( $processors);
		$request = \Mockery::mock('Request', Request::class );
		$fieldsArrayLike = \Mockery::mock('Fields', \calderawp\caldera\Forms\FieldsArrayLike::class );
		$entry = \Mockery::mock('Entry', Entry::class );
		$entryValues = \Mockery::mock( 'EntryValues', \calderawp\caldera\Forms\Entry\EntryValues::class);
		$entryValues->shouldReceive( 'getIterator' )->andReturn( new \ArrayIterator([]) );
		$entry->shouldReceive( 'getEntryValues' )->andReturn($entryValues);
		$entry->shouldReceive('getFieldsAsArrayLike' )->andReturn($fieldsArrayLike);
		$dataSource = \Mockery::mock('DataSource', FormsDataSources::class );
		$filterer = new ProcessSubmissionFilters($dataSource);
		$this->assertSame( $entry, $filterer->mainProcess($entry, $request,$form));
	}

	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::postProcess()
	 */
	public function testPostProcess()
	{
		$processors = 		 \Mockery::mock('Processors', \calderawp\caldera\Forms\Processing\ProcessorCollection::class );
		$processors->shouldReceive('toArray' )->andReturn([]);
		$processors->shouldReceive('getIterator' )->andReturn(
			new \ArrayIterator([])
		);
		$form = \Mockery::mock('Form', Form::class );
		$form->shouldReceive( 'getProcessors' )
			->andReturn( $processors);
		$request = \Mockery::mock('Request', Request::class );
		$fieldsArrayLike = \Mockery::mock('Fields', \calderawp\caldera\Forms\FieldsArrayLike::class );
		$entry = \Mockery::mock('Entry', Entry::class );
		$entryValues = \Mockery::mock( 'EntryValues', \calderawp\caldera\Forms\Entry\EntryValues::class);
		$entryValues->shouldReceive( 'getIterator' )->andReturn( new \ArrayIterator([]) );
		$entry->shouldReceive( 'getEntryValues' )->andReturn($entryValues);
		$entry->shouldReceive('getFieldsAsArrayLike' )->andReturn($fieldsArrayLike);
		$dataSource = \Mockery::mock('DataSource', FormsDataSources::class );
		$filterer = new ProcessSubmissionFilters($dataSource);
		$this->assertSame( $entry, $filterer->postProcess($entry, $request,$form));
	}
}
