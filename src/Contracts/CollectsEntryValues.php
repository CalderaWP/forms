<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\caldera\Forms\Entry\EntryValue;

interface CollectsEntryValues
{


	/**
	 * Add one entry value
	 *
	 * @param EntryValue $value
	 *
	 * @return CollectsEntryValues
	 */
	public function addValue(EntryValue $value) :CollectsEntryValues;

	/**
	 * Check if collection has value
	 *
	 * @param string|int $idOrSlug
	 *
	 * @return bool
	 */
	public function hasValue($idOrSlug): bool;

	/**
	 * Remove value form collection
	 *
	 * @param string|int $idOrSlug
	 *
	 *
	 * @return CollectsEntryValues
	 */
	public function removeValue($idOrSlug): CollectsEntryValues;

	/**
	 * Get Values from collection
	 *
	 * @return array
	 */
	public function getValues(): array;

	/**
	 * Get Value from collection
	 *
	 * @param string|int $idOrSlug
	 *
	 * @return EntryValue|null
	 */
	public function getValue($idOrSlug): ?EntryValue;
}
