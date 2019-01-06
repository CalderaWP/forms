<?php


namespace calderawp\caldera\Forms\Filters;

use calderawp\interop\Contracts\FiltersDataSource;
use calderawp\caldera\Forms\DataSources\FormsDataSources;
use calderawp\interop\Traits\ProvidesFormsDataSource;

abstract class FilterFormData implements FiltersDataSource
{
	use ProvidesFormsDataSource;
	/** @var FormsDataSources */
	protected $dataSources;


	public function __construct(FormsDataSources $dataSources)
	{
		$this->dataSources = $dataSources;
	}
}
