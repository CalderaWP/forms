<?php


namespace calderawp\caldera\Forms;

use calderawp\interop\Caldera;
use calderawp\caldera\Forms\Contracts\FormModelContract;
use calderawp\interop\Contracts\CalderaForms\HasFields;
use calderawp\interop\Traits\CalderaForms\ProvidesFields;
use calderawp\interop\Traits\CalderaForms\ProvidesForm;
use calderawp\interop\Contracts\CalderaContract as CalderaContract;

class FormModel extends Caldera implements FormModelContract
{
	use ProvidesForm, ProvidesFields;
}
