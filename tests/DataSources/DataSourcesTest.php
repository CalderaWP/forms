<?php

namespace calderawp\caldera\Forms\Tests\DataSources;

use calderawp\caldera\Forms\DataSources\FormsDataSources;
use calderawp\caldera\Forms\ResultHandlers;
use calderawp\caldera\Forms\Tests\TestCase;
use WpDbTools\Type\TableSchema;
use WpDbTools\Db\Database;
use calderawp\caldera\DataSource\Contracts\SourceContract as Source;

class DataSourcesTest extends TestCase
{

	/** @covers FormsDataSources::getEntryDataSource() */
	public function testGetEntryDataSource()
	{

		$formSource = \Mockery::mock('Source', Source::class);
		$entrySource = \Mockery::mock('Source', Source::class);
		$entryValuesSource = \Mockery::mock('Source', Source::class);
		$resultHandlers = \Mockery::mock('Handlers', ResultHandlers::class);
		$dataSources = new FormsDataSources(
			$formSource,
			$entrySource,
			$entryValuesSource,
			$resultHandlers
		);
		$this->assertSame($entrySource,$dataSources->getEntryDataSource());
	}

	/** @covers FormsDataSources::getEntryValuesDataSource() */
	public function testGetEntryValuesDataSource()
	{
		$formSource = \Mockery::mock('Source', Source::class);
		$entrySource = \Mockery::mock('Source', Source::class);
		$entryValuesSource = \Mockery::mock('Source', Source::class);
		$resultHandlers = \Mockery::mock('Handlers', ResultHandlers::class);
		$dataSources = new FormsDataSources(
			$formSource,
			$entrySource,
			$entryValuesSource,
			$resultHandlers
		);
		$this->assertSame($entryValuesSource,$dataSources->getEntryValuesDataSource());
	}

	/** @covers FormsDataSources::getFormsDataSource() */
	public function testGetFormsDataSource()
	{
		$formSource = \Mockery::mock('Source', Source::class);
		$entrySource = \Mockery::mock('Source', Source::class);
		$entryValuesSource = \Mockery::mock('Source', Source::class);
		$resultHandlers = \Mockery::mock('Handlers', ResultHandlers::class);
		$dataSources = new FormsDataSources(
			$formSource,
			$entrySource,
			$entryValuesSource,
			$resultHandlers
		);
		$this->assertSame($formSource,$dataSources->getFormsDataSource());
	}
}
