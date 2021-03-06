<?php


namespace calderawp\caldera\Forms;

use calderawp\caldera\Forms\Contracts\ProcessorTypeContract as ProcessorType;
use calderawp\caldera\Forms\Contracts\ProcessorTypeContract;
use calderawp\caldera\Forms\Filters\ProcessSubmissionFilters;
use calderawp\caldera\Forms\Forms\ContactForm;
use calderawp\caldera\Forms\Processing\Types\ApiRequest;
use calderawp\CalderaContainers\Service\Container as ServiceContainer;
use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Module;
use calderawp\caldera\Forms\Contracts\CalderaFormsContract;
use calderawp\caldera\Forms\Contracts\FormsCollectionContract;
use calderawp\caldera\Forms\Contracts\FormModelContract;
use calderawp\caldera\Forms\Contracts\EntryCollectionContract;
use calderawp\caldera\Forms\Contracts\EntryContract;
use calderawp\caldera\DataSource\Contracts\SourceContract as Source;
use \calderawp\caldera\Forms\Contracts\DataSourcesContract as DataSources;

class CalderaForms extends Module implements CalderaFormsContract
{
	const IDENTIFIER = 'calderaForms';

	protected $dataSources;

	/**
	 * @var array
	 */
	protected $processorTypes;
	/**
	 * @inheritDoc
	 */
	public function getIdentifier(): string
	{
		return self::IDENTIFIER;
	}

	/**
	 * @inheritDoc
	 */
	public function registerServices(ServiceContainer $container): CalderaModule
	{
		//Create form collection
		$container->singleton(FormsCollectionContract::class, function () {
			return (new FormsCollection())->addForm(new ContactForm());
		});

		//Create entry collection
		$container->singleton(EntryCollectionContract::class, function () {
			return (new EntryCollection());
		});

		$this->addHooks();

		$this->addProcessorType(new ApiRequest());

		return $this;
	}

	/**
	 * Setup filters/actions
	 */
	protected function addHooks()
	{
		//Setup form processing
		$filters = $this
			->getCore()
			->getEvents()
			->getHooks();
		(new ProcessSubmissionFilters() )
			->addHooks($filters);
	}

	/** @inheritdoc */
	public function findForm(string $by, $searchValue = 'id'): FormsCollectionContract
	{
		if ($this->hasPrimaryDataSourceSet()) {
			return $this;
		}
		$found = [];
		if ('id' === $by) {
			try {
				$form = $this->findFormById($searchValue);
				$found[] = $form;
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
			//@todo
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

	/**
	 * Get forms  collection
	 *
	 * @return FormsCollectionContract
	 */
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
	public function findEntryBy(string $by, $searchValue = 'id'): EntryCollectionContract
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
	 * @inheritDoc
	 */
	public function setPrimaryDataSource(DataSources $sources): CalderaFormsContract
	{
		$this->dataSources = $sources;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getPrimaryDataSource(): DataSources
	{
		return $this->dataSources;
	}

	/**
	 * @inheritDoc
	 */
	public function addProcessorType(ProcessorType $processorType): CalderaFormsContract
	{
		$this->processorTypes[$processorType->getProcessorType()] = $processorType;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getProcessorTypes(): array
	{
		return ! empty($this->processorTypes) ? $this->processorTypes : [];
	}

	protected function hasPrimaryDataSourceSet() : bool
	{
		return isset($this->dataSources);
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
