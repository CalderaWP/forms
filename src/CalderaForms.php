<?php


namespace calderawp\caldera\Forms;

use calderawp\caldera\Forms\Forms\ContactForm;
use calderawp\CalderaContainers\Service\Container as ServiceContainer;
use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Module;
use calderawp\caldera\Db\Contracts\FormsDb;
use calderawp\caldera\Forms\Contracts\CalderaFormsContract;
use calderawp\caldera\Forms\Contracts\FormsCollectionContract;
use calderawp\caldera\Forms\Contracts\FormModelContract;

class CalderaForms extends Module implements CalderaFormsContract
{
	/**
	 * @inheritDoc
	 */
	public function getIdentifier(): string
	{
		return 'calderaForms';
	}

	public function registerServices(ServiceContainer$container): CalderaModule
	{
		$container->singleton(FormsCollectionContract::class, function () {
			return (new FormsCollection())->addForm(new ContactForm());
		});

		return $this;
	}


	public function getFormsDb(): FormsDb
	{
	}

	public function findForm(string $by, $arg) :FormModelContract
	{
		if ('id' === $by) {
			try {
				$form = $this
					->getForms()
					->getForm($arg);
				return $form;
			} catch (Exception $e) {
				throw $e;
			}
		} elseif (in_array($by, [
			'name',
		])) {
			switch ($by) {
				case 'name':
					foreach ($this->getForms()->toArray() as $form) {
						if ($arg === $form['name']) {
							return $this->findForm('id', $form['id']);
						}
					}
			}
			throw new Exception('Form not found', 404);
		} else {
		}
	}

	public function getForms():FormsCollectionContract
	{
		return $this
			->getServiceContainer()
			->make(FormsCollectionContract::class);
	}

	public function getEntryBy(string $by, $arg)
	{
		if ('id' === $by) {
		} elseif (in_array($by, [
			'formId',
			'userId',
			'primaryEmail',
			'fieldValue'
		])) {
		} else {
		}
	}
}
