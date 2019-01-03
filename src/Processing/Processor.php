<?php


namespace calderawp\caldera\Forms\Processing;

use calderawp\caldera\Forms\FormArrayLike;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\UpdateableFormFieldsContract as FormFields;

use calderawp\interop\Contracts\ProcessorContract;

class Processor implements ProcessorContract
{

	const PRE_PROCESS = 'preProcessStage1';
	const PROCESS = 'mainProcessStage1';
	const POST_PROCESS = 'postProcessStage1';
	protected $callbacks;

	/**
	 * @var ProcessorConfig
	 */
	protected $processorConfig;

	/**
	 * @var array
	 */
	protected $processorMeta;

	/** @var FormArrayLike */
	protected $form;
	public function __construct(array $processorMeta, ProcessorConfig $processorConfig, FormArrayLike$form, array $callbacks = [])
	{
		$this->processorConfig = $processorConfig;
		$this->callbacks = $callbacks;
		$this->processorMeta = $processorMeta;
		$this->form = $form;
	}

	/**
	 * @inheritDoc
	 */
	public function getForm(): FormArrayLike
	{
		return $this->form;
	}

	/** @inheritdoc */
	public function checkConditionals(): bool
	{
		return true;
	}

	/** @inheritdoc */
	public function preProcess(FormFields $formFields, Request $request): FormFields
	{
		return $this->dispatch($formFields, $request, self::PRE_PROCESS);
	}

	/** @inheritdoc */
	public function mainProcess(FormFields $formFields, Request $request): FormFields
	{
		return $this->dispatch($formFields, $request, self::PROCESS);
	}

	/** @inheritdoc */
	public function postProcess(FormFields $formFields, Request $request): FormFields
	{
		return $this->dispatch($formFields, $request, self::POST_PROCESS);
	}

	/**
	 * @inheritDoc
	 */
	public function getProcessorConfig(): ProcessorConfig
	{
		return $this->processorConfig;
	}

	/**
	 * Find process dispatcher
	 *
	 * @param string $identifier
	 *
	 * @return array|mixed
	 */
	protected function findCallback(string $identifier)
	{
		$callback = $this->callbacks[$identifier];
		if (is_object($callback)) {
			return [$callback, 'process' ];
		}
		return $callback;
	}

	/**
	 * Dispatch process stages
	 *
	 * @param FormFields $formFields
	 * @param Request $request
	 * @param $identifier
	 *
	 * @return FormFields|mixed
	 */
	protected function dispatch(FormFields $formFields, Request $request, $identifier) : FormFields
	{
		if (array_key_exists($identifier, $this->callbacks)) {
			return call_user_func($this->findCallback($identifier), $formFields, $request);
		}
		return $formFields;
	}
}
