<?php


namespace calderawp\caldera\Forms;

use calderawp\caldera\Forms\Contracts\FormModelContract as Form;
use calderawp\caldera\Forms\Contracts\EntryContract as Entry;
use calderawp\caldera\Forms\Contracts\CollectsEntryValues as EntryValues;
use calderawp\caldera\Forms\Contracts\EntryCollectionContract as EntryCollection;
use calderawp\caldera\Forms\Contracts\FormsCollectionContract as FormsCollection;

use WpDbTools\Type\Result;

class ResultHandlers
{


	public function toFormModel(Result $result): Form
	{
	}

	public function toFormCollection(Result $result): FormsCollection
	{
	}

	public function toEntryModel(Result $result) : Entry
	{
	}

	public function toEntryCollection(Result $result): EntryCollection
	{
	}


	public function toEntryValues(Result $result) : EntryValues
	{
	}
}
