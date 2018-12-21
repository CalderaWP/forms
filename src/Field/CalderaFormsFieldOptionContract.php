<?php


namespace calderawp\caldera\Forms\Field;

use calderawp\interop\Contracts\Arrayable;
use calderawp\interop\Contracts\HasValue;
use calderawp\interop\Contracts\HasId;
use calderawp\interop\Contracts\HasLabel;

interface CalderaFormsFieldOptionContract extends HasValue, HasLabel, HasId, Arrayable
{

	public function getCalculationValue() : int;
	public function setCalculationValue(int $value): CalderaFormsFieldOptionContract;
}
