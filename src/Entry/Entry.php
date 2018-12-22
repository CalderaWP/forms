<?php


namespace calderawp\caldera\Forms\Entry;

use calderawp\caldera\Forms\Contracts\EntryContract;
use calderawp\interop\Traits\ProvidesIdGeneric;

class Entry implements EntryContract
{
	use ProvidesIdGeneric;

	/**
	 * @var \DateTime
	 */
	protected $date;
	/**
	 * @var EntryValues
	 */
	protected $entryValues;

	/**
	 * @var string
	 */
	protected $formId;

	const DATE_FORMAT = 'Y-m-d H:i:s';

	public function setEntryValues(EntryValues$entryValues) : Entry
	{
		$this->entryValues = $entryValues;
		return $this;
	}

	/**
	 * @param array|EntryValues $entryValues
	 *
	 * @return Entry
	 */
	public function setEntryValuesFromArray($entryValues)
	{
		if (is_a($entryValues, EntryValues::class)) {
			return $this->setEntryValues($entryValues);
		} elseif (is_array($entryValues)) {
			return $this->setEntryValues(EntryValues::fromArray($entryValues));
		} else {
			//?
		}
	}
	public static function fromArray(array $items): EntryContract
	{
		$obj = new static;

		foreach ([
			'id' => 'setId',
			'formId' => 'setFormId',
			'date' => 'setDate',
			'entryValues' => 'setEntryValuesFromArray',
				 ] as $key => $setter) {
			if (! empty($items[$key])) {
				try {
					call_user_func([$obj, $setter], $items[ $key ]);
				} catch (\Exception $e) {
					//@todo forward exception
				}
			}
		}


		return $obj;
	}

	public function toArray(): array
	{
		$array = [
			'id' => $this->getId(),
			'formId' => $this->getFormId(),
			'date' => $this->getDate()->format('Y-m-d H:i:s'),
			'entryValues' => $this->getEntryValues()->toArray()
		];

		return $array;
	}

	/**
	 * @return string
	 */
	public function getFormId(): string
	{
		return $this->formId;
	}

	/**
	 * @param string $formId
	 * @return $this
	 */
	public function setFormId(string $formId): EntryContract
	{
		$this->formId = $formId;
		return $this;
	}


	public function jsonSerialize()
	{
		return $this->toArray();
	}

	public function getEntryValues():EntryValues
	{
		if (! $this->entryValues) {
			$this->entryValues = new EntryValues();
		}

		return $this->entryValues;
	}


	/**
	 * @return \DateTime
	 */
	public function getDate(): \DateTimeInterface
	{
		return null !== $this->date ? $this->date : ($this->setDate('0'))->getDate();
	}

	/**
	 * @param string|\DateTime $date
	 * @return  $this
	 */
	public function setDate($date): EntryContract
	{
		if (is_string($date)) {
			$this->date = new \DateTime($date);
		} else {
			$this->date = $date;
		}
		return $this;
	}
}
