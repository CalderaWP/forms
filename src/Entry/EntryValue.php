<?php


namespace calderawp\caldera\Forms\Entry;

use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\Contracts\FieldModelContract;
use calderawp\caldera\Forms\Contracts\FormModelContract;
use calderawp\interop\Contracts\CalderaForms\HasField;
use calderawp\interop\Contracts\HasValue;
use calderawp\interop\Contracts\HasSlug;
use calderawp\interop\Contracts\HasId;


use calderawp\interop\Traits\ProvidesIdGeneric;
use calderawp\interop\Traits\ProvidesIdToModel;
use calderawp\interop\Traits\ProvidesLabel;
use calderawp\interop\Traits\ProvidesName;
use calderawp\interop\Traits\ProvidesSlug;
use calderawp\interop\Traits\ProvidesValue;

class EntryValue implements HasValue, HasSlug, HasId
{
	use ProvidesValue, ProvidesSlug, ProvidesIdGeneric;

	/**
	 * @var FieldModelContract
	 */
	protected $field;
	/**
	 * @var FormModelContract
	 */
	protected $form;

	public function __construct(FormModelContract $form, FieldModelContract $field)
	{
		$this->setForm($form);
		$this->setField($field);
	}

	/**
	 * @return FieldModelContract
	 */
	public function getField(): FieldModelContract
	{
		return $this->field;
	}

	/**
	 * @param FieldModelContract $field
	 *
	 * @return EntryValue
	 */
	public function setField(FieldModelContract $field): EntryValue
	{
		$this->field = $field;
		return $this;
	}

	/**
	 * @return FormModelContract
	 */
	public function getForm(): FormModelContract
	{
		return $this->form;
	}

	/**
	 * @param FormModelContract $form
	 *
	 * @return EntryValue
	 */
	protected function setForm(FormModelContract $form): EntryValue
	{
		$this->form = $form;
		return $this;
	}

	/**
	 * @return array|int|string
	 */
	public function getValue()
	{
		return null !== $this->value
			? $this->value
			: $this
				->getField()
				->getValue();
	}

	/**
	 * @return string
	 */
	public function getFieldSlug(): string
	{
		return $this->getField()->getSlug();
	}

	/** @inheritdoc */
	public function setSlug(string $slug): HasSlug
	{
		$this->slug = $slug;
		$this
			->getField()
			->setSlug($slug);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFieldId(): string
	{
		return $this->getField()->getId();
	}
}
