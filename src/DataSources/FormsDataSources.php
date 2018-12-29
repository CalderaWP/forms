<?php


namespace calderawp\caldera\Forms\DataSources;

use calderawp\caldera\DataSource\Contracts\SourceContract as Source;
use calderawp\caldera\Forms\ResultHandlers;
use calderawp\DB\Exceptions\InvalidColumnException;
use WpDbTools\Type\Result;

class FormsDataSources implements \calderawp\caldera\Forms\Contracts\DataSourcesContract
{

	protected $formsSource;
	protected $entrySource;
	protected $entryValuesSource;
	protected $resultHandlers;

	public function __construct(Source $formsSource, Source $entrySource, Source $entryValuesSource, ResultHandlers $resultHandlers)
	{
		$this->formsSource = $formsSource;
		$this->entrySource = $entrySource;
		$this->entryValuesSource = $entryValuesSource;
		$this->resultHandlers = $resultHandlers;
	}

	/** @inheritdoc */
	public function getFormsDataSource(): Source
	{
		return $this->formsSource;
	}

	/** @inheritdoc */
	public function getEntryDataSource(): Source
	{
		return $this->entrySource;
	}

	/** @inheritdoc */
	public function getEntryValuesDataSource(): Source
	{

		return $this->entryValuesSource;
	}
}
