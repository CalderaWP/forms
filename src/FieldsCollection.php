<?php


namespace calderawp\caldera\Forms;

use calderawp\interop\Collection;
use calderawp\interop\Contracts\CalderaForms\HasForm as Form;
use calderawp\interop\Contracts\CalderaForms\HasFields as Fields;
use calderawp\interop\Traits\CalderaForms\ProvidesFields;

class FieldsCollection extends Collection implements Fields
{

	use ProvidesFields;


	/**
	 * Reset collection
	 *
	 * @param Fields $fields
	 *
	 * @return Collection
	 */
	public function setFields(Fields $fields) : Fields
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
