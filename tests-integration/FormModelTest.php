<?php


namespace calderawp\caldera\Forms\Tests\Integration;


use calderawp\caldera\Forms\FieldsArrayLike;
use calderawp\caldera\Forms\FormArrayLike;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\Processing\ProcessCallback;
use calderawp\caldera\Forms\Processing\Processor;
use calderawp\caldera\Forms\Processing\ProcessorConfig;
use calderawp\caldera\Forms\Processing\ProcessorMeta;
use calderawp\interop\Contracts\FieldsArrayLike as FormFields;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;

class FormModelTest extends IntegrationTestCase
{

	public function testAddProcessorToForm(){
		$fields = new FieldsArrayLike([
			'firstName' => 'Roy',
			'email' => 'roy@hiroy.club',
		]);

		$processorConfig = new ProcessorConfig([
			'settingOne' => 'firstName',
			'settingTwo' => 'setting2',
		]);
		$processorMeta = new ProcessorMeta(['label' => 'Request an airship.', 'id' => 'sevenL8']);

		$form = FormModel::fromArray([
			'formId' => 'form',
			'processors',
		]);
		$formArrayLike = FormArrayLike::fromModel($form);
		$callbackPre = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				return $formFields;
			}
		};

		$processor = new Processor(
			$processorMeta,
			$processorConfig,
			$formArrayLike,
			[
				Processor::PRE_PROCESS => $callbackPre,

			]
		);


		$form = FormModel::fromArray([
			'formId' => 'form',
			'processors' => [$processor]
		]);

		$this->assertSame($processor->getLabel(), $form->getProcessors()->toArray()['sevenL8']['label']);
		$this->assertSame($processor->getProcessorConfig()->toArray(), $form->getProcessors()->toArray()['sevenL8']['config']);
	}

}
