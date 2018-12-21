<?php


namespace calderawp\caldera\Forms;

use calderawp\interop\Collection;
use calderawp\interop\Contracts\CalderaForms\HasForm as Form;
use calderawp\interop\Contracts\CalderaForms\HasFields as Fields;

class FieldsCollection extends Collection
{

	/**
	 * Reset collection
	 *
	 * @param Fields $fields
	 *
	 * @return Collection
	 */
	public function setFields(Fields $fields) : Collection
	{
		$this->resetItems($fields);
		return $this;
	}
	/**
	 * @param FieldModel $field
	 *
	 * @return Collection
	 */
	public function addField(FieldModel $field) : Collection
	{
		$this->items[$field->getId()]=$field;
		return $this;
	}

	/**
	 * Remove form from collection
	 *
	 * @param FieldModel $field
	 *
	 * @return $this
	 */
	public function removeField(FieldModel $field)
	{
		$this->removeItem($field);
		return $this;
	}

	/** @inheritdoc */
	protected function setterName(): string
	{
		return 'setFields';
	}
}
