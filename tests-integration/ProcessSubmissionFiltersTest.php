<?php

namespace calderawp\caldera\Forms\Tests\Integration;

use calderawp\caldera\Forms\Filters\ProcessSubmissionFilters;
use calderawp\caldera\Forms\FormArrayLike;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\Processing\FormFieldsWithUpdate;
use calderawp\caldera\Forms\Processing\Processor;
use calderawp\caldera\Forms\Processing\ProcessorConfig;
use calderawp\caldera\Forms\Processing\ProcessorMeta;
use calderawp\caldera\Forms\Processing\ProcessCallback;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\UpdateableFormFieldsContract as FormFields;
use calderawp\interop\Tests\Mocks\MockRequest;
use PHPUnit\Framework\TestCase;

class ProcessSubmissionFiltersTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::preProcess()
	 */
	public function testPreProcess()
	{
		$fields = new FormFieldsWithUpdate([
			'fld1' => 7,
			'fld2' => 2,
		]);
		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'setting2',
		]);
		$processorMeta  = new ProcessorMeta(['label' => 'Send an sms']);

		$form = FormModel::fromArray([
			'formId' => 'form',
			'processors'
		]);
		$formArrayLike = FormArrayLike::fromModel($form);
		$callback = new class($formArrayLike ) extends  ProcessCallback {
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields['fld1' ]= 'changed';
				return $formFields;
			}
		};
		$processor = new Processor(
			$processorMeta,
			$processorConfig,
			$formArrayLike,
			[
				Processor::PRE_PROCESS => $callback
			]
		);
		$request = (new MockRequest())
			->setParam('formId', 'contact-form');
		$returnedFields = $processor->preProcess($fields, $request );
		$this->assertSame('changed', $returnedFields['fld1' ] );
		$this->assertSame(2, $returnedFields['fld2' ] );

	}


	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::process()
	 */
	public function testMainProcess()
	{
		$fields = new FormFieldsWithUpdate([
			'fld1' => 7,
			'fld2' => 2,
		]);
		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'setting2',
		]);
		$processorMeta  = new ProcessorMeta(['label' => 'Send an sms']);

		$form = FormModel::fromArray([
			'formId' => 'form',
			'processors'
		]);
		$formArrayLike = FormArrayLike::fromModel($form);
		$callback = new class($formArrayLike ) extends  ProcessCallback {
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields['fld1' ]= 'changed';
				return $formFields;
			}
		};
		$processor = new Processor(
			$processorMeta,
			$processorConfig,
			$formArrayLike,
			[
				Processor::MAIN_PROCESS => $callback
			]
		);
		$request = (new MockRequest())
			->setParam('formId', 'contact-form');
		$returnedFields = $processor->mainProcess($fields, $request );
		$this->assertSame('changed', $returnedFields['fld1' ] );
		$this->assertSame(2, $returnedFields['fld2' ] );
	}

	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::postProcess()
	 */
	public function testPostProcess()
	{
		$fields = new FormFieldsWithUpdate([
			'fld1' => 7,
			'fld2' => 2,
		]);
		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'setting2',
		]);
		$processorMeta  = new ProcessorMeta(['label' => 'Send an sms']);

		$form = FormModel::fromArray([
			'formId' => 'form',
			'processors'
		]);
		$formArrayLike = FormArrayLike::fromModel($form);
		$callback = new class($formArrayLike ) extends  ProcessCallback {
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields['fld1' ]= 'changed';
				return $formFields;
			}
		};
		$processor = new Processor(
			$processorMeta,
			$processorConfig,
			$formArrayLike,
			[
				Processor::POST_PROCESS => $callback
			]
		);
		$request = (new MockRequest())
			->setParam('formId', 'contact-form');
		$returnedFields = $processor->postProcess($fields, $request );
		$this->assertSame('changed', $returnedFields['fld1' ] );
		$this->assertSame(2, $returnedFields['fld2' ] );
	}

	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::postProcess()
	 */
	public function testProcessorWithThreeCallbacks()
	{
		$fields = new FormFieldsWithUpdate([
			'fld1' => 1,
			'fld2' => 2,
			'fld3' => 3,
		]);

		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'setting2',
		]);
		$processorMeta  = new ProcessorMeta(['label' => 'Send an sms']);

		$form = FormModel::fromArray([
			'formId' => 'form',
			'processors'
		]);
		$formArrayLike = FormArrayLike::fromModel($form);
		$callbackPre = new class($formArrayLike ) extends  ProcessCallback {
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields['fld1' ]= 'pre';
				return $formFields;
			}
		};
		$callbackMain = new class($formArrayLike ) extends  ProcessCallback {
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields['fld2' ]= 'main';
				return $formFields;
			}
		};
		$callbackPost = new class($formArrayLike ) extends  ProcessCallback {
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields['fld3' ]= 'post';
				return $formFields;
			}
		};
		$processor = new Processor(
			$processorMeta,
			$processorConfig,
			$formArrayLike,
			[
				Processor::PRE_PROCESS => $callbackPre,
				Processor::MAIN_PROCESS => $callbackMain,
				Processor::POST_PROCESS => $callbackPost,
			]
		);
		$request = (new MockRequest())
			->setParam('formId', 'contact-form');
		$returnedFields = $processor->preProcess($fields, $request );
		$this->assertSame('pre', $returnedFields['fld1' ] );
		$this->assertSame(2, $returnedFields['fld2' ] );
		$this->assertSame(3, $returnedFields['fld3' ] );
		$returnedFields = $processor->mainProcess($fields, $request );
		$this->assertSame('pre', $returnedFields['fld1' ] );
		$this->assertSame('main', $returnedFields['fld2' ] );
		$this->assertSame(3, $returnedFields['fld3' ] );
		$returnedFields = $processor->postProcess($fields, $request );
		$this->assertSame('pre', $returnedFields['fld1' ] );
		$this->assertSame('main', $returnedFields['fld2' ] );
		$this->assertSame('post', $returnedFields['fld3' ] );
	}
}
