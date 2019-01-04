<?php


namespace calderawp\caldera\Forms\Processing;

use calderawp\interop\Contracts\ProcessorContract as Processor;
use calderawp\interop\Contracts\ProcessorCollectionContract;
use calderawp\interop\Collection;

use calderawp\interop\Traits\ItemsIterator;

class ProcessorCollection extends Collection implements ProcessorCollectionContract
{

	use ItemsIterator;


	/** @inheritdoc */
	public function addProcessor(Processor $processor) : ProcessorCollectionContract
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
