<?php


namespace calderawp\caldera\Forms\Controllers;

use calderawp\caldera\Forms\CalderaForms;
use calderawp\caldera\restApi\Controller;
use calderawp\interop\Contracts\WordPress\ApplysFilters;
abstract class CalderaFormsController extends Controller implements ApplysFilters
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

	protected function applyBeforeFilter(string $methodName, $entries,$request )
	{
		return caldera()
			->getEvents()
			->getHooks()
		->applyFilters("caldera/forms/$methodName",$entries,$request);
	}

	/** @inheritdoc */
	public function applyFilters( string $filterName, ...$args )
	{
		$value = \caldera()->getEvents()->getHooks()
			->applyFilters($filterName,$args);
		return $value;
	}

	/** @inheritdoc */
	public function addFilter(string $filterName, callable $callback, int $priority = 20, $args = 1)
	{
	 \caldera()->getEvents()->getHooks()
			->addFilter($filterName,$callback,$priority,$args);

	}
}
