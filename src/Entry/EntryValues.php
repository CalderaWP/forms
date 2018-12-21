<?php


namespace calderawp\caldera\Forms\Entry;

use calderawp\caldera\Forms\Contracts\CollectsEntryValues;

class EntryValues implements CollectsEntryValues
{

	/**
	 * @var
	 */
	protected $items;

	/**
	 * @param EntryValue $value
	 *
	 * @return CollectsEntryValues
	 */
	public function addValue(EntryValue $value): CollectsEntryValues
	{
		$this->items[ $value->getId() ] = $value;
		return $this;
	}

	/**
	 * @param int|string $idOrSlug
	 *
	 * @return bool
	 */
	public function hasValue($idOrSlug): bool
	{
		return $this->findById($idOrSlug) || $this->findBySlug($idOrSlug);
	}

	/**
	 * @param int|string $idOrSlug
	 *
	 * @return CollectsEntryValues
	 */
	public function removeValue($idOrSlug): CollectsEntryValues
	{
		if ($_value = $this->findByIdOrSlug($idOrSlug)) {
			unset($this->items[ $_value->getId() ]);
		}
		return $this;
	}


	/** @inheritdoc */
	public function getValue($idOrSlug): ?EntryValue
	{
		if ($_value = $this->findByIdOrSlug($idOrSlug)) {
			return $_value;
		}
	}

	/**
	 * @return array
	 */
	public function getValues(): array
	{
		return is_array($this->items) ? $this->items : [];
	}



	/**
	 * @param string|int $idOrSlug
	 *
	 * @return EntryValue|null
	 */
	protected function findByIdOrSlug($idOrSlug): ?EntryValue
	{
		if ($_value = $this->findById($idOrSlug)) {
			return $_value;
		} elseif ($_value =$this->findBySlug($idOrSlug)) {
			return $_value;
		} else {
			return null;
		}
	}

	/**
	 * @param string|int $id
	 *
	 * @return EntryValue|null
	 */
	protected function findById($id): ?EntryValue
	{
		return array_key_exists($id, $this->items) ? $this->items[ $id ] : null;
	}

	/**
	 * @param string|int
	 *
	 * @return EntryValue|null
	 */
	protected function findBySlug($slug): ?EntryValue
	{
		foreach ($this->getValues() as $value) {
			if ($slug === $value->getSlug()) {
				return $value;
			}
		}

		return null;
	}
}
