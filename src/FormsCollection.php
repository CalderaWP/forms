<?php


namespace calderawp\caldera\Forms;

use calderawp\interop\Collection;
use calderawp\interop\Contracts\CalderaForms\HasForms as Forms;

class FormsCollection extends Collection
{

	/**
	 * @param Forms $forms
	 *
	 * @return Collection
	 */
	public function setForms(Forms $forms) : Collection
	{
		$this->resetItems($forms);
		return $this;
	}
	/**
	 * @param FormModel $form
	 *
	 * @return Collection
	 */
	public function addForm(FormModel $form) : Collection
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
