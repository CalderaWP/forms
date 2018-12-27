<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\interop\Contracts\CalderaForms\HasForm;
use calderawp\interop\Contracts\CalderaForms\HasFields;
use calderawp\interop\Contracts\Rest\RestResponseContract;

interface FormModelContract extends HasForm, HasFields
{

	public function toResponse(int $statusCode = 200): RestResponseContract;
}
