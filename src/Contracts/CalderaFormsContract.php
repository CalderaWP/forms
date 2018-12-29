<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Exception;

interface CalderaFormsContract extends CalderaModule
{
	/**
	 * Find form, searching by a column
	 *
	 * @param string $by
	 * @param string|int $searchValue Optional, value to search by. Default is 'id'
	 *
	 * @return FormsCollectionContract
	 * @throws Exception
	 */
	public function findForm(string $by, $searchValue = 'id'):FormsCollectionContract;
	/**
	 * Get formscollection
	 *
	 * @return FormsCollectionContract
	 */
	public function getForms():FormsCollectionContract;
	/**
	 * @param string $by
	 * @param $searchValue
	 *
	 * @return EntryCollectionContract
	 * @throws Exception
	 */
	public function findEntryBy(string $by, $searchValue = 'id') : EntryCollectionContract;

	/**
	 * Get entries of a form
	 *
	 * @return EntryCollectionContract
	 */
	public function getEntries():EntryCollectionContract;
}
