<?php


namespace calderawp\caldera\Forms;

use calderawp\interop\Contracts\CalderaForms\HasField;
use calderawp\interop\Contracts\CalderaForms\HasForm;
use calderawp\interop\Model;
use calderawp\interop\Traits\CalderaForms\ProvidesField;
use calderawp\interop\Traits\CalderaForms\ProvidesForm;
use calderawp\interop\Traits\ProvidesId;
use calderawp\interop\Traits\ProvidesName;

class FieldModel extends Model implements HasForm, HasField
{
	use ProvidesField, ProvidesForm, ProvidesId, ProvidesName;
}
