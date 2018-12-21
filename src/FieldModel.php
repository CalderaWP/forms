<?php


namespace calderawp\caldera\Forms;

use calderawp\interop\Contracts\CalderaForms\HasField;
use calderawp\interop\Contracts\HasValue;
use calderawp\interop\Contracts\CalderaForms\HasForm;
use calderawp\interop\Model;
use calderawp\interop\Traits\CalderaForms\ProvidesField;
use calderawp\interop\Traits\CalderaForms\ProvidesForm;
use calderawp\interop\Traits\ProvidesId;
use calderawp\interop\Traits\ProvidesName;
use calderawp\interop\Traits\ProvidesValue;

class FieldModel extends Model implements HasForm, HasField,HasValue
{
	use ProvidesValue, ProvidesField, ProvidesForm, ProvidesId, ProvidesName;
}
