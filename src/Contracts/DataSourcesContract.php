<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\caldera\DataSource\Contracts\SourceContract as Source;
use WpDbTools\Type\Result;

interface DataSourcesContract
{
	public function getFormsDataSource(): Source;
	public function getEntryDataSource(): Source;
	public function getEntryValuesDataSource(): Source;
}
