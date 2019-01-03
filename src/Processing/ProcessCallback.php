<?php


namespace calderawp\caldera\Processing;

use calderawp\caldera\Forms\FormArrayLike;
use calderawp\interop\Contracts\UpdateableFormFieldsContract as FormFields;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\ProcessorContract;

abstract class ProcessCallback
{

	/** @var FormFields */
	protected $request;
	protected $form;

	/**
	 * @var ProcessorContract
	 */
	protected $processor;
	public function __construct(FormArrayLike $form, Request $request)
	{
		$this->form = $form;
		$this->request = $request;
	}


	abstract public function process(FormFields $formFields, Request $request): FormFields;

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
