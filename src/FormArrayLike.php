<?php


namespace calderawp\caldera\Forms;

use calderawp\caldera\Forms\Contracts\FormModelContract as Form;
use calderawp\interop\ArrayLike;

class FormArrayLike extends ArrayLike
{


	public static function fromModel(Form $form) : FormArrayLike
	{
		return new static($form->toArray());
	}
}
