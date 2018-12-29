<?php

$form = \calderawp\caldera\Forms\FormModel::fromArray([
	'id' => 'cf1',
	'name' => 'Contact Form'
]);

$emailField = \calderawp\caldera\Forms\FieldModel::fromArray([
	'id' => 'fld1',
	'type' => 'text',
	'slug' => 'email',
	'html5type' => 'email',
	'label' => 'Your Email'
]);
$checkBoxField = \calderawp\caldera\Forms\FieldModel::fromArray(
	[
		'id' => 'fld2',
		'type' => 'checkbox',
		'label' => 'I agree to privacy policy',
		'description' => 'Learn more by reading our privacy policy',
		'options' =>[
			[
				'label' => 'Yes',
				'value' => true
			],
			[
				'label' => 'No',
				'value' => false
			]
		]
	]
);

$form
	->addField($emailField)
	->addField($checkBoxField);
