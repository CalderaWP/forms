<?php


namespace calderawp\caldera\Forms\Controllers;

use calderawp\caldera\Forms\Entry\EntryValue;
use calderawp\caldera\Forms\Entry\EntryValues;
use calderawp\caldera\Forms\Exception;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\caldera\Forms\Tests\EntryTest;
use calderawp\caldera\restApi\Controller;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;
use calderawp\caldera\Forms\Contracts\EntryCollectionContract as Entries;
use calderawp\caldera\Forms\Contracts\EntryContract as Entry;

class EntryController extends CalderaFormsController
{


	/**
	 * Handle request for single entry
	 *
	 * @param Entry|null $entry
	 * @param Request $request
	 *
	 * @return Entry
	 * @throws Exception
	 */
	public function getEntry($entry, Request $request): Entry
	{
		$entry = $this->applyBeforeFilter(__FUNCTION__,$entry,$request);
		if (is_a($entry,Entry::class)) {
			return $entry;
		}

		try {
			$id = $request->getParam('id');
			$entries = $this
				->getCalderaForms()
				->findEntryBy('id', $id);
			return $entries->getEntry($id);
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 * Handle requests to create an entry
	 *
	 * @param Entry|null $entry
	 * @param Request $request
	 *
	 * @return Entry
	 * @throws Exception
	 * @throws \calderawp\interop\Exception
	 */
	public function createEntry(?Entry $entry, Request $request) : Entry
	{
		$entry = $this->applyBeforeFilter(__FUNCTION__,$entry,$request);
		if (is_a($entry,Entry::class)) {
			return $entry;
		}

		try {
			$formId = $request->getParam('formId');
			try {
				$forms = $this->calderaForms->findForm('id', $formId);
				/** @var FormModel $form */
				$form = $forms->getForm($formId);
			} catch (Exception $e) {
				throw $e;
			}
			$entry = new \calderawp\caldera\Forms\Entry\Entry();
			$entry->setFormId($formId);
			$this->addEntryValues($entry, $request, $form);
		} catch (Exception $e) {
			throw $e;
		}

		return $entry;
	}

	/**
	 * Convert request for a single entry result to response
	 *
	 * @param Entry $entry
	 *
	 * @return Response
	 */
	public function entryToResponse(Entry $entry): Response
	{
		return $entry->toResponse();
	}


	/**
	 * Handle request for collection of entries
	 *
	 * @param Entries|null $entries
	 * @param Request $request
	 *
	 * @return Entries
	 */
	public function getEntries($entries, Request $request): Entries
	{
		$entries = $this->applyBeforeFilter(__FUNCTION__,$entries,$request);
		if (is_a($entries,Entries::class)) {
			return $entries;
		}

		return $this
			->getCalderaForms()
			->getEntries();
	}

	/**
	 * Convert results of request for collection of entries to response
	 *
	 * @param Entries $entries
	 *
	 * @return Response
	 */
	public function entriesToResponse(Entries $entries): Response
	{
		return $entries->toResponse();
	}


}
