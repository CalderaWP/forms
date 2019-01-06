<?php


namespace calderawp\caldera\Forms\Filters;

use calderawp\caldera\Forms\Contracts\EntryContract as Entry;
use calderawp\caldera\Forms\Contracts\FormModelContract as Form;
use calderawp\caldera\Forms\Entry\EntryValue;
use calderawp\caldera\Forms\FieldsArrayLike;
use calderawp\caldera\Forms\Processing\Processor;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;

use calderawp\interop\Contracts\WordPress\ApplysFilters;

class ProcessSubmissionFilters extends FilterFormData implements \calderawp\caldera\Forms\Contracts\ProcessSubmissionFiltersContract
{

	/** @inheritdoc */
	public function addHooks(ApplysFilters $filters): void
	{

		$filtersToHook = ["caldera/forms/createEntry"];

		foreach ($filtersToHook as $filterName) {
			$filters
				->addFilter(
					$filterName,
					[$this, 'validateFields'],
					ProcessEventPriorities::SAVE,
					3
				);
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
					[$this, 'mainProcess'],
					ProcessEventPriorities::PRE_PROCESS,
					3
				);
			$filters
				->addFilter(
					$filterName,
					[$this, 'postProcess'],
					ProcessEventPriorities::POST_PROCESS,
					3
				);
		}
	}


	/**
	 * Process field validation
	 *
	 * @todo Impliment, possibly in another place.
	 *
	 * @param Entry|null $entry
	 * @param Request $request
	 * @param Form $form
	 *
	 * @return Entry|null
	 */
	public function validateFields(?Entry $entry, Request $request, Form $form): ?Entry
	{

		return $entry;
	}


	/**
	 * Dispatch pre-processor callbacks
	 *
	 * Pre-processors should mutate Request and/or throw exceptions if Request is invalid.
	 *
	 * @param Entry|null $entry Entry object or null, probably null
	 * @param Request $request Current request
	 * @param Form $form Form model
	 *
	 * @return Entry|null
	 */
	public function preProcess(?Entry $entry, Request $request, Form $form): ?Entry
	{

		$processors = $form->getProcessors();

		if (empty($processors->toArray())) {
			return $entry;
		}
		$formFields = $this->createFieldsArrayLike($entry);
		/** @var Processor $processor */
		foreach ($processors as $processor) {
			$formFields = $processor->preProcess($formFields, $request);
		}


		foreach ($formFields as $fieldId => $fieldValue) {
			$request->setParam($fieldId, $fieldValue);
		}
		return $entry;
	}

	/**
	 * Dispatch main processor callbacks
	 *
	 * If the FieldsArrayLike changes when returned, entry values will change to match.
	 *
	 * @param Entry|null $entry Entry object or null, probably not null
	 * @param Request $request Current request
	 * @param Form $form Form model
	 *
	 * @return Entry|null
	 */
	public function mainProcess(?Entry $entry, Request $request, Form $form): ?Entry
	{
		$processors = $form->getProcessors();
		if (empty($processors)) {
			return $entry;
		}

		$formFields = $this->createFieldsArrayLike($entry);
		/** @var Processor $processor */
		foreach ($processors as $processor) {
			$formFields = $processor->mainProcess($formFields, $request);
		}

		if ($entry) {
			$entry = $this->updateEntryFromFormFields($entry, $formFields);
		}

		return $entry;
	}

	/**
	 * Dispatch post-processor callbacks
	 *
	 * If the FieldsArrayLike changes when returned, entry values will change to match.
	 *
	 * @param Entry|null $entry Entry object or null, probably not null
	 * @param Request $request Current request
	 * @param Form $form Form model
	 *
	 * @return Entry|null
	 */
	public function postProcess(?Entry $entry, Request $request, Form $form): ?Entry
	{
		$processors = $form->getProcessors();
		if (empty($processors)) {
			return $entry;
		}

		$formFields = $this->createFieldsArrayLike($entry);
		/** @var Processor $processor */
		foreach ($processors as $processor) {
			$formFields = $processor->postProcess($formFields, $request);
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
			$fields = $entry->getFieldsAsArrayLike();
		} else {
			$fields = new FieldsArrayLike([]);
		}
		return $fields;
	}


	/**
	 * Update any entry value that is possible with current formfields array like that is supplied to this method.
	 *
	 * @param Entry|null $entry
	 * @param $formFields
	 *
	 * @return Entry
	 */
	protected function updateEntryFromFormFields(?Entry $entry, $formFields): Entry
	{
		/** @var EntryValue $entryValue */
		foreach ($entry->getEntryValues() as $entryValue) {
			$fieldId = $entryValue->getField()->getId();
			if (isset($formFields[$fieldId])) {
				$entryValue->setValue($formFields[$fieldId]);
			}
		}

		return $entry;
	}
}
