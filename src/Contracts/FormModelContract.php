<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\interop\Contracts\CalderaForms\HasForm;
use calderawp\interop\Contracts\CalderaForms\HasFields;
use calderawp\interop\Contracts\CalderaForms\HasProcessors;
use calderawp\interop\Contracts\Rest\RestResponseContract;

interface FormModelContract extends HasForm, HasFields, HasProcessors
{

	public function toResponse(int $statusCode = 200): RestResponseContract;
}
