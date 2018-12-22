<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\caldera\Forms\FieldModel;
use calderawp\interop\Contracts\CalderaForms\HasFields as Fields;
use calderawp\caldera\Forms\Contracts\FieldModelContract as Field;

interface FieldCollectionInterface extends Fields
{
	/**
	 * @param $idOrSlug
	 *
	 * @return bool
	 */
	public function hasField($idOrSlug): bool;
	/**
	 * Remove form from collection
	 *
	 * @param FieldModel $field
	 *
	 * @return $this
	 */
	public function removeField(FieldModel $field) : FieldCollectionInterface;
	public function getField($idOrSlug): ?Field;
	/**
	 * Get the fields
	 *
	 * @return Fields
	 */
	public function getFields(): Fields;
	public function setFields(Fields $fields): Fields;
}
