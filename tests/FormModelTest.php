<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\Processing\Processor;
use calderawp\caldera\Forms\Processing\ProcessorCollection;
use calderawp\interop\Tests\TestCase;
use calderawp\interop\Contracts\CalderaForms\HasField;
use calderawp\interop\Contracts\CalderaForms\HasForm;
use calderawp\interop\Tests\Traits\EntityFactory;

class FormModelTest extends TestCase
{

	use EntityFactory;

	/**
	 * @covers FormModel::fromArray()
	 */
	public function testFromArray()
	{
		$form = $this->getForm();
		$fields = $this->getFields();
		$settings = $this->getSettings();
		$model = FormModel::fromArray([
			'form' => $form,
			'fields' => $fields,
			'settings' => $settings,
		]);
		$this->assertAttributeEquals($form, 'form', $model);
		$this->assertAttributeEquals($fields, 'fields', $model);
		$this->assertAttributeEquals($settings, 'settings', $model);
	}

	/**
	 * @covers FormModel::toArray()
	 * @covers \calderawp\interop\Traits\ConvertsInteropModelToArray::toArray()
	 */
	public function testToArray()
	{
		$form = $this->getForm();
		$form->shouldReceive('toArray')->andReturn([]);

		$fields = $this->getFields();
		$fields->shouldReceive('toArray')->andReturn([]);
		$settings = $this->getSettings();
		$settings->shouldReceive('toArray')->andReturn([]);

		$model = FormModel::fromArray([
			'form' => $form,
			'fields' => $fields,
			'settings' => $settings,
		]);
		$array = $model->toArray();
		$this->assertEquals([], $array[ 'form' ]);
		$this->assertEquals([], $array[ 'fields' ]);
		$this->assertEquals([], $array[ 'settings' ]);
	}


	public function testFieldsFromArray()
	{
		$array = [
			'id' => 'cf1',
			'fields' => [
				'name' => [
					'id' => 'name',
					'type' => 'input',
					'label' => 'Your Name',
					'required' => true,
					'description' => 'Put your name here',
					'config' => [
						'html5type' => ''
					]
				],
				'numberOfItems' => [
					'id' => 'numberOfItems',
					'type' => 'input',
					'label' => 'Total',
					'description' => 'How many items?',
					'fieldConfig' => [
						'html5type' => 'number',
						'attributes' => [
							'min' => 0,
							'step' => 1
						]
					]
				],
				'agreeToTerms' => [
					'id' => 'agreeToTerms',
					'type' => 'select',
					'label' => 'Agree to terms',
					'description' => 'Compliance is mandatory',
					'fieldConfig' => [
						'multiple' => false,
						'options' => [
							[
								'value' => true,
								'label' => 'Yes'
							],
							[
								'value' => false,
								'label' => 'No'
							]
						]
					]
				]
			]
		];

		$model = FormModel::fromArray($array);
		$this->assertSame('cf1', $model->getId());
		$this->assertTrue($model->getFields()->hasField('agreeToTerms'));
		$this->assertCount(2, $model->toArray()['fields']['agreeToTerms']['fieldConfig']['options']);
	}

	/**
	 * @covers \calderawp\caldera\Forms\FormModel::getProcessors()
	 * @covers \calderawp\caldera\Forms\FormModel::setProcessors()
	 */
	public function testGetSetProcessors()
	{
		$processors = \Mockery::mock('AutoResponder', ProcessorCollection::class);
		$model = new FormModel();
		$model->setProcessors($processors);
		$this->assertSame($processors, $model->getProcessors());
	}
}
