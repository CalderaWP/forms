<?php


namespace calderawp\caldera\Forms\Processing;

use calderawp\interop\ArrayLike;

class ProcessorMeta extends ArrayLike
{

	/**
	 * Get the label for the processor
	 *
	 * @return string
	 */
	public function getLabel() : string
	{
		return $this->offsetExists('label')
		? $this->offsetGet('label')
		: '';
	}

	/**
	 * Get the type for the processor
	 *
	 * @return string
	 */
	public function getType() : string
	{
		return $this->offsetExists('type')
			? $this->offsetGet('type')
			: '';
	}
}
