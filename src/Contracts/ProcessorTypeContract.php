<?php


namespace calderawp\caldera\Forms\Contracts;

interface ProcessorTypeContract
{
	/**
	 * Get the processor type
	 *
	 * @return string
	 */
	public function getProcessorType() : string;

	/**
	 * Get any process callbacks
	 *
	 * @return array
	 */
	public function getCallbacks() : array;
}
