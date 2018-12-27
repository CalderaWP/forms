<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\caldera\Forms\Contracts\EntryContract as Entry;

use calderawp\interop\Contracts\InteroperableCollectionContract;

interface EntryCollectionContract extends InteroperableCollectionContract
{

	/**
	 * Add entry to collection
	 *
	 * @param EntryContract $entry
	 *
	 * @return EntryCollectionContract
	 */
	public function addEntry(Entry $entry) : EntryCollectionContract;
	/**
	 * Remove entry from collection
	 *
	 * @param EntryContract $entry
	 *
	 * @return EntryCollectionContract
	 */
	public function removeEntry(Entry $entry) : EntryCollectionContract;

	/**
	 * Check if entry is in collection
	 *
	 * @param $idOrSlug
	 *
	 * @return bool
	 */
	public function hasEntry($idOrSlug): bool;

	/**
	 * Get entry from collection
	 *
	 * @param $idOrSlug
	 *
	 * @return EntryContract
	 */
	public function getEntry($idOrSlug): EntryContract;
}
