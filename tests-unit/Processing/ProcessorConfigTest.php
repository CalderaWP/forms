<?php

namespace calderawp\caldera\Forms\Tests\Processing;

use calderawp\caldera\Forms\Processing\ProcessorConfig;
use calderawp\caldera\Forms\Tests\TestCase;

class ProcessorConfigTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Processing\ProcessorConfig
	 */
	public function testArrayAccess(){
		$config = new ProcessorConfig([ 'fieldOne' => 'x']);
		$this->assertEquals('x', $config[ 'fieldOne'] );
	}
}
