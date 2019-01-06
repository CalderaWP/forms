<?php


namespace calderawp\caldera\Forms\Processing;

use calderawp\caldera\Forms\FormArrayLike;
use calderawp\interop\Contracts\UpdateableFormFieldsContract as FormFields;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\ProcessorContract;

abstract class ProcessCallback
{

	/** @var FormArrayLike */
	protected $form;

	/**
	 * @var ProcessorContract
	 */
	protected $processor;
	public function __construct(FormArrayLike $form)
	{
		$this->form = $form;
	}


	/**
	 * This is where you process request.
	 *
	 * Throw an exception to have REST API/ CLI return error
	 * Modify FormFields to update field values in database/ request
	 *
	 * @param FormFields $formFields Current values of form fields
	 * @param Request $request Current request
	 *
	 * @return FormFields
	 */
	abstract public function process(FormFields $formFields, Request $request): FormFields;

	/**
	 * Find a config field value by ID.
	 *
	 * If value found and the value is the ID of a field, then the value of that field is returned.
	 *
	 * @param string $configFieldId Name of config field
	 * @param FormFields $formFields Current form field values
	 *
	 * @return mixed|null
	 */
	protected function getConfigFieldValue($configFieldId, FormFields $formFields)
	{
		$config = $this->processor->getProcessorConfig();
		if ($config->offsetExists($configFieldId)) {
			$value = $config->offsetGet($configFieldId);
			if ($formFields->hasField($value)) {
				return $formFields
					->getFieldValue($value);
			}
			return $value;
		}
	}
}
