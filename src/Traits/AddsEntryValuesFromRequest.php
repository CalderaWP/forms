<?php


namespace calderawp\caldera\Forms\Traits;


use calderawp\caldera\Forms\Contracts\EntryContract as Entry;
use calderawp\caldera\Forms\Entry\EntryValue;
use calderawp\caldera\Forms\Entry\EntryValues;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;

trait AddsEntryValuesFromRequest
{
	/**
	 * @param Entry|null $entry
	 * @param Request $request
	 * @param $form
	 */
	protected function addEntryValues(?Entry $entry, Request $request, $form): Entry
	{
		$entryValues = new EntryValues();
		$fieldValues = $request->getParam('entryValues');
		if (!empty($fieldValues)) {
			foreach ($fieldValues as $fieldId => $fieldValue) {
				$field = $form->getFields()->getField($fieldId);
				if ($field) {
					$entryValue = new EntryValue($form, $field);
					$entryValue->setValue($fieldValue);
					$entryValue->setId($fieldId);
					$entryValues->addValue($entryValue);
				}
			}
		}
		$entry->setEntryValues($entryValues);
		return $entry;
	}
}
