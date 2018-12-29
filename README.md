# Forms

Provides form functionality, including entry tracking.

## Examples
### Form Model
* Simple Example
```
$model = FormModel::fromArray([
    'id' => 'cf1',
    'name' => 'Contact Form',
    'fields' => [],
    'settings' => []
]);
```

* Example 2
```
//Create model
$form = \calderawp\caldera\Forms\FormModel::fromArray([
	'id' => 'cf1',
	'name' => 'Contact Form'
]);

//Email field
$emailField = \calderawp\caldera\Forms\FieldModel::fromArray([
	'id' => 'fld1',
	'type' => 'text',
	'slug' => 'email',
	'html5type' => 'email',
	'label' => 'Your Email'
]);

//Checkbox with two options
$checkBoxField = \calderawp\caldera\Forms\FieldModel::fromArray(
	[
		'id' => 'fld2',
		'type' => 'checkbox', //radio or select has same syntax for options
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

//Add fields to form
$form
	->addField($emailField)
	->addField($checkBoxField);

```

### Field Model

* Text field
```php
$field = \calderawp\caldera\Forms\FieldModel::fromArray([
	'id' => 'fld1',
	'type' => 'text',
	'slug' => 'name',
	'label' => 'Your Name'
]);
```

* Email field
```php
$field = \calderawp\caldera\Forms\FieldModel::fromArray([
	'id' => '',
	'type' => 'text',
    'html5type' => 'email',
	'slug' => '',
	'label' => '',
	'description' => ''
]);
```

* Number field
```php
$field = \calderawp\caldera\Forms\FieldModel::fromArray([
	'id' => '',
	'type' => 'text',
    'html5type' => 'number',
	'slug' => '',
	'label' => '',
	'description' => '',
	'attributes' => [
        'min' => 5,
        'max' => 12
    ]
]);
```


