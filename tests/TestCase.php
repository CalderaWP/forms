<?php


namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\Entry\EntryValue;
use calderawp\caldera\Forms\Field\FieldOption;
use calderawp\caldera\Forms\Field\FieldOptions;
use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FieldsCollection;
use calderawp\caldera\Forms\FormModel;
use calderawp\CalderaContainers\Service\Container;
use PHPUnit\Framework\TestCase as _TestCase;

abstract class TestCase extends \Mockery\Adapter\Phpunit\MockeryTestCase
{


	protected function serviceContainer():Container
	{
		return new Container();
	}
	protected function form($formId = null, array $data = []): FormModel
	{
		return FormModel::fromArray(array_merge(['id' => $formId], $data));
	}

	protected function field($fieldId = null, array $data = [], FormModel $formModel = null): FieldModel
	{
		if (!$formModel) {
			$formModel = $this->form();
		}
		if (!$fieldId) {
			$fieldId = uniqid('fld');
		}

		$field = FieldModel::fromArray(array_merge(['id' => $fieldId], $data));

		$formModel->setFields((new FieldsCollection())->addField($field));
		$field->setForm($formModel);
		return $field;
	}

	protected function fieldOptions(): FieldOptions
	{
		return FieldOptions::fromArray([
			$this->optionOne(),
			$this->optionTwo(),
		]);
	}

	protected function optionTwo(): FieldOption
	{
		return FieldOption::fromArray([
			'id' => 'opt22',
			'value' => 'w',
			'label' => 'Option Two',
			'calcValue' => 2,
		]);
	}

	protected function optionOne(): FieldOption
	{
		return FieldOption::fromArray([
			'id' => 'opt1',
			'value' => '1',
			'label' => 'Option One',
			'calcValue' => 1,
		]);
	}

	protected function entryValue($value = null, $fieldId = null): EntryValue
	{
		$form = $this->form();
		$field = $this->field($fieldId, [], $form);
		return (new EntryValue($form, $field))->setValue($value);
	}
}
