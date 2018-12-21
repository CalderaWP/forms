<?php


namespace calderawp\caldera\Forms;

use calderawp\caldera\Forms\Field\FieldConfig;
use calderawp\interop\Contracts\CalderaForms\HasField;
use calderawp\interop\Contracts\HasValue;
use calderawp\interop\Contracts\HasSlug;
use calderawp\interop\Contracts\HasLabel;
use calderawp\interop\Contracts\HasDescription;
use calderawp\interop\Contracts\CalderaForms\HasForm;
use calderawp\interop\Model;
use calderawp\interop\Traits\CalderaForms\ProvidesField;
use calderawp\interop\Traits\CalderaForms\ProvidesForm;
use calderawp\interop\Traits\ProvidesDescription;
use calderawp\interop\Traits\ProvidesIdToModel;
use calderawp\interop\Traits\ProvidesLabel;
use calderawp\interop\Traits\ProvidesName;
use calderawp\interop\Traits\ProvidesSlug;
use calderawp\interop\Traits\ProvidesValue;

class FieldModel extends Model implements HasForm, HasField, HasValue, HasSlug, HasLabel, HasDescription
{
	use ProvidesValue, ProvidesField, ProvidesForm, ProvidesIdToModel, ProvidesName, ProvidesSlug,ProvidesLabel, ProvidesDescription;


	/**
	 * @var FieldConfig
	 */
	protected $fieldConfig;
	public function getFieldConfig(): FieldConfig
	{
		if( is_null( $this->fieldConfig ) ){
			$this->setFieldConfig( new FieldConfig() );
		}
		return  $this->fieldConfig;

	}
	public function setFieldConfig(FieldConfig$fieldConfig) : FieldModel
	{
		$this->fieldConfig = $fieldConfig;
		return $this;
	}


	public function toArray(): array
	{
		$array = parent::toArray();
		$array['fieldConfig' ] = $this->getFieldConfig()->toArray();
		return $array;
	}
}
