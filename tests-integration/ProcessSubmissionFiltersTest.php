<?php

namespace calderawp\caldera\Forms\Tests\Integration;

use calderawp\caldera\Forms\Controllers\EntryController;
use calderawp\caldera\Forms\Entry\Entry;
use calderawp\caldera\Forms\Entry\EntryValue;
use calderawp\caldera\Forms\Entry\EntryValues;
use calderawp\caldera\Forms\FieldModel;
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
		$callback = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
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
		$callback = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
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
		$callback = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
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
		$callbackPre = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'fld1' ] = 'pre';
				return $formFields;
			}
		};
		$callbackMain = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields[ 'fld2' ] = 'main';
				return $formFields;
			}
		};
		$callbackPost = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
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
		$type = 'zeplinrequester';
		$processorMeta = new ProcessorMeta(['label' => 'Request an airship.', 'type' => $type]);

		$formId = 'testPreProcessUpdatesRequestFORMID';
		$form = FormModel::fromArray([
			'id' => $formId,
			'processors',
		]);
		$calderaForms = \caldera()->getCalderaForms();

		$calderaForms
			->getForms()
			->addForm($form);

		$formArrayLike = FormArrayLike::fromModel($form);
		$callbackPre = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
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
		$this->assertTrue($form->getProcessors()->hasProcessorOfType($type));
		$request = (new MockRequest())
			->setParam('formId', $formId);
		$request->setParam('entryValues', $fields->toArray());

		$controller = new EntryController($calderaForms);
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
	public function testMainProcessUpdatesEntry()
	{

		$fieldId1 = 'f1';
		$fieldId2 = 'f2';


		$fields = new FieldsArrayLike([
			$fieldId1 => 'Roy',
			$fieldId2 => 'roy@hiroy.club',
		]);

		$processorConfig = new ProcessorConfig([
			'settingOne' => 'firstName',
			'settingTwo' => 'setting2',
		]);
		$processorMeta = new ProcessorMeta(['label' => 'Request an airship.']);

		$formId = 'testProcessAllWithFiltersFORMID';

		$form = FormModel::fromArray([
			'id' => $formId,
			'fields' => [
				FieldModel::fromArray(
					[
						'id' => $fieldId1,
						'type' => 'input',
					]
				),
				FieldModel::fromArray(
					[
						'id' => $fieldId2,
						'type' => 'input',
					]
				),
			],
		]);

		$formArrayLike = FormArrayLike::fromModel($form);

		$callbackMain = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields['f1' ] = 'main';
				$formFields['f2' ] = 'main';
				return $formFields;
			}
		};

		$processor = new Processor(
			$processorMeta,
			$processorConfig,
			$formArrayLike,
			[
				Processor::MAIN_PROCESS => $callbackMain,
			]
		);
		$form->getProcessors()->addProcessor($processor);
		\caldera()->getCalderaForms()->getForms()->addForm($form);

		$request = (new MockRequest())
			->setParam('formId', $formId);
		$controller = new EntryController(\caldera()->getCalderaForms());

		$entryId1 = 11 + rand(2, 8);
		$entryId2 = 22 + rand(10, 20);
		$field = $this->field($fieldId1, [], $form);
		$field2 = $this->field($fieldId2, [], $form);
		$entryValue = (new EntryValue($form, $field))->setId($entryId1);
		$entryValue2 = (new EntryValue($form, $field2))->setId($entryId2);


		$request->setParam('entryValues', $fields->toArray());
		$suppliedEntry = new Entry();
		$entryValues = new EntryValues();
		$entryValues->addValue($entryValue);
		$entryValues->addValue($entryValue2);

		$suppliedEntry->setEntryValues($entryValues);

		$returnedEntry = $controller->createEntry($suppliedEntry, $request);
		$values = $returnedEntry->getEntryValues()->toArray();
		$this->assertIsArray($values);
		$this->assertNotEmpty($values);
		$tests = 0;
		foreach ($returnedEntry->getEntryValues()->getValues() as $value ){
			if( 'f1' === $value->getFieldId() ){
				$this->assertSame( 'main', $value->getValue() );
			}
			if( 'f2' === $value->getFieldId() ){
				$this->assertSame( 'main', $value->getValue() );
			}
			$tests++;
		}
		$this->assertSame(2,$tests);


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

		$fieldId1 = 'f1';
		$fieldId2 = 'f2';


		$fields = new FieldsArrayLike([
			$fieldId1 => 'Roy',
			$fieldId2 => 'roy@hiroy.club',
		]);

		$processorConfig = new ProcessorConfig([
			'settingOne' => 'firstName',
			'settingTwo' => 'setting2',
		]);
		$processorMeta = new ProcessorMeta(['label' => 'Request an airship.']);

		$formId = 'testProcessAllWithFiltersFORMID';

		$form = FormModel::fromArray([
			'id' => $formId,
			'fields' => [
				FieldModel::fromArray(
					[
						'id' => $fieldId1,
						'type' => 'input',
					]
				),
				FieldModel::fromArray(
					[
						'id' => $fieldId2,
						'type' => 'input',
					]
				),
			],
		]);

		$formArrayLike = FormArrayLike::fromModel($form);
		$callbackPre = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request) : FormFields
			{
				$formFields['f1' ] = 'pre';
				return $formFields;
			}
		};
		$callbackMain = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields['f1' ] = 'main';
				$formFields['f2' ] = 'setAtMainShouldGetResetByPost';
				return $formFields;
			}
		};
		$callbackPost = new class($formArrayLike,$this->calderaForms()) extends ProcessCallback
		{
			public function process(FormFields $formFields, Request $request): FormFields
			{
				$formFields['f2' ] = 'post';
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
		\caldera()->getCalderaForms()->getForms()->addForm($form);

		$request = (new MockRequest())
			->setParam('formId', $formId);
		$controller = new EntryController(\caldera()->getCalderaForms());

		$entryId1 = 11 + rand(2, 8);
		$entryId2 = 22 + rand(10, 20);
		$field = $this->field($fieldId1, [], $form);
		$field2 = $this->field($fieldId2, [], $form);
		$entryValue = (new EntryValue($form, $field))->setId($entryId1);
		$entryValue2 = (new EntryValue($form, $field2))->setId($entryId2);


		$request->setParam('entryValues', $fields->toArray());
		$suppliedEntry = new Entry();
		$entryValues = new EntryValues();
		$entryValues->addValue($entryValue);
		$entryValues->addValue($entryValue2);

		$suppliedEntry->setEntryValues($entryValues);

		$returnedEntry = $controller->createEntry($suppliedEntry, $request);
		$values = $returnedEntry->getEntryValues()->toArray();
		$this->assertIsArray($values);
		$this->assertNotEmpty($values);
		$tests = 0;
		foreach ($returnedEntry->getEntryValues()->getValues() as $value ){
			if( 'f1' === $value->getFieldId() ){
				$this->assertSame( 'main', $value->getValue() );
			}
			if( 'f2' === $value->getFieldId() ){
				$this->assertSame( 'post', $value->getValue() );
			}
			$tests++;
		}
		$this->assertSame(2,$tests);


	}
}
