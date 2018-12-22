<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\caldera\Forms\Entry\EntryValues;
use calderawp\interop\Contracts\HasId;
use calderawp\interop\Contracts\Arrayable;

interface EntryContract extends HasId, Arrayable
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
	 * @param string $formId
	 *
	 * @return $this
	 */
	public function setFormId(string $formId): EntryContract;

	public function getEntryValues(): EntryValues;

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
}
