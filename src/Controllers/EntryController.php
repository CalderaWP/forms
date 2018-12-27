<?php


namespace calderawp\caldera\Forms\Controllers;

use calderawp\caldera\Forms\Exception;
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
		if (!is_null($entry)) {
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
		if (!is_null($entries)) {
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
