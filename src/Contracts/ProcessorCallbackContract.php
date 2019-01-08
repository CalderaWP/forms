<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\interop\Contracts\FieldsArrayLike;
use calderawp\interop\Contracts\ProcessorContract as Processor;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;

interface ProcessorCallbackContract
{

	/**
	 * Set the processor instance
	 *
	 * @param Processor $processor
	 *
	 * @return ProcessorCallbackContract
	 */
	public function setProcessor(Processor $processor) : ProcessorCallbackContract;

	/**
	 * This is where you process request.
	 *
	 * Throw an exception to have REST API/ CLI return error
	 * Modify FormFields to update field values in database/ request
	 *
	 * @param FieldsArrayLike $formFields Current values of form fields
	 * @param Request $request Current request
	 *
	 * @return FieldsArrayLike
	 */
	public function process(FieldsArrayLike $formFields, Request $request): FieldsArrayLike;
}
