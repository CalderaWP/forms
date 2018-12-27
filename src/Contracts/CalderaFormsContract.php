<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\interop\Contracts\CalderaModule;
use calderawp\caldera\Forms\Contracts\FormModelContract;

interface CalderaFormsContract extends CalderaModule
{

	public function findForm(string $by, $arg):FormModelContract;
	public function getForms():FormsCollectionContract;
}
