<?php


namespace calderawp\caldera\Forms\Controllers;

use calderawp\caldera\Forms\Contracts\FormModelContract as Form;
use calderawp\caldera\Forms\Contracts\FormsCollectionContract as Forms;
use calderawp\caldera\Forms\Exception;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class FormsController extends CalderaFormsController
{

	/**
	 * Handle a request for a single form
	 *
	 * @param null|Form $form
	 * @param Request $request
	 *
	 * @return Form
	 *
	 * @throws \Exception
	 */
	public function getForm($form, Request $request) : Form
	{
		$methodName = __FUNCTION__;
		$form = $this->applyFilters("caldera/forms/$methodName", $form, $request );
		if (is_a($form, Form::class)) {
			return $form;
		}
		try {
			$id = $request->getParam('formId');
			$forms = $this
				->getCalderaForms()
				->findForm('id', $id);
			return $forms->getForm($id);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 * Convert request for a single form result to response
	 *
	 * @param Form $form
	 *
	 * @return Response
	 */
	public function responseToForm(Form $form) : Response
	{
		return $form->toResponse();
	}

	/**
	 * Handle request for forms
	 *
	 * @param FormsCollection|null $forms
	 * @param Request $request
	 *
	 * @return FormsCollection
	 */
	public function getForms($forms, Request $request) : FormsCollection
	{
		$forms = $this->applyBeforeFilter(__FUNCTION__, $forms, $request );
		if (is_a($forms, Forms::class)) {
			return $forms;
		}
		return $this
			->getCalderaForms()
			->getForms();
	}

	/**
	 * Convert request for a forms result to response
	 *
	 * @param FormsCollection $collection
	 *
	 * @return Response
	 */
	public function responseToForms(FormsCollection$collection): Response
	{
		return $collection->toResponse();
	}

	/**
	 * Handle request to create a form
	 *
	 * @param FormModel|null $form
	 * @param Request $request
	 *
	 * @return Form
	 * @throws Exception
	 */
	public function createForm($form, Request $request) : Form
	{
		$form = $this->applyBeforeFilter(__FUNCTION__, $form, $request );
		if (is_a($form, Form::class)) {
			return $form;
		}
		throw new Exception('Not Implemented', 501);
	}
	/**
	 * Handle request to delete a form
	 *
	 * @param FormModel|null|bool $form
	 * @param Request $request
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function deleteForm($form, Request $request) : bool
	{
		if (true === $form) {
			return true;
		}
		throw new Exception('Not Implemented', 501);
	}
}
