<?php


namespace calderawp\caldera\Forms\Processing;

use calderawp\interop\ArrayLike;

/**
 * Class ProcessorMeta
 *
 * The meta data saved with form that makes a processor instance unique, besides its settings.
 *
 * Should include: Unique ID and processor type. Optionally meta data may include a label.
 */
class ProcessorMeta extends ArrayLike
{

	/**
	 * Get processor instance unique id.
	 *
	 * A unique ID will be returned and
	 *
	 * @return string
	 */
	public function getId() : string
	{
		if (empty($this->offsetGet('id'))) {
			$this->offsetSet('id', uniqid('p'));
		}
		return $this->offsetGet('id');
	}

	/**
	 * Set processor instance unique ID
	 *
	 * @param $id
	 *
	 * @return ProcessorMeta
	 */
	public function setId($id) : ProcessorMeta
	{
		$this->offsetSet('id', $id);
		return $this;
	}

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
