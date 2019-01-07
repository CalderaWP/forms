<?php


namespace calderawp\caldera\Forms\Processing;

use calderawp\caldera\Forms\FormArrayLike;
use calderawp\caldera\Http\Contracts\CalderaHttpContract as CalderaHttp;
use calderawp\interop\Contracts\FieldsArrayLike as FormFields;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\ProcessorContract;
use calderawp\caldera\Forms\Contracts\CalderaFormsContract as CalderaFormsModule;

abstract class ProcessCallback
{

	/** @var FormArrayLike */
	protected $form;

	/**
	 * @var ProcessorContract
	 */
	protected $processor;

	/**
	 * @var CalderaFormsModule
	 */
	protected $calderaForms;
	public function __construct(FormArrayLike $form, CalderaFormsModule $calderaForms)
	{
		$this->form = $form;
		$this->calderaForms = $calderaForms;
	}


	/**
	 * Get the Http Module.
	 *
	 * Use this to make any outgoing Http request
	 *
	 * @return CalderaHttp
	 */
	protected function getHttp() : CalderaHttp
	{
		return $this->calderaForms->getCore()->getHttp();
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
		$config = $this->getProcessorConfig();
		if ($config->offsetExists($configFieldId)) {
			$value = $config->offsetGet($configFieldId);
			if ($formFields->hasField($value)) {
				return $formFields
					->getFieldValue($value);
			}
			return $value;
		}
	}

	/**
	 * Get saved processor settings
	 *
	 * @return ProcessorConfig
	 */
	protected function getProcessorConfig(): ProcessorConfig
	{
		$config = $this->processor->getProcessorConfig();
		return $config;
	}
}
