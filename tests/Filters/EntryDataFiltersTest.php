<?php

namespace calderawp\caldera\Forms\Tests\Filters;

use calderawp\caldera\Forms\DataSources\FormsDataSources;
use calderawp\caldera\Forms\Tests\TestCase;
use calderawp\caldera\WordPressPlugin\Filters\EntryDataFilters;

class EntryDataFiltersTest extends TestCase
{

	public function testCreateEntry()
	{
		$dataSource = \Mockery::mock('FormsDataSources', FormsDataSources::class);
		$entryDataSource = \Mockery::mock('SourceContract', \calderawp\caldera\DataSource\Contracts\SourceContract::class)
			->shouldReceive('create')
			->andReturn(7);

		$expectedEntry = \Mockery::mock('Entry', \calderawp\caldera\Forms\Contracts\EntryContract::class);
		$entryDataSource
			->shouldReceive('create')
			->andReturn(7);
		$entryDataSource
			->shouldReceive('read')
			->andReturn($expectedEntry);
		$dataSource
			->shouldReceive('getEntryDataSource')
			->andReturn($entryDataSource);


		$entryDataFilters = new EntryDataFilters(
			$this->core()->getEvents()->getHooks(),
			$dataSource
		);
		$request = \Mockery::mock('Request', \calderawp\caldera\restApi\Request::class);
		$request
			->shouldReceive('getParam')
			->andReturn('contact-form');
		$entry = $entryDataFilters->createEntry(null, $request);
		$this->assertSame($expectedEntry, $entry);
	}

	public function testGetEntries()
	{
	}
}
