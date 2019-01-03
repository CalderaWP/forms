<?php


namespace calderawp\caldera\Forms\Processing;

use calderawp\interop\ArrayLike;
use calderawp\interop\Contracts\UpdateableFormFieldsContract;

class FormFieldsWithUpdate extends ArrayLike implements UpdateableFormFieldsContract
{

	protected $fieldUpdater;
	public function setFieldUpdater(callable  $fieldUpdater) : UpdateableFormFieldsContract
	{
		$this->fieldUpdater = $fieldUpdater;
		return $this;
	}

	public function getFields() : array
	{
		return $this->toArray();
	}

	public function updateFieldValue(string $fieldId, $newValue)
	{
		return call_user_func($this->fieldUpdater, $fieldId, $newValue);
	}

	public function getFieldValue(string $fieldId, $default = null)
	{
		return $this->hasField($fieldId)
			? $this->offsetGet($fieldId)
			: $default;
	}

	public function hasField(string  $fieldId): bool
	{
		return $this->offsetExists($fieldId);
	}
}
