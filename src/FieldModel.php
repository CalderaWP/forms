<?php


namespace calderawp\caldera\Forms;

use calderawp\caldera\Forms\Field\FieldConfig;
use calderawp\caldera\Forms\Contracts\FieldModelContract;
use calderawp\interop\Contracts\Interoperable;
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
	 * @var string
	 */
	protected $type;


	/**
	 * @var FieldConfig
	 */
	protected $fieldConfig;
	public function getType(): string
	{
		return is_string($this->type) ? $this->type : 'text';
	}

	/** @inheritdoc */
	public function getSlug(): string
	{
		return is_string($this->slug) ? $this->slug : $this->id;
	}

	public function setType(string $type): FieldModelContract
	{
		$this->type = $type;
		return $this;
	}

	public static function fromArray(array $items): Interoperable
	{
		if (isset($items['fieldConfig']) && is_array($items['fieldConfig'])) {
			$items['fieldConfig'] = FieldConfig::fromArray($items['fieldConfig']);
		}

		/** @var FieldModel $obj */
		$obj = parent::fromArray($items);
		if (isset($items[ 'html5type' ])) {
			$obj->getFieldConfig()->setOtherConfigOption('html5type', $items['html5type']);
		}
		if (isset($items[ 'attributes' ])) {
			$obj->getFieldConfig()->setOtherConfigOption('attributes', $items['attributes']);
		}
		return $obj;
	}

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
