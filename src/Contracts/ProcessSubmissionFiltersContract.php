<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\caldera\Forms\Contracts\EntryContract as Entry;
use calderawp\caldera\Forms\Contracts\FormModelContract as Form;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;

interface ProcessSubmissionFiltersContract
{
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
	public function validateFields(?Entry $entry, Request $request, Form $form): ?Entry;
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
	public function preProcess(?Entry $entry, Request $request, Form $form): ?Entry;

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
	public function mainProcess(?Entry $entry, Request $request, Form $form): ?Entry;

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
	public function postProcess(?Entry $entry, Request $request, Form $form): ?Entry;
}
