<?php


namespace calderawp\caldera\Forms\Filters;

use calderawp\caldera\Forms\Contracts\EntryContract as Entry;
use calderawp\caldera\Forms\Contracts\FormModelContract as Form;
use calderawp\caldera\Forms\Entry\EntryValue;
use calderawp\caldera\Forms\FieldsArrayLike;
use calderawp\caldera\Forms\Processing\Processor;
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

		foreach ($filtersToHook as $filterName) {
			$filters
				->addFilter(
					$filterName,
					[$this, 'preProcess'],
					ProcessEventPriorities::VALIDATE_FIELDS,
					3
				);
			$filters
				->addFilter(
					$filterName,
					[$this, 'preProcess'],
					ProcessEventPriorities::PRE_PROCESS,
					3
				);
			$filters
				->addFilter(
					$filterName,
					[$this, 'preProcess'],
					ProcessEventPriorities::PROCESS,
					3
				);
			$filters
				->addFilter(
					$filterName,
					[$this, 'preProcess'],
					ProcessEventPriorities::SAVE,
					3
				);
		}
	}


	public function validateFields(?Entry $entry, Request $request, Form $form): ?Entry
	{

		return $entry;
	}


	public function preProcess(?Entry $entry, Request $request, Form $form): ?Entry
	{

		$processors = $form->getProcessors();
		if( empty( $processors ) ){
			return $entry;
		}

		$formFields = $this->createFieldsArrayLike($entry);
		/** @var Processor $processor */
		foreach ( $processors as $processor ){
			$formFields = $processor->preProcess($formFields, $request );
		}


		foreach ($formFields as $fieldId => $fieldValue ){
			$request->setParam($fieldId,$fieldValue);

		}


		return $entry;
	}

	public function process(?Entry $entry, Request $request, Form $form): ?Entry
	{
		$processors = $form->getProcessors();
		if( empty( $processors ) ){
			return $entry;
		}

		$formFields = $this->createFieldsArrayLike($entry);
		/** @var Processor $processor */
		foreach ( $processors as $processor ){
			$formFields = $processor->mainProcess($formFields, $request );
		}

		if ($entry) {
			$entry = $this->updateEntryFromFormFields($entry, $formFields);
		}

		return $entry;
	}

	public function postProcess(?Entry $entry, Request $request, Form $form): ?Entry
	{
		$processors = $form->getProcessors();
		if( empty( $processors ) ){
			return $entry;
		}

		$formFields = $this->createFieldsArrayLike($entry);
		/** @var Processor $processor */
		foreach ( $processors as $processor ){
			$formFields = $processor->mainProcess($formFields, $request );
		}

		if ($entry) {
			$entry = $this->updateEntryFromFormFields($entry, $formFields);
		}

		return $entry;
	}

	/**
	 * @param Entry|null $entry
	 *
	 * @return FieldsArrayLike|\calderawp\interop\Contracts\FieldsArrayLike
	 */
	protected function createFieldsArrayLike(?Entry $entry)
	{
		if (!is_null($entry)) {
			$formFields = $entry->getFieldsAsArrayLike();
		} else {
			$formFields = new FieldsArrayLike([]);
		}
		return $formFields;
}

	/**
	 * @param Entry|null $entry
	 * @param $formFields
	 */
	protected function updateEntryFromFormFields(?Entry $entry, $formFields): Entry
	{
		foreach ($formFields as $fieldId => $fieldValue) {
			$value = $entry->getEntryValues()->hasValue($fieldId)
				? $entry->getEntryValues()->getValue($fieldId)
				: null;
			if ($value) {
				$value->setValue($fieldValue);
				$entry->getEntryValues()->addValue($value);
			}
		}

		return $entry;
	}
}
