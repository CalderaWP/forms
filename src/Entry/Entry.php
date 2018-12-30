<?php


namespace calderawp\caldera\Forms\Entry;

use calderawp\caldera\Forms\Contracts\EntryContract;
use calderawp\caldera\Forms\EntryCollection;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\restApi\Response;
use calderawp\interop\Contracts\Rest\RestRequestContract;
use calderawp\interop\Contracts\Rest\RestResponseContract;
use calderawp\interop\Traits\ProvidesIdGeneric;
use calderawp\interop\Contracts\Interoperable;

class Entry implements EntryContract
{
	use ProvidesIdGeneric;


	protected $userId;

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

	public function setEntryValues(EntryValues $entryValues): Entry
	{
		$this->entryValues = $entryValues;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function toResponse(): RestResponseContract
	{
		return (new Response())->setData($this->toArray());
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

	/**
	 * Convert array of database results to Entry model
	 *
	 * @param array $result
	 *
	 * @return Entry
	 */
	public static function fromDatabaseResult(array $result) : Entry
	{
		$obj = new static();
		$obj->setFormId($result['form_id'])
			->setUserId($result['user_id'])
			->setDate($result['datestamp'])
			->setId($result['id']);
			return$obj;
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
			if (!empty($items[ $key ])) {
				try {
					call_user_func([$obj, $setter], $items[ $key ]);
				} catch (\Exception $e) {
					throw $e;
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
			'date' => $this->getDateAsString(),
			'userId' => $this->getUserId(),
			'entryValues' => $this->getEntryValues()->toArray(),
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
	 *
	 * @return $this
	 */
	public function setFormId(string $formId): EntryContract
	{
		$this->formId = $formId;
		return $this;
	}

	/**
	 * @return int|string
	 */
	public function getUserId() : int
	{
		return is_numeric($this->userId)? $this->userId :0;
	}

	/**
	 * @param int $userId
	 *
	 * @return Entry
	 */
	public function setUserId(int $userId) : Entry
	{
		$this->userId = $userId;
		return $this;
	}



	public function jsonSerialize()
	{
		return $this->toArray();
	}

	public function getEntryValues(): EntryValues
	{
		if (!$this->entryValues) {
			$this->entryValues = new EntryValues();
		}

		return $this->entryValues;
	}

	public function addEntryValue(EntryValue $value): EntryContract
	{
		$this
			->getEntryValues()
			->addValue($value);
		return $this;
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
	 *
	 * @return  $this
	 */
	public function setDate($date): EntryContract
	{
		if (is_string($date) && !empty($date)) {
			$this->date = new \DateTime($date);
		} elseif (is_object($date)) {
			$this->date = $date;
		} else {
			$this->date = new \DateTime();
		}
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDateAsString(): string
	{
		return $this->getDate()->format('Y-m-d H:i:s');
	}

	public function valuesToArray() : array
	{
		$values = [];

		/** @var EntryValue $value */
		foreach ($this->entryValues as $value) {
			$values[$value->getFieldId()]= $value->getValue();
		}
		return $values;
	}
}
