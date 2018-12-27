<?php


namespace calderawp\caldera\Forms\Controllers;

use calderawp\caldera\Forms\CalderaForms;
use calderawp\caldera\restApi\Controller;

abstract class CalderaFormsController extends Controller
{
	/**
	 * @var CalderaForms;
	 */
	protected $calderaForms;

	/**
	 * FormsController constructor.
	 *
	 * @param CalderaForms $calderaForms
	 */
	public function __construct(CalderaForms$calderaForms)
	{
		$this->calderaForms = $calderaForms;
	}

	/**
	 * @return CalderaForms
	 */
	protected function getCalderaForms()
	{
		return $this->calderaForms;
	}
}
