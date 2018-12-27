<?php


namespace calderawp\caldera\Forms\Entry;

use calderawp\caldera\Forms\FieldModel;
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

	public static function fromArray(array $items): EntryValue
	{
		$form = null;
		$field = null;
		if (isset($items[ 'form' ])) {
			$_value = $items[ 'form' ];
			if (is_a($_value, FormModelContract::class)) {
				$form = $_value;
			} elseif (is_array($_value)) {
				$form = FormModel::fromArray($_value);
			}
		} else {
			if (isset($items[ 'formId' ])) {
				$form = FormModel::fromArray(['id' => $items[ 'formId' ]]);
			}
		}
		if (isset($items[ 'field' ])) {
			$_value = $items[ 'field' ];
			if (is_a($_value, FieldModelContract::class)) {
				$field = $_value;
			} elseif (is_array($_value)) {
				$field = FieldModel::fromArray($_value);
			}
		} else {
			if (isset($items[ 'fieldId' ])) {
				$field = FieldModel::fromArray(['id' => $items[ 'fieldId' ]]);
			}
		}

		$obj = new static($form, $field);
		foreach ([
					 'id' => 'setId',
					 'slug' => 'setSlug',
					 'value' => 'setValue',
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


	public function toArray()
	{
		return [
			'fieldId' => $this->getFieldId(),
			'formId' => $this->getFormId(),
			'slug' => $this->getFieldSlug(),
			'id' => $this->getId(),
			'value' => $this->getValue(),
		];
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

	/**
	 * @return string
	 */
	public function getFormId(): string
	{
		return $this->getForm()->getId();
	}
}
