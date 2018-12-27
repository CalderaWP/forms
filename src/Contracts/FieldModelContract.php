<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\interop\Contracts\HasValue;
use calderawp\interop\Contracts\CalderaForms\HasField;
use calderawp\interop\Contracts\HasSlug;
use calderawp\interop\Contracts\HasLabel;
use calderawp\interop\Contracts\HasId;
use calderawp\interop\Contracts\HasDescription;
use calderawp\interop\Contracts\CalderaForms\HasForm;

interface FieldModelContract extends HasId, HasForm, HasField, HasValue, HasSlug, HasLabel, HasDescription
{

	public function getType(): string;

	public function setType(string $type) : FieldModelContract;
}
