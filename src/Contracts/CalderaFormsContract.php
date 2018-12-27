<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\interop\Contracts\CalderaModule;
use calderawp\caldera\Forms\Contracts\FormModelContract;
use calderawp\caldera\Forms\Contracts\EntryCollectionContract;
use calderawp\caldera\Forms\Contracts\EntryContract;

interface CalderaFormsContract extends CalderaModule
{

	public function findForm(string $by, $arg):FormModelContract;
	public function getForms():FormsCollectionContract;
	public function findEntryBy(string $by, $searchValue) : EntryCollectionContract;

	/**
	 * Get entries of a form
	 *
	 * @return EntryCollectionContract
	 */
	public function getEntries():EntryCollectionContract;
}
