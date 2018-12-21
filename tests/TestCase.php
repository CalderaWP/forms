<?php


namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\Field\FieldOption;
use calderawp\caldera\Forms\Field\FieldOptions;
use PHPUnit\Framework\TestCase as _TestCase;

abstract class TestCase extends \Mockery\Adapter\Phpunit\MockeryTestCase
{


	protected function fieldOptions() : FieldOptions
	{
		return FieldOptions::fromArray([
			$this->optionOne(),
			$this->optionTwo()
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

}
