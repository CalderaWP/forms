<?php

namespace calderawp\caldera\Forms\Tests\Integration;

use calderawp\caldera\Forms\Controllers\EntryController;
use calderawp\caldera\Forms\FieldsArrayLike;
use calderawp\caldera\Forms\Filters\ProcessSubmissionFilters;
use calderawp\caldera\Forms\FormArrayLike;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\Processing\Processor;
use calderawp\caldera\Forms\Processing\ProcessorCollection;
use calderawp\caldera\Forms\Processing\ProcessorConfig;
use calderawp\caldera\Forms\Processing\ProcessorMeta;
use calderawp\caldera\Forms\Processing\ProcessCallback;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\FieldsArrayLike as FormFields;
use calderawp\interop\Tests\Mocks\MockRequest;

class ProcessSubmissionFiltersTest extends IntegrationTestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::preProcess()
	 */
	public function testPreProcess()
	{
		$fields = new FieldsArrayLike([
			'fld1' => 7,
			'fld2' => 2,
		]);
		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'setting2',
		]);
		$processorMeta = new ProcessorMeta(['label' => 'Send an sms']);

		$form = FormModel::fromArray([
			'formId' => 'form',
			'processors',
		]);
		$formArrayLike = FormArrayLike::fromModel($form);
		$callback = new class($formArrayLike) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'fld1' ] = 'changed';
				return $formFields;
			}
		};
		$processor = new Processor(
			$processorMeta,
			$processorConfig,
			$formArrayLike,
			[
				Processor::PRE_PROCESS => $callback,
			]
		);
		$request = (new MockRequest())
			->setParam('formId', 'contact-form');
		$returnedFields = $processor->preProcess($fields, $request);
		$this->assertSame('changed', $returnedFields[ 'fld1' ]);
		$this->assertSame(2, $returnedFields[ 'fld2' ]);

	}


	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::process()
	 */
	public function testMainProcess()
	{
		$fields = new FieldsArrayLike([
			'fld1' => 7,
			'fld2' => 2,
		]);
		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'setting2',
		]);
		$processorMeta = new ProcessorMeta(['label' => 'Send an sms']);

		$form = FormModel::fromArray([
			'formId' => 'form',
			'processors',
		]);
		$formArrayLike = FormArrayLike::fromModel($form);
		$callback = new class($formArrayLike) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'fld1' ] = 'changed';
				return $formFields;
			}
		};
		$processor = new Processor(
			$processorMeta,
			$processorConfig,
			$formArrayLike,
			[
				Processor::MAIN_PROCESS => $callback,
			]
		);
		$request = (new MockRequest())
			->setParam('formId', 'contact-form');
		$returnedFields = $processor->mainProcess($fields, $request);
		$this->assertSame('changed', $returnedFields[ 'fld1' ]);
		$this->assertSame(2, $returnedFields[ 'fld2' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::postProcess()
	 */
	public function testPostProcess()
	{
		$fields = new FieldsArrayLike([
			'fld1' => 7,
			'fld2' => 2,
		]);
		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'setting2',
		]);
		$processorMeta = new ProcessorMeta(['label' => 'Send an sms']);

		$form = FormModel::fromArray([
			'formId' => 'form',
		]);
		$formArrayLike = FormArrayLike::fromModel($form);
		$callback = new class($formArrayLike) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'fld1' ] = 'changed';
				return $formFields;
			}
		};
		$processor = new Processor(
			$processorMeta,
			$processorConfig,
			$formArrayLike,
			[
				Processor::POST_PROCESS => $callback,
			]
		);
		$request = (new MockRequest())
			->setParam('formId', 'contact-form');
		$returnedFields = $processor->postProcess($fields, $request);
		$this->assertSame('changed', $returnedFields[ 'fld1' ]);
		$this->assertSame(2, $returnedFields[ 'fld2' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::preProcess()
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::process()
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::postProcess()
	 */
	public function testProcessWithThreeCallbacks()
	{
		$fields = new FieldsArrayLike([
			'fld1' => 1,
			'fld2' => 2,
			'fld3' => 3,
		]);

		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'setting2',
		]);
		$processorMeta = new ProcessorMeta(['label' => 'Request a sandwich.']);

		$form = FormModel::fromArray([
			'formId' => 'form',
			'processors',
		]);
		$formArrayLike = FormArrayLike::fromModel($form);
		$callbackPre = new class($formArrayLike) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'fld1' ] = 'pre';
				return $formFields;
			}
		};
		$callbackMain = new class($formArrayLike) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'fld2' ] = 'main';
				return $formFields;
			}
		};
		$callbackPost = new class($formArrayLike) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'fld3' ] = 'post';
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
		$returnedFields = $processor->preProcess($fields, $request);
		$this->assertSame('pre', $returnedFields[ 'fld1' ]);
		$this->assertSame(2, $returnedFields[ 'fld2' ]);
		$this->assertSame(3, $returnedFields[ 'fld3' ]);
		$returnedFields = $processor->mainProcess($fields, $request);
		$this->assertSame('pre', $returnedFields[ 'fld1' ]);
		$this->assertSame('main', $returnedFields[ 'fld2' ]);
		$this->assertSame(3, $returnedFields[ 'fld3' ]);
		$returnedFields = $processor->postProcess($fields, $request);
		$this->assertSame('pre', $returnedFields[ 'fld1' ]);
		$this->assertSame('main', $returnedFields[ 'fld2' ]);
		$this->assertSame('post', $returnedFields[ 'fld3' ]);
	}


	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::addHooks()
	 * @covers \calderawp\caldera\Forms\CalderaForms::registerServices()
	 * @covers \calderawp\caldera\Forms\CalderaForms::addHooks()
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::preProcess()
	 */
	public function testPreProcessUpdatesRequest()
	{
		$fields = new FieldsArrayLike([
			'firstName' => 'Roy',
			'email' => 'roy@hiroy.club',
		]);

		$processorConfig = new ProcessorConfig([
			'settingOne' => 'firstName',
			'settingTwo' => 'setting2',
		]);
		$processorMeta = new ProcessorMeta(['label' => 'Request an airship.']);

		$form = FormModel::fromArray([
			'formId' => 'form',
			'processors',
		]);
		$formArrayLike = FormArrayLike::fromModel($form);
		$callbackPre = new class($formArrayLike) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'email' ] = 'pre-email';
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
		$form->getProcessors()->addProcessor($processor);
		$request = (new MockRequest())
			->setParam('formId', 'contact-form');
		$request->setParam('entryValues', $fields->toArray());

		$controller = new EntryController($this->calderaForms());
		$entry = $controller->createEntry(null, $request);
		$values = $entry->getEntryValues()->toArray();
		$this->assertSame('pre-email', $request->getParam('email'));
	}

	/**
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::addHooks()
	 * @covers \calderawp\caldera\Forms\CalderaForms::registerServices()
	 * @covers \calderawp\caldera\Forms\CalderaForms::addHooks()
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::preProcess()
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::process()
	 * @covers \calderawp\caldera\Forms\Filters\ProcessSubmissionFilters::postProcess()
	 */
	public function testProcessAllWithFilters()
	{
		$fields = new FieldsArrayLike([
			'firstName' => 'Roy',
			'email' => 'roy@hiroy.club',
		]);

		$processorConfig = new ProcessorConfig([
			'settingOne' => 'firstName',
			'settingTwo' => 'setting2',
		]);
		$processorMeta = new ProcessorMeta(['label' => 'Request an airship.']);

		$form = FormModel::fromArray([
			'formId' => 'form',
			'processors',
		]);
		$formArrayLike = FormArrayLike::fromModel($form);
		$callbackPre = new class($formArrayLike) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'email' ] = 'pre';
				return $formFields;
			}
		};
		$callbackMain = new class($formArrayLike) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'email' ] = 'main-email';
				return $formFields;
			}
		};
		$callbackPost = new class($formArrayLike) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'email' ] = 'post-email';
				$formFields[ 'firstName' ] = 'post-firstName';
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
		$form->getProcessors()->addProcessor($processor);
		$request = (new MockRequest())
			->setParam('formId', 'contact-form');
		$request->setParam('entryValues', $fields->toArray());

		$controller = new EntryController($this->calderaForms());
		$entry = $controller->createEntry(null, $request);
		$values = $entry->getEntryValues()->toArray();
		$this->assertSame('post-email', $values['email']['value']);
		$this->assertSame('post-firstName', $values['firstName']['value']);
	}
}
