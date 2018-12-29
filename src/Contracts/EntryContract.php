<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\caldera\Forms\Entry\EntryValue;
use calderawp\caldera\Forms\Entry\EntryValues;
use calderawp\interop\Contracts\ConvertsToResponse;
use calderawp\interop\Contracts\HasId;
use calderawp\interop\Contracts\Arrayable;

interface EntryContract extends HasId, Arrayable, ConvertsToResponse
{

	/**
	 * @param array $items
	 *
	 * @return EntryContract
	 */
	public static function fromArray(array $items): EntryContract;

	/**
	 * @return string
	 */
	public function getFormId(): string;

	/**
	 * @param string $formId	public function addEntryValue( EntryValue $value ): EntryContract

	 *
	 * @return $this
	 */
	public function setFormId(string $formId): EntryContract;

	public function getEntryValues(): EntryValues;
	public function addEntryValue( EntryValue $value ): EntryContract;

	/**
	 * @return \DateTimeInterface
	 */
	public function getDate(): \DateTimeInterface;

	/**
	 * @param string|\DateTime $date
	 *
	 * @return  $this
	 */
	public function setDate($date): EntryContract;

	/**
	 * @return string
	 */
	public function getDateAsString(): string;

	/**
	 * Get all entry values as fieldId => value
	 *
	 * @return array
	 */
	public function valuesToArray() : array;

}
