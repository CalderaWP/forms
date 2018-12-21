<?php

namespace calderawp\caldera\Forms\Tests;

use calderawp\caldera\Forms\Something;

class SomethingTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Forms\Something::hiRoy()
	 */
	public function testHiRoy()
	{
		$this->assertEquals('Hi Roy', (new Something())->hiRoy());
	}
}
