<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\FormModel;
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
		$fields = $this->getFields();
		$settings = $this->getSettings();
		$model = FormModel::fromArray([
			'form' => $form,
			'fields' => $fields,
			'settings' => $settings,
		]);
		$array = $model->toArray();
		$this->assertEquals($form, $array[ 'form' ]);
		$this->assertEquals($fields, $array[ 'fields' ]);
		$this->assertEquals($settings, $array[ 'settings' ]);
	}
}
