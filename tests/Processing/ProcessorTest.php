<?php

namespace calderawp\caldera\Forms\Tests\Processing;

use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FormArrayLike;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\Processing\FormFieldsWithUpdate;
use calderawp\caldera\Forms\Processing\ProcessorConfig;
use calderawp\caldera\Forms\Tests\TestCase;
use calderawp\caldera\Forms\Processing\Processor;
use calderawp\caldera\Processing\ProcessCallback;
use calderawp\caldera\restApi\Request;


class ProcessorTest extends TestCase
{


	public function testCheckConditionals()
	{
		$this->markTestSkipped('Not implemented yet');
	}

	public function testPostProcess()
	{
		$fields = new FormFieldsWithUpdate([
			'fld1' => 7,
		]);
		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'Hats',
		]);

		$request = \Mockery::mock('Request', Request::class);
		$processCallback = \Mockery::mock('PostProcessController', ProcessCallback::class);
		$processCallback
			->shouldReceive('process')
			->andReturn($fields);
		$form = $this->getFormArrayLike();
		$processor = new class(
			['slug' => 'send-sms'],
			$processorConfig,
			$form,
			[
				Processor::POST_PROCESS => $processCallback,
			]
		) extends Processor
		{
			public function getProcessorType(): string
			{
				return 'testType';
			}
		};

		$processor->postProcess($fields, $request);


	}

	public function noop()
	{
	}

	public function testPreProcess()
	{
		$fields = new FormFieldsWithUpdate([
			'fld1' => 7,
		]);
		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'Hats',
		]);

		$request = \Mockery::mock('Request', Request::class);
		$processCallback = \Mockery::mock('PreProcessController', ProcessCallback::class);
		$processCallback
			->shouldReceive('process')
			->andReturn($fields);
		$form = $this->getFormArrayLike();

		$processor = new class(
			['slug' => 'send-sms'],
			$processorConfig,
			$form,
			[
				Processor::PRE_PROCESS => $processCallback,
				Processor::POST_PROCESS => [$this, 'noop'],
			]
		) extends Processor
		{
			public function getProcessorType(): string
			{
				return 'testType';
			}
		};

		$processor->preProcess($fields, $request);
	}

	public function testGetForm()
	{
		$form = $this->getFormArrayLike();
		$processor = new class(
			['slug' => 'send-sms'],
			new ProcessorConfig(),
			$form
		) extends Processor
		{
			public function getProcessorType(): string
			{
				return 'testType';
			}
		};
		$this->assertEquals($form, $processor->getForm());
	}


	public function testMainProcess()
	{
		$fields = new FormFieldsWithUpdate([
			'fld1' => 7,
		]);
		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'Hats',
		]);

		$request = \Mockery::mock('Request', Request::class);
		$processCallback = \Mockery::mock('PreProcessController', ProcessCallback::class);
		$processCallback
			->shouldReceive('process')
			->andReturn($fields);
		$form = $this->getFormArrayLike();

		$processor = new class(['slug' => 'send-sms'],
			$processorConfig,
			$form,
			[
				Processor::PRE_PROCESS => [$this, 'noop'],
				Processor::PROCESS => $processCallback,
				Processor::POST_PROCESS => [$this, 'noop'],
			] ) extends Processor{
			public function getProcessorType(): string
			{
				return 'testType';
			}
		};
		$processor->mainProcess($fields, $request);
	}

	protected function getFormArrayLike(): FormArrayLike
	{
		$field = FieldModel::fromArray(
			[
				'id' => 'fld1',
				'slug' => '',
			]
		);
		$model = FormModel::fromArray([
			'form' => $this->form(),
			'fields' => [$field],
		]);

		return FormArrayLike::fromModel($model);
	}
}
