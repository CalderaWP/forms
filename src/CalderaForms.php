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
use calderawp\caldera\Forms\Contracts\EntryCollectionContract;
use calderawp\caldera\Forms\Contracts\EntryContract;

class CalderaForms extends Module implements CalderaFormsContract
{
	/**
	 * @inheritDoc
	 */
	public function getIdentifier(): string
	{
		return 'calderaForms';
	}

	public function registerServices(ServiceContainer $container): CalderaModule
	{
		$container->singleton(FormsCollectionContract::class, function () {
			return (new FormsCollection())->addForm(new ContactForm());
		});

		$container->singleton(EntryCollectionContract::class, function () {
			return (new EntryCollection());
		});

		return $this;
	}


	public function getFormsDb(): FormsDb
	{
	}

	public function findForm(string $by, $searchValue): FormsCollectionContract
	{
		$found = [];
		if ('id' === $by) {
			try {
				$form = $this->findFormById($searchValue);
				$found[] =  $form;
			} catch (Exception $e) {
				throw $e;
			}
		} elseif (in_array($by, [
			'name',
		])) {
			switch ($by) {
				case 'name':
					foreach ($this->getForms()->toArray() as $form) {
						if ($searchValue === $form[ 'name' ]) {
							$found[] = $form = $this->findFormById($form[ 'id' ]);
						}
					}
			}
		} else {
		}
		if (empty($found)) {
			throw new Exception('Form not found', 404);
		}

		$collection = new FormsCollection();
		foreach ($found as $form) {
			$collection->addForm($form);
		}

		return $collection;
	}

	public function getForms(): FormsCollectionContract
	{
		return $this
			->getServiceContainer()
			->make(FormsCollectionContract::class);
	}


	/**
	 * @param string $by
	 * @param $searchValue
	 *
	 * @return EntryCollectionContract
	 * @throws Exception
	 */
	public function findEntryBy(string $by, $searchValue): EntryCollectionContract
	{
		if ('id' === $by) {
			if ($this->getEntries()->hasEntry($searchValue)) {
				return (new EntryCollection())
					->addEntry($this->getEntries()->getEntry($searchValue));
			}
			throw new Exception('Entry not found', 404);
		} elseif (in_array($by, [
			'formId',
			//'userId',
			//'primaryEmail',
			//'fieldValue'
		])) {
			$entries = $this->getEntries()->toArray();
			$found = [];
			if (!empty($entries)) {
				foreach ($entries as $entry) {
					if ($searchValue === $entry[ 'formId' ]) {
						$found[] = $this
							->getEntries()
							->getEntry($entry[ 'id' ]);
					}
				}
			}
			if (empty($found)) {
				throw new Exception('Entry not found', 404);
			} else {
				$collection = new EntryCollection();
				foreach ($found as $entry) {
					$collection->addEntry($entry);
				}
				return $collection;
			}
		} else {
			throw new Exception('Entry not found', 404);
		}
	}

	/**
	 * @return EntryCollectionContract
	 */
	public function getEntries(): EntryCollectionContract
	{
		return $this
			->getServiceContainer()
			->make(EntryCollectionContract::class);
	}

	/**
	 * @param $searchValue
	 *
	 * @return FormModelContract
	 */
	protected function findFormById($searchValue): FormModelContract
	{
		$form = $this
			->getForms()
			->getForm($searchValue);
		return $form;
	}
}
