<?php


namespace calderawp\caldera\Forms;

use calderawp\interop\Contracts\CalderaForms\HasField;
use calderawp\interop\Contracts\HasValue;
use calderawp\interop\Contracts\HasSlug;
use calderawp\interop\Contracts\HasLabel;
use calderawp\interop\Contracts\HasDescription;
use calderawp\interop\Contracts\CalderaForms\HasForm;
use calderawp\interop\Model;
use calderawp\interop\Traits\CalderaForms\ProvidesField;
use calderawp\interop\Traits\CalderaForms\ProvidesForm;
use calderawp\interop\Traits\ProvidesDescription;
use calderawp\interop\Traits\ProvidesIdToModel;
use calderawp\interop\Traits\ProvidesLabel;
use calderawp\interop\Traits\ProvidesName;
use calderawp\interop\Traits\ProvidesSlug;
use calderawp\interop\Traits\ProvidesValue;

class FieldModel extends Model implements HasForm, HasField, HasValue, HasSlug, HasLabel, HasDescription
{
	use ProvidesValue, ProvidesField, ProvidesForm, ProvidesIdToModel, ProvidesName, ProvidesSlug,ProvidesLabel, ProvidesDescription;
}
