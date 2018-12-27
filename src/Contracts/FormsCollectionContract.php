<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\caldera\Forms\FormModel;
use calderawp\interop\Contracts\CalderaForms\HasForms as Forms;

interface FormsCollectionContract
{
	/**
	 * @param Forms $forms
	 *
	 * @return FormsCollectionContract
	 */
	public function setForms(Forms $forms) : FormsCollectionContract;

	/**
	 * @param $id
	 *
	 * @return FormModelContract
	 */
	public function getForm($id) : FormModelContract;
	/**
	 * @param FormModel $form
	 *
	 * @return FormsCollectionContract
	 */
	public function addForm(FormModel $form) : FormsCollectionContract;

	/**
	 * Get form collection
	 *
	 * @return array
	 */
	public function getForms(): array;

	/**
	 * Remove form from collection
	 *
	 * @param FormModel $form
	 *
	 * @return $this
	 */
	public function removeForm(FormModel $form);
}
