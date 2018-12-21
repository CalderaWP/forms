<?php


namespace calderawp\caldera\Forms;

use calderawp\caldera\Forms\Field\FieldConfig;
use calderawp\caldera\Forms\Contracts\FieldModelContract;
use calderawp\interop\Model;
use calderawp\interop\Traits\CalderaForms\ProvidesField;
use calderawp\interop\Traits\CalderaForms\ProvidesForm;
use calderawp\interop\Traits\ProvidesDescription;
use calderawp\interop\Traits\ProvidesIdToModel;
use calderawp\interop\Traits\ProvidesLabel;
use calderawp\interop\Traits\ProvidesName;
use calderawp\interop\Traits\ProvidesSlug;
use calderawp\interop\Traits\ProvidesValue;

class FieldModel extends Model implements FieldModelContract
{
	use ProvidesValue, ProvidesField, ProvidesForm, ProvidesIdToModel, ProvidesName, ProvidesSlug,ProvidesLabel, ProvidesDescription;

	/**
	 * @var FieldConfig
	 */
	protected $fieldConfig;


	public function getFieldConfig(): FieldConfig
	{

		$this->getValue();

		if (is_null($this->fieldConfig)) {
			$this->setFieldConfig(new FieldConfig());
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
