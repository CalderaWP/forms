<?php


namespace calderawp\caldera\Forms\Forms;

use calderawp\caldera\Forms\Field\FieldConfig;
use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FieldsCollection;
use calderawp\caldera\Forms\FormModel;
use calderawp\interop\Contracts\CalderaForms\HasFields;

class ContactForm extends FormModel
{


	/**
	 * @var FieldsCollection
	 */
	protected $fields;
	const FIRST_NAME = 'firstName';
	const EMAIL = 'email';
	const CONSENT = 'consent';
	const SUBMIT = 'submitButton';
	const ID = 'contact-form';

	public function __construct()
	{
		$this->setupFields();
		$this->setName('Contact Form');
		$this->setId(self::ID);
	}

	/** @inheritdoc */
	public function toArray(): array
	{
		$form = parent::toArray();
		unset($form['fields'][self::SUBMIT]);
		foreach ($form['fields'] as $index => $field) {
			$form['fields'][$index]['fieldType' ] = $field['type'];
			$form['fields'][$index]['fieldId' ] = $field['id'];
		}
		$fields = $form['fields'];
		$form[ 'rows' ] = [
			[
				'rowId' => 'info-row',
				'columns' => [
					[
						'width' => '1/2',
						'fields' => [
							$fields[self::FIRST_NAME]
						]
					],
					[
						'width' => '1/2',
						'fields' => [
							$fields[self::EMAIL]
						]
					]
				]
			],
			[
				'rowId' => 'privacy-row',
				'columns' => [
					[
						'width' => '1',
						'fields' => [
							$fields[self::CONSENT]
						]
					]
				]
			]

		];
		return $form;
	}

	/**
	 * Add fields to form
	 */
	protected function setupFields()
	{
		$this->fields = new FieldsCollection();
		$this->fields->addField(
			FieldModel::fromArray(
				[
					'id' => self::FIRST_NAME,
					'type' => 'text',
					'label' => 'Your Name',
				]
			)
		);
		$this->fields->addField(
			FieldModel::fromArray(
				[
					'id' => self::EMAIL,
					'type' => 'text',
					'html5type' => 'email',
					'label' => 'Your Email',
				]
			)
		);
		$this->addConsentField();
		$this->fields->addField(
			FieldModel::fromArray(
				[
					'id' => self::SUBMIT,
					'type' => 'button',
					'label' => 'Send Message',
				]
			)
		);
	}

	public function getFields(): HasFields
	{

		return $this->fields;
	}

	protected function addConsentField(): void
	{


		$field = FieldModel::fromArray(
			[
				'id' => self::CONSENT,
				'type' => 'checkbox',
				'label' => 'Do you consent to sharing your personally identifying data?',
				'description' => 'Learn more by reading our privacy policy',

			]
		);
		$this->fields->addField($field);
	}
}
