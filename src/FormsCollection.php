<?php


namespace calderawp\caldera\Forms;

use calderawp\caldera\Forms\Contracts\FormModelContract;
use calderawp\interop\Collection;
use calderawp\interop\Contracts\CalderaForms\HasForms as Forms;
use calderawp\caldera\Forms\Contracts\FormsCollectionContract;

class FormsCollection extends Collection implements FormsCollectionContract
{

	/** @inheritdoc */
	public function getForm($id): FormModelContract
	{
		if ($this->has($id)) {
			return $this->items[$id];
		}
		throw new Exception('Form not found', 404);
	}

	/**
	 * Is item in collection?
	 *
	 * @param string $id
	 *
	 * @return bool
	 */
	public function has($id) : bool
	{
		return is_array($this->items) && array_key_exists($id, $this->items);
	}

	/**
	 * @param Forms $forms
	 *
	 * @return Collection
	 */
	public function setForms(Forms $forms) : FormsCollectionContract
	{
		$this->resetItems($forms);
		return $this;
	}
	/**
	 * @param FormModel $form
	 *
	 * @return Collection
	 */
	public function addForm(FormModel $form) : FormsCollectionContract
	{
		$this->items[$form->getId()]=$form;
		return $this;
	}

	/**
	 * Get form collection
	 *
	 * @return array
	 */
	public function getForms(): array
	{
		return $this->items;
	}

	/**
	 * Remove form from collection
	 *
	 * @param FormModel $form
	 *
	 * @return $this
	 */
	public function removeForm(FormModel $form)
	{
		$this->removeItem($form);
		return $this;
	}

	/** @inheritdoc */
	protected function setterName(): string
	{
		return 'setForms';
	}
}
