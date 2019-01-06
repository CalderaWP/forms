<?php


namespace calderawp\caldera\Forms\Filters;

use calderawp\caldera\Forms\Contracts\EntryContract as Entry;
use calderawp\caldera\Forms\Contracts\FormModelContract as Form;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;

use calderawp\interop\Contracts\FiltersDataSource;
use calderawp\caldera\Forms\DataSources\FormsDataSources;
use calderawp\interop\Contracts\WordPress\ApplysFilters;
use calderawp\interop\Traits\ProvidesFormsDataSource;

class ProcessSubmissionFilters extends FilterFormData
{

	public function addHooks(ApplysFilters $filters): void
	{

		$filtersToHook = ["caldera/forms/createEntry"];

		foreach ( $filtersToHook as $filterName ){
			$filters
				->addFilter(
					$filterName,
					[$this, 'preProcess'],
					ProcessEventPriories::VALIDATE_FIELDS,
					3
				);
			$filters
				->addFilter(
					$filterName,
					[$this, 'preProcess'],
					ProcessEventPriories::PRE_PROCESS,
					3
				);
			$filters
				->addFilter(
					$filterName,
					[$this, 'preProcess'],
					ProcessEventPriories::PROCESS,
					3
				);
			$filters
				->addFilter(
					$filterName,
					[$this, 'preProcess'],
					ProcessEventPriories::SAVE,
					3
				);
		}


	}


	public function validateFields(?Entry $entry, Request $request, Form $form ): Entry
	{
		return $entry;

	}


	public function preProcess(?Entry $entry, Request $request, Form $form ): Entry
	{

		return $entry;

	}

	public function process(?Entry $entry, Request $request, Form $form ): Entry
	{
		return $entry;

	}

	public function postProcess(?Entry $entry, Request $request, Form $form ): Entry
	{
		return $entry;
	}

}
