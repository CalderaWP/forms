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
	const CONSENT = 'consent';
	const SUBMIT = 'submitButton';

	public function __construct()
	{
		$this->setupFields();
		$this->setName('Contact Form');
		$this->setId('contact-form');
	}


	protected function setupFields()
	{
		$this->fields = new FieldsCollection();
		$this->fields->addField(
			FieldModel::fromArray(
				[
					'id' => self::FIRST_NAME,
					'type' => 'text',
					'label' => 'Your Name'
				]
			)
		);
		$this->fields->addField(
			FieldModel::fromArray(
				[
					'id' => self::EMAIL,
					'type' => 'text',
					'html5type' => 'email',
					'label' => 'Your Email'
				]
			)
		);
		$this->fields->addField(
			FieldModel::fromArray(
				[
					'id' => self::CONSENT,
					'type' => 'checkbox',
					'html5type' => 'email',
					'label' => 'Do you consent to sharing your personally identifying data?',
					'description' => 'Learn more by reading our privacy policy'
				]
			)
		);
		$this->fields->addField(
			FieldModel::fromArray(
				[
					'id' => self::SUBMIT,
					'type' => 'button',
					'label' => 'Send Message'
				]
			)
		);
	}

	public function getFields(): HasFields
	{

		return $this->fields;
	}
}
