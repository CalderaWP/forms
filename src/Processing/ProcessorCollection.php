<?php


namespace calderawp\caldera\Forms\Processing;

use calderawp\interop\Contracts\InteroperableCollectionContract;
use calderawp\interop\Contracts\ProcessorContract;
use calderawp\interop\Contracts\ProcessorCollectionContract;
use calderawp\interop\Collection;

use calderawp\interop\Traits\ItemsIterator;

class ProcessorCollection extends Collection implements ProcessorCollectionContract
{

	use ItemsIterator;


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
	public function addProcessor(ProcessorContract $processor) : ProcessorCollectionContract
	{
		$this->items[] = $processor;
		return $this;
	}

	protected function setterName(): string
	{
		return 'addProcessor';
	}

	public function hasProcessorOfType(string  $processorType): bool
	{
		/** @var Processor $processor */
		foreach ($this->items as $processor) {
			if ($processorType === $processor->getProcessorType()) {
				return true;
			}
		}
		return false;
	}
}
