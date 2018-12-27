<?php


namespace calderawp\caldera\Forms\Controllers;

use calderawp\caldera\Forms\CalderaForms;
use calderawp\caldera\Forms\Contracts\FormModelContract as Form;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\caldera\restApi\Controller;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class FormsController extends Controller
{
	/**
	 * @var CalderaForms;
	 */
	protected $calderaForms;


	public function __construct(CalderaForms$calderaForms)
	{
		$this->calderaForms = $calderaForms;
	}

	public function getCalderaForms()
	{
		return $this->calderaForms;
	}

	/**
	 * @param null|Form $form
	 * @param Request $request
	 *
	 * @return Form
	 */
	public function getForm($form, Request $request) : Form
	{
		if (! is_null($form)) {
			return $form;
		}
		try {
			$_form = $this
				->getCalderaForms()
				->getFormsDb()
				->getCrud()
				->read((int)$request->getParam('formId'));
			$form = FormModel::fromArray($_form);
			return $form;
		} catch (\Exception $e) {
		}
	}

	/**
	 * @param Form $form
	 *
	 * @return Response
	 */
	public function responseToForm(Form $form) : Response
	{
		return $form->toResponse();
	}

	public function getForms($forms, Request $request) : FormsCollection
	{
		if (! is_null($forms)) {
			return $forms;
		}
		try {
			$_forms = $this
				->getCalderaForms()
				->getFormsDb()
				->getQuery()
				->where('page', $request->getParam('page'));
			$forms = FormsCollection::fromArray($_forms);
			return $forms;
		} catch (\Exception $e) {
		}
	}

	public function responseToForms(FormsCollection$collection): Response
	{
		return $collection->toResponse();
	}

	public function createForm($form, Request $request) : Form
	{
		if (! is_null($form)) {
			return $form;
		}
		try {
			$_form = $this
				->getCalderaForms()
				->getFormsDb()
				->getCrud()
				->create($request->getParams());
			$form = FormModel::fromArray($_form);
			return $form;
		} catch (\Exception $e) {
		}
	}

	public function deleteForm($form, Request $request) : bool
	{
		if (true === $form) {
			return $form;
		}
		try {
			$deleted = $this
				->getCalderaForms()
				->getFormsDb()
				->getCrud()
				->delete($request->getParam((int)$request->getParam('formId')));
			return $deleted;
		} catch (\Exception $e) {
		}
	}
}
