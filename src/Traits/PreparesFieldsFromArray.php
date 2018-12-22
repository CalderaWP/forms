<?php


namespace calderawp\caldera\Forms\Traits;

use calderawp\caldera\Forms\FieldModel;
use calderawp\caldera\Forms\FieldsCollection;

trait PreparesFieldsFromArray
{
	/**
	 * @param array $items
	 *
	 * @return array
	 */
	protected static function prepareFieldsFromArray(array $items): array
	{
		if (isset($items[ 'fields' ])) {
			if (is_array($items[ 'fields' ])) {
				foreach ($items[ 'fields' ] as $fieldIndex => $field) {
					if (is_array($field)) {
						$items[ 'fields' ][ $fieldIndex ] = FieldModel::fromArray($field);
					}
				}
			}

			if (is_array($items[ 'fields' ])) {
				$collection = new FieldsCollection();
				foreach ($items[ 'fields' ] as $fieldIndex => $field) {
					$collection->addField($field);
				}
				$items[ 'fields' ] = $collection;
			}
		}
		return $items;
	}
}
