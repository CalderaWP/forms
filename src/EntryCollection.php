<?php


namespace calderawp\caldera\Forms;

use calderawp\caldera\Forms\Contracts\EntryCollectionContract;
use calderawp\caldera\Forms\Contracts\EntryContract as Entry;
use calderawp\caldera\Forms\Entry\Entry as EntryModel;
use calderawp\caldera\restApi\Response;
use calderawp\interop\Contracts\Rest\RestResponseContract;
use calderawp\interop\Traits\CollectsModels;
use calderawp\interop\Traits\ItemsIterator;

class EntryCollection implements EntryCollectionContract, \IteratorAggregate
{
	use CollectsModels, ItemsIterator;

	protected function setterName(): string
	{
		return 'addEntry';
	}

	public static function fromDatabaseResults(array $results)
	{
		$obj = new static();
		foreach ($results as $key => $entry) {
			$entryObj = EntryModel::fromDatabaseResult($entry);
			$obj->addEntry($entryObj);
		}
		return $obj;
	}

	/**
	 * @inheritDoc
	 */
	public function addEntry(Entry $entry): EntryCollectionContract
	{
		$this->items[$entry->getId()] = $entry;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function removeEntry(Entry $entry): EntryCollectionContract
	{
		if ($this->has($entry->getId())) {
			unset($this->items[$entry->getId()]);
			return $this;
		}
		throw new Exception('Entry not found in collection', 404);
	}

	/**
	 * @inheritDoc
	 */
	public function hasEntry($id): bool
	{
		return $this->has($id);
	}


	/**
	 * @inheritDoc
	 */
	public function getEntry($id): Entry
	{
		if ($this->hasEntry($id)) {
			return $this->items[$id];
		}
	}

	/**
	 * @inheritDoc
	 */
	public function toResponse(): RestResponseContract
	{
		return (new Response())->setData($this->toArray());
	}
}
