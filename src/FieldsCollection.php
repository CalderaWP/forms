<?php


namespace calderawp\caldera\Forms;

use calderawp\caldera\Forms\Contracts\FieldModelContract as Field;
use calderawp\caldera\Forms\Traits\PreparesFieldsFromArray;
use calderawp\interop\Collection;
use calderawp\interop\Contracts\CalderaForms\HasFields as Fields;
use calderawp\caldera\Forms\Contracts\FieldCollectionInterface;
use calderawp\interop\Contracts\InteroperableCollectionContract;
use calderawp\interop\Traits\CalderaForms\ProvidesFields;

class FieldsCollection extends Collection implements FieldCollectionInterface
{

	use PreparesFieldsFromArray;


	public static function fromArray(array $items): InteroperableCollectionContract
	{
		$items = self::prepareFieldsFromArray($items);

		/** @var FieldsCollection $obj */
		$obj = parent::fromArray($items);
		if (isset($items['fields'])&&is_object($items['fields'])) {
			if (is_array($items['fields'])) {
				exit;
			}
		}
		return $obj;
	}

	public function toArray(): array
	{
		$array = parent::toArray();
		return $array;
	}

	/**
	 * Reset collection
	 *
	 * @param Fields $fields
	 *
	 * @return Collection
	 */
	public function setFields(Fields $fields): Fields
	{
		$this->resetItems($fields);
		return $this;
	}

	/**
	 * @param FieldModel $field
	 *
	 * @return Collection
	 */
	public function addField(FieldModel $field): Collection
	{
		$this->items[ $field->getId() ] = $field;
		return $this;
	}


	public function getField($idOrSlug): ?Field
	{
		if (isset($this->items[ $idOrSlug ])) {
			return $this->items[$idOrSlug];
		}

		/**
		 * @var int $itemIndex
		 * @var FieldModel $item
		 */
		foreach ($this->items as $itemIndex => $item) {
			if ($idOrSlug === $item->getSlug()) {
				return $item;
			}
		}

		return null;
	}

	/** @inheritdoc */

	public function hasField($idOrSlug): bool
	{
		if( empty( $this->items) ){
			return false;
		}
		if (isset($this->items[ $idOrSlug ])) {
			return true;
		}

		/**
		 * @var int $itemIndex
		 * @var FieldModel $item
		 */
		foreach ($this->items as $itemIndex => $item) {
			if ($idOrSlug === $item->getSlug()) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Remove form from collection
	 *
	 * @param FieldModel $field
	 *
	 * @return $this
	 */
	public function removeField(FieldModel $field) : FieldCollectionInterface
	{
		$this->removeItem($field);
		return $this;
	}

	/** @inheritdoc */
	protected function setterName(): string
	{
		return 'setFields';
	}

	public function getFields(): Fields
	{
		return $this->items;
	}
}
