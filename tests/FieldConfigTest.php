<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\Field\FieldConfig;

class FieldConfigTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::getOptions()
	 * @covers \calderawp\caldera\Forms\Field\FieldConfig::setOptions()
	 */
	public function testSetGetOptions()
	{
		$options = $this->fieldOptions();
		$config = new FieldConfig();
		$config->setOptions($options);
		$this->assertAttributeEquals($options, 'options', $config);
		$this->assertEquals($options, $config->getOptions());
	}
}
