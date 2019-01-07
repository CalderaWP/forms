<?php

namespace calderawp\caldera\Forms\Tests\Processing;

use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FieldsArrayLike;
use calderawp\caldera\Forms\FormArrayLike;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\Processing\ProcessorConfig;
use calderawp\caldera\Forms\Processing\ProcessorMeta;
use calderawp\caldera\Forms\Tests\TestCase;
use calderawp\caldera\Forms\Processing\Processor;
use calderawp\caldera\Forms\Processing\ProcessCallback;
use calderawp\caldera\restApi\Request;

class ProcessorTest extends TestCase
{


	public function testCheckConditionals()
	{
		$this->markTestSkipped('Not implemented yet');
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\Processor::postProcess();
	 */
	public function testPostProcess()
	{
		$fields = new FieldsArrayLike([
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
			new ProcessorMeta(['label' => 'Send an sms']),
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

	/**
	 * This function must exist, and never run.
	 */
	public function noop()
	{
		throw new \Exception('The handler that was not supposed to be called was called');
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\Processor::preProcess()
	 */
	public function testPreProcess()
	{
		$fields = new FieldsArrayLike([
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
			new ProcessorMeta(['label' => 'Send an sms']),
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

	/**
	 * @covers \calderawp\caldera\Forms\Processing\Processor::getForm()
	 */
	public function testGetForm()
	{
		$form = $this->getFormArrayLike();
		$processor = new class(
			new ProcessorMeta(['label' => 'Send an sms']),
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

	/**
	 * @covers \calderawp\caldera\Forms\Processing\Processor::mainProcess()
	 */
	public function testMainProcess()
	{
		$fields = new FieldsArrayLike([
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
			new ProcessorMeta(['label' => 'Send an sms']),
			$processorConfig,
			$form,
			[
				Processor::PRE_PROCESS => [$this, 'noop'],
				Processor::MAIN_PROCESS => $processCallback,
				Processor::POST_PROCESS => [$this, 'noop'],
			]) extends Processor
		{
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


	/**
	 * @covers \calderawp\caldera\Forms\Processing\Processor::toArray()
	 */
	public function testToArray()
	{
		$processorConfig = new ProcessorConfig([
			'settingOne' => 'fld1',
			'settingTwo' => 'Hats',
		]);
		$form = $this->getFormArrayLike();
		$processor = new class(
			new ProcessorMeta(['label' => 'Send an sms']),
			$processorConfig,
			$form,
			[]) extends Processor
		{
			public function getProcessorType(): string
			{
				return 'testType';
			}
		};
		$this->assertSame('testType', $processor->toArray()[ 'type' ]);
		$this->assertSame([
			'settingOne' => 'fld1',
			'settingTwo' => 'Hats',
		], $processor->toArray()[ 'config' ]);
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\Processor::toArray()
	 * @covers \calderawp\caldera\Forms\Processing\Processor::fromArray()
	 */
	public function testFromArrayTest()
	{
		$array = [
			'label' => 'The Label',
			'type' => 'testType',
			'config' =>
				[
					'settingOne' => 'fld1',
					'settingTwo' => 'Hats',
				]
		];
		$this->assertEquals($array, Processor::fromArray($array)->toArray());
	}

	/**
	 * @covers \calderawp\caldera\Forms\Processing\Processor::toArray()
	 */
	public function testConfigFromArray()
	{
		$processor = [
			'type' => 'apiRequest',
			'label' => 'Test sending form data to test API',
			'config' => [
				'requestURL' => 'https://something.com',
				'requestMethod' => 'POST',
				'responseField' => 'message',
				'fieldToUpdate' => 'apiMessage',
			]
		];
		$processor = Processor::fromArray($processor);
		$this->assertIsObject($processor->getProcessorConfig());
		$config = $processor->getProcessorConfig();
		$this->assertSame(
			'https://something.com',
			$config['requestURL']
		);
		$this->assertSame(
			'POST',
			$config['requestMethod']
		);
		$this->assertSame(
			'message',
			$config['responseField']
		);
		$this->assertSame(
			'apiMessage',
			$config['fieldToUpdate']
		);

	}
}
