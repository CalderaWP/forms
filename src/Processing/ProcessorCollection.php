<?php


namespace calderawp\caldera\Forms\Processing;

use calderawp\interop\Contracts\InteroperableCollectionContract;
use calderawp\interop\Contracts\ProcessorContract;
use calderawp\interop\Contracts\ProcessorCollectionContract;
use calderawp\interop\Collection;

use calderawp\interop\Traits\ItemsIterator;

/**
 * Class ProcessorCollection
 *
 * Representation of 0 or more individual processors
 * May be all processors of a form, or all processors that are installed.
 */
class ProcessorCollection extends Collection implements ProcessorCollectionContract, \IteratorAggregate
{

	use
		//Allows for foreach to be used on instances of this class
		ItemsIterator;

	/** @inheritdoc */
	public static function fromArray(array $items): InteroperableCollectionContract
	{
		$obj = new static;
		foreach ($items as $item) {
			if (is_array($item)) {
				$item = Processor::fromArray($item);
			}
			if (is_a($item, Processor::class)) {
				$obj->addProcessor($item);
			}
		}
		return $obj;
	}

	/** @inheritdoc */
	public function toArray(): array
	{
		$array = [];
		if (! empty($this->items)) {
			foreach ($this->items as $processorId => $processor) {
				$array[$processorId]=$processor->toArray();
			}
		}
		return $array;
	}

	/** @inheritdoc */
	public function addProcessor(ProcessorContract $processor) : ProcessorCollectionContract
	{
		$this->items[$processor->getId()] = $processor;
		return $this;
	}

	/**
	 * Find item by ID
	 *
	 * @param string|int $id
	 *
	 * @return Processor|null
	 */
	public function getProcessor($id) : ?ProcessorContract
	{
		if ($this->has($id)) {
			return $this->items[$id];
		}
		return null;
	}

	/** @inheritdoc */
	protected function setterName(): string
	{
		return 'addProcessor';
	}

	/** @inheritdoc */
	public function hasProcessorOfType(string  $processorType): bool
	{
		if (empty($this->items)) {
			return false;
		}

		/** @var Processor $processor */
		foreach ($this->items as $processor) {
			if ($processorType === $processor->getProcessorType()) {
				return true;
			}
		}
		return false;
	}
}
