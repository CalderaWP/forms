<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FormArrayLike;
use calderawp\caldera\Forms\FormModel;

class FormArrayLikeTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\FormArrayLike::fromModel()
	 */
	public function testFromModel()
	{

		$fieldId = 'fld1';
		$field = FieldModel::fromArray(
			[
				'id' => $fieldId,
				'slug' => '',
			]
		);
		$model = FormModel::fromArray([
			'form' => $this->form(),
			'fields' => [$field],
		]);

		$formArray = FormArrayLike::fromModel($model);
		$this->assertSame($fieldId, $formArray['fields'][$fieldId]['id']);

	}

	/**
	 * @covers \calderawp\caldera\Forms\FormArrayLike::toArray()
	 */
	public function testToArray(){
		$fieldId = 'fld1';
		$field = FieldModel::fromArray(
			[
				'id' => $fieldId,
				'slug' => '',
			]
		);
		$model = FormModel::fromArray([
			'form' => $this->form(),
			'fields' => [$field],
		]);

		$formArray = FormArrayLike::fromModel($model);
		$array = $formArray->toArray();
		$this->assertSame($fieldId, $array['fields'][$fieldId]['id']);
	}
}
