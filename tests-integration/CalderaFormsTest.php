<?php

namespace calderawp\caldera\Forms\Tests\Integration;

use calderawp\caldera\Forms\CalderaForms;
use PHPUnit\Framework\TestCase;

class CalderaFormsTest extends TestCase
{

	/**
	 * Can get this module from the container.
	 */
	public function testInCore()
	{
		$this->assertInstanceOf(CalderaForms::class, \caldera()->getCalderaForms());
	}
}
