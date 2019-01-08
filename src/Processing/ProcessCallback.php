<?php


namespace calderawp\caldera\Forms\Processing;

use calderawp\caldera\Forms\FormArrayLike;
use calderawp\caldera\Http\Contracts\CalderaHttpContract as CalderaHttp;
use calderawp\interop\Contracts\FieldsArrayLike;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\ProcessorContract;
use calderawp\caldera\Forms\Contracts\CalderaFormsContract as CalderaFormsModule;
use calderawp\caldera\Forms\Contracts\ProcessorCallbackContract;

abstract class ProcessCallback implements ProcessorCallbackContract
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

	/**
	 * ProcessCallback constructor.
	 *
	 * @param FormArrayLike $form
	 * @param CalderaFormsModule $calderaForms
	 */
	public function __construct(FormArrayLike $form, CalderaFormsModule $calderaForms)
	{
		$this->form = $form;
		$this->calderaForms = $calderaForms;
	}

	/**
	 * Set the processor instance
	 *
	 * @param ProcessorContract $processor
	 *
	 * @return ProcessCallback
	 */
	public function setProcessor(ProcessorContract $processor) : ProcessorCallbackContract
	{
		$this->processor = $processor;
		return $this;
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
	 * Find a config field value by ID.
	 *
	 * If value found and the value is the ID of a field, then the value of that field is returned.
	 *
	 * @param string $configFieldId Name of config field
	 * @param FieldsArrayLike $formFields Current form field values
	 *
	 * @return mixed|null
	 */
	protected function getConfigFieldValue($configFieldId, FieldsArrayLike $formFields)
	{
		$config = $this->getProcessorConfig();
		if ($config->offsetExists($configFieldId)) {
			$value = $config->offsetGet($configFieldId);

			if ($formFields->offsetExists($value)) {
				return $formFields
					->offsetGet($value);
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
