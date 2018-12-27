<?php


namespace calderawp\caldera\Forms\Forms;

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
	const SUBMIT = 'submitButton';

	public function __construct()
	{
	}

	public function getFields(): HasFields
	{

		$this->fields = FieldsCollection::fromArray(
			[
				[
					'id' => self::FIRST_NAME,
					'type' => 'text',
					'label' => 'Your Name'
				], [
					'id' => self::EMAIL,
					'type' => 'text',
					'html5type' => 'email',
					'label' => 'Your Email',
				], [
					'id' => self::SUBMIT,
					'type' => 'button',
					'buttonType' => 'submit',
					'label' => 'Send Message',
				]
			]
		);


		return $this->fields;
	}
}
